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
	<title>Inscription</title>
</head>

<body>
	<?php include 'menu.php'; ?>
	<div class="container-fluid">
		<?php if (isset($_SESSION['flash'])) : ?>
			<?php foreach ($_SESSION['flash'] as $type => $message) : ?>
				<div class="ms-1 me-3 alert alert-<?= $type; ?>">
					<?= $message; ?>
				</div>
			<?php endforeach; ?>
			<?php unset($_SESSION['flash']); ?>
		<?php endif; ?>
		<h1>Inscription</h1>
		<form action="../action/register.php" method="post">

			<div class="m-2"><label for="nom">Votre nom</label>
				<input type="text" name="nom">
			</div>

			<div class="m-2"><label for="mail">Votre email</label>
				<input type="email" name="mail">
			</div>

			<div class="m-2"><label for="mp">Votre mot de passe</label>
				<input type="password" name="mp">
			</div>

			<div class="m-2"><input type="submit" value="Envoyer" name="inscription"></div>
		</form>
	</div>

</body>

</html>