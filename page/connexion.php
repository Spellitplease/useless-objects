<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="../css/style.css">
	<?php include 'base.php'; ?>
	<title>Connexion</title>
</head>

<body>
	<?php include 'menu.php'; ?>
	<div class="container-fluid m-3">
		<!-- on affiche les messages d'erreur -->
		<?php if (isset($_SESSION['flash'])) : ?>
			<?php foreach ($_SESSION['flash'] as $type => $message) : ?>
				<div class="m-3 p-3 alert alert-<?= $type; ?>">
					<?= $message; ?>
				</div>
			<?php endforeach; ?>
			<?php unset($_SESSION['flash']); ?>
		<?php endif; ?>
		<div class="enter">
		<h1>Connexion</h1>
		<form class="connect" action="../action/login.php" method="post">

			<div class=""><label for="mail">Votre email</label>
				<input type="email" name="mail">
			</div>

			<div class=""><label for="mp">Votre mot de passe</label>
				<input type="password" name="mp">
			</div>

			<div class=""><input type="submit" value="Envoyer" name="connexion"></div>

		</form>
	</div>
	
	</div>

</body>

</html>