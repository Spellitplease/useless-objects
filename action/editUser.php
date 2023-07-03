<?php

require_once '../include/database.php';

session_start();

// on récupère l'id de l'utilisateur dans l'url
$id = $_GET['id'];

// on récupère les données du formulaire
if (isset($_POST['edit'])) {
    $nom = $_POST['nom'];
    $mail = $_POST['mail'];
    $mp = $_POST['mp'];
    $mpCrypte = password_hash($mp, PASSWORD_DEFAULT);
    $avatar = "";

    if (empty($mp)) {
        $_SESSION['flash']['error'] = "Veuillez saisir votre mot de passe.";
        header("Location: ../page/profil.php?id=" . $id);
        exit();
    }

    // Vérification si un fichier est sélectionné
    if ($_FILES['avatar']['name']) {
        $avatar = $_FILES['avatar']['name'];
        $avatar_tmp = $_FILES['avatar']['tmp_name'];

        // Déplace le fichier temporaire vers le répertoire de destination
        move_uploaded_file($avatar_tmp, "../images/" . $avatar);
        $avatar_path = "../images/" . $avatar;
    } else {
        // Aucun fichier sélectionné, utilise l'avatar existant
        $avatar_path = $user->avatar; // Assurez-vous que $user est correctement récupéré avant cette ligne
    }

    // si l'utilisateur est un admin
    if (isset($_SESSION['admin'])) {
        // on récupère le rôle de l'utilisateur
        $role = intval($_POST['role']);
        // on modifie l'utilisateur dans la base de données
        $query = "UPDATE utilisateur SET nom = :nom, mail = :mail, mp = :mp, avatar = :avatar WHERE idutilisateur = :id";
        $statement = $pdo->prepare($query);
        $statement->execute([
            ':nom' => $nom,
            ':mail' => $mail,
            ':mp' => $mpCrypte,
            ':avatar' => $avatar_path,
            ':id' => $id
        ]);

        $_SESSION['flash']['success'] = "L'utilisateur " . $nom . " a bien été modifié";
        header("Location: ../page/admin.php");
        exit();
    } else { // sinon on modifie l'utilisateur dans la base de données
        $query = "UPDATE utilisateur SET nom = :nom, mail = :mail, mp = :mp, avatar = :avatar WHERE idutilisateur = :id";
        $statement = $pdo->prepare($query);
        $statement->execute([':nom' => $nom, ':mail' => $mail, ':mp' => $mpCrypte, ':avatar' => $avatar_path, ':id' => $id]);
        // on reset la session pour mettre à jour les données de l'utilisateur
        session_reset();
        // on récupère les données de l'utilisateur mis à jour
        $query = "SELECT * FROM utilisateur WHERE idutilisateur = :id";
        $statement = $pdo->prepare($query);
        $statement->execute([':id' => $id]);
        $user = $statement->fetch(PDO::FETCH_OBJ);
        // on met à jour la session
        $_SESSION['utilisateur'] = $user;
        $_SESSION['flash']['success'] = "Votre compte a bien été modifié";
        // on redirige l'utilisateur vers sa page de profil
        header("Location: ../page/profil.php?id=" . $_SESSION['utilisateur']->idutilisateur);
        exit();
    }
}
