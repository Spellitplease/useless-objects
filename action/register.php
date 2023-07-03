<?php

require_once '../include/database.php';
session_start();

if (isset($_POST['inscription'])) {
    // on verifie que les champs ne sont pas vides
    if (!empty($_POST['nom']) && !empty($_POST['mail']) && !empty($_POST['mp'])) {
        // on recupere les données du formulaire
        $nom = htmlspecialchars($_POST['nom']);
        $mail = htmlspecialchars($_POST['mail']);
        $mp = htmlspecialchars($_POST['mp']);

        // on verifie que l'utilisateur n'existe pas dans la base de données
        $query = "SELECT * FROM utilisateur WHERE mail = :mail";
        $statement = $pdo->prepare($query);
        $statement->bindValue(':mail', $mail);
        $statement->execute();
        $user = $statement->fetch();

        // si l'utilisateur existe on affiche un message d'erreur
        if ($user) {
            session_start();
            $_SESSION['flash']['danger'] = "Cette adresse mail est déjà utilisée";
            header('Location: ../page/inscription.php');
            exit();
        } else { // sinon on l'ajoute dans la base de données
            // Le mot de passe est hashé avant d'être stocké dans la base de données
            $mp_hash = password_hash($mp, PASSWORD_DEFAULT);

            $query = "INSERT INTO utilisateur (nom, mail, mp, role, isActive) VALUES (:nom, :mail, :mp, :role, :isActive)";
            $statement = $pdo->prepare($query);
            $statement->bindValue(':nom', $nom);
            $statement->bindValue(':mail', $mail);
            $statement->bindValue(':mp', $mp_hash);
            $statement->bindValue(':role', 0);
            $statement->bindValue(':isActive', 1);
            $statement->execute();

            // on affiche un message de succès
            if (!isset($_SESSION['admin'])) {
                session_start();
                $_SESSION['flash']['success'] = "Votre compte a bien été créé !";
                header('Location: ../page/connexion.php');
                exit();
            } else {
                $_SESSION['flash']['success'] = "L'utilisateur a bien été ajouté !";
                header('Location: ../page/admin.php');
                exit();
            }
        }
    }
}
