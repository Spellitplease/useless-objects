<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
	<link rel="stylesheet" href="node_modules/bootstrap-icons/font/bootstrap-icons.css">
	<link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="css/style.css">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
	<title>Accueil</title>
</head>

<body>
	<nav class="navbar navbar-expand-lg bg-light">
		<div class="container-fluid ">
			<a class="navbar-brand" href="#">Navbar</a>
			<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarNav">
				<ul class="navbar-nav">
					<li class="nav-item">
						<a class="nav-link" href="index.php"><i class="bi bi-house-door-fill"></i> Home</a>
					</li>
					<?php if (!isset($_SESSION['admin']) && !isset($_SESSION['utilisateur'])) : ?>
						<li class="nav-item">
						<a class="nav-link" href="page/connexion.php"><i class="bi bi-box-arrow-in-right"></i> Connexion</a>
					</li>
						<li class="nav-item">
						<a class="nav-link" href="page/inscription.php"><i class="bi bi-pencil-square"></i> Inscription</a>
					</li>
					<?php endif; ?>
					<?php if (isset($_SESSION['utilisateur'])) : ?>
						<li class="nav-item">
							<a class="nav-link" href="page/profil.php?id=<?= $_SESSION['utilisateur']->idutilisateur ?>"><i class="bi bi-person-lines-fill"></i> Profil</a>
						</li>
					<?php endif; ?>
					<?php if (isset($_SESSION['utilisateur'])) : ?>
						<li class="nav-item">
							<a class="nav-link" href="page/wishlist.php?id=<?= $_SESSION['utilisateur']->idutilisateur ?>"><i class="bi bi-card-text"></i> Ma liste</a>
						</li>
					<?php endif; ?>
					
					<?php if (isset($_SESSION['admin'])) : ?>
						<li class="nav-item">
							<a class="nav-link" href="page/admin.php"><i class="bi bi-database-gear"></i> Admin</a>
						</li>
					<?php endif; ?>
					<?php if (isset($_SESSION['admin']) || isset($_SESSION['utilisateur'])) : ?>
						<li class="nav-item">
							<a class="nav-link" href="action/logout.php"><i class="bi bi-box-arrow-right"></i> Logout</a>
						</li>
					<?php endif; ?>
				</ul>
			</div>
			
		</div>
	</nav>
	<div class="container-fluid pt-3" style="height:100vh;">
		<?php if (isset($_SESSION['flash'])) : ?>
			<?php foreach ($_SESSION['flash'] as $type => $message) : ?>
				<div class="m-3 p-3 alert alert-<?= $type; ?>">
					<?= $message; ?>
				</div>
			<?php endforeach; ?>
			<?php unset($_SESSION['flash']); ?>
		<?php endif; ?>
	<div class="main">	
		<h1 class="intro">Satané Back-End</h1>
	
	<div class="article">
		<?php
		include('include/article.php');
		?>
	</div> 
	</div

	
	

</body>

</html>
