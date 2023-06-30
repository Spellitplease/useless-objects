<?php

require_once '../include/database.php';

session_start();
// on recupere l'id de l'utilisateur dans l'url
$id = $_GET['id'];
// on supprime l'utilisateur de la base de données
$query = "DELETE FROM utilisateur WHERE idutilisateur = :id";
$statement = $pdo->prepare($query);
$statement->execute([':id' => $id]);
// si l'utilisateur est un admin on le redirige vers la page admin
if (isset($_SESSION['admin'])) {

	$_SESSION['flash']['danger'] = "L'utilisateur a bien été supprimé";
	header("Location: ../page/admin.php");
	exit();

} else { // sinon on le redirige vers la page d'accueil

	session_destroy();
	$_SESSION['flash']['danger'] = "Votre compte a bien été supprimé";
	header("Location: ../index.php");
	exit();

}
