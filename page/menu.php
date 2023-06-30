<nav class="navbar navbar-expand-lg bg-light">
	<div class="container-fluid">
		<a class="navbar-brand" href="#">Navbar</a>
		<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarNav">
			<ul class="navbar-nav">
				<li class="nav-item">
					<a class="nav-link" href="../index.php"><i class="bi bi-house-door-fill"></i> Home</a>
				</li>
				<?php if (isset($_SESSION['utilisateur'])) : ?>
					<li class="nav-item">
						<a class="nav-link" href="profil.php?id=<?= $_SESSION['utilisateur']->idutilisateur ?>"><i class="bi bi-person-lines-fill"></i> Profil</a>
					</li>
				<?php endif; ?>
				<?php if (isset($_SESSION['admin'])) : ?>
					<li class="nav-item">
						<a class="nav-link" href="admin.php"><i class="bi bi-database-gear"></i> Admin</a>
					</li>
				<?php endif; ?>
				<?php if (!isset($_SESSION['admin']) && !isset($_SESSION['utilisateur'])) : ?>
					<li class="nav-item">
						<a class="nav-link" href="connexion.php"><i class="bi bi-box-arrow-in-right"></i> Connexion</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="inscription.php"><i class="bi bi-pencil-square"></i> Inscription</a>
					</li>
				<?php endif; ?>
				<?php if (isset($_SESSION['admin']) || isset($_SESSION['utilisateur'])) : ?>
					<li class="nav-item">
						<a class="nav-link" href="../action/logout.php"><i class="bi bi-box-arrow-right"></i> Logout</a>
					</li>
				<?php endif; ?>
			</ul>
		</div>
	</div>
</nav>