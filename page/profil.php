<?php

require_once '../include/function.php';
require_once '../include/database.php';

logged_only();

?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="../css/style.css">
	<?php include 'base.php'; ?>
	<title>Utilisateur | Profile</title>
</head>

<body>
	<?php include 'menu.php'; ?>
	<div class="container-fluid m-5">
		<?php if (isset($_SESSION['flash'])) : ?>
			<?php foreach ($_SESSION['flash'] as $type => $message) : ?>
				<div class="m-3 p-3 alert alert-<?= $type; ?>">
					<?= $message; ?>
				</div>
			<?php endforeach; ?>
			<?php unset($_SESSION['flash']); ?>
		<?php endif; ?>
		<h1>Bienvenue <?= $_SESSION['utilisateur']->nom ?></h1>
		<p><?= $_SESSION['utilisateur']->mail ?></p>

		<!-- affichage de l'avatar -->
		<?php if (isset($_SESSION['utilisateur']->avatar)) : ?>
			<img src="<?= $_SESSION['utilisateur']->avatar ?>" alt="Avatar" style="width:200px; border-radius: 50%; margin-bottom: 50px;">
		<?php endif; ?>

		<p>
			<a href="editionUser.php?id=<?= $_SESSION['utilisateur']->idutilisateur ?>" class="btn btn-primary"><i class="bi bi-pencil-square"></i> Edit</a>
			<a href="../action/deleteUser.php?id=<?= $_SESSION['utilisateur']->idutilisateur ?>" onclick="return window.confirm(`Êtes vous sûr de vouloir supprimer cet utilisateur ?!`)" class="btn btn-danger" data-toggle="modal"><i class="bi bi-trash3-fill"></i> Delete</a>
		</p>
	</div>

</body>

</html>