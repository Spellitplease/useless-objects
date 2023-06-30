<?php

require_once '../include/database.php';
require_once '../include/function.php';

// on verifie que l'utilisateur est connecté
logged_only();



if ($_SESSION['admin']-> role != 1) {
    header("Location: profil.php");
    exit();
}

// si la session != 1
	// alor redirection soit profil, soit deconnexion

// on recupere tous les utilisateurs
$query = "SELECT * FROM utilisateur";
$statement = $pdo->prepare($query);
$statement->execute();
$users = $statement->fetchAll(PDO::FETCH_OBJ);


?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php include 'base.php'; ?>
	<title>Admin</title>
</head>

<body>
	<?php include 'menu.php'; ?>
	<div class="container-fluid">
		<h1>Gestion des utilisateurs</h1>
		<h2>Bonjour administrateur: <?= $_SESSION['admin']->nom ?></h2>
		<a href="../page/inscription.php" class="btn btn-primary">Ajouter un utilisateur</a>
		<!-- on affiche les messages flash -->
		<?php if (isset($_SESSION['flash'])) : ?>
			<?php foreach ($_SESSION['flash'] as $type => $message) : ?>
				<div class="m-3 p-3 alert alert-<?= $type; ?>">
					<?= $message; ?>
				</div>
			<?php endforeach; ?>
			<?php unset($_SESSION['flash']); ?>
		<?php endif; ?>
		<table class="table">
			<thead>
				<tr>
					<th scope="col">Nom</th>
					<th scope="col">mail</th>
					<th scope="col">mp</th>
					<th scope="col">role</th>
					<th scope="col">action</th>
				</tr>
			</thead>
			<tbody>
				<!-- on affiche tous les utilisateurs -->
				<?php foreach ($users as $user) : ?>
					<tr>
						<td><?= $user->nom ?></td>
						<td><?= $user->mail ?></td>
						<td><?= $user->mp ?></td>
						<td><?= $user->role ?></td>
						<td><a href="editionUser.php?id=<?= $user->idutilisateur ?>" class="btn btn-primary"><i class="bi bi-pencil-square"></i> Edit</a>
							<br><a href="../action/deleteUser.php?id=<?= $user->idutilisateur ?>" onclick="return window.confirm(`Êtes vous sûr de vouloir supprimer cet utilisateur ?!`)" class="btn btn-danger" data-toggle="modal"><i class="bi bi-trash3-fill"></i> Delete</a>
						</td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>

</body>

</html>