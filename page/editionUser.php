<?php
require_once '../include/database.php';
require_once '../include/function.php';

logged_only();


$id = $_GET['id'];

$query = "SELECT * FROM utilisateur WHERE idutilisateur = :id";
$statement = $pdo->prepare($query);
$statement->execute([':id' => $id]);
$user = $statement->fetch(PDO::FETCH_OBJ);
?>

<!DOCTYPE html>
<html lang="en">
<link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
<link rel="stylesheet" href="../css/style.css">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
<title>Edit | User</title>
</head>



	<body>
		<?php include 'menu.php'; ?>
	<div class="profile">
	            <h1>Profil Utilisateur</h1>
		<div class="container">
			<form class="me" method="post" action="../action/editUser.php?id=<?= $user->idutilisateur ?>">
				<div class="avatar">
					<img id="avatar-preview" src="../images/neutre.jpg" alt="Avatar">
					<label class="face" for="avatar-input">Changer d'avatar</label>
					<input class="folder" type="file" id="avatar-input" name="avatar-input" value="change">
					
				</div>
				<div class="champ">
					<label for="nom">Votre nom:</label>
					<input class="fillin" type="text" name="nom" value="<?= $user->nom ?>">
				</div>
	
				<div class="champ">
					<label for="mail">Votre email</label>
					<input class="fillin" type="text" name="mail" value="<?= $user->mail ?>">
				</div>
	
				<div class="champ">
					<label for="mp">Votre mot de passe</label>
					<input class="fillin" type="password" name="mp" value="">
				</div>
			
				<?php if (isset($_SESSION['admin'])) : ?>
					<div class="champ"><label for="role">Votre role</label>
						<input type="number" name="role" value="<?= $user->role ?>">
					</div>
				<?php endif; ?>
				<input type="submit" name="edit" value="éditer">
			</form>
		</div>
	</div>
	<script src ="../js/main.js"></script>
	</body>
	
	</html>
