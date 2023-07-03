<?php

require_once '../include/database.php';

if (isset($_POST['connexion'])) {
    // on verifie que les champs ne sont pas vides
    if (!empty($_POST['mail']) && !empty($_POST['mp'])) {

        // on recupere les données du formulaire
        $mail = htmlspecialchars($_POST['mail']);
        $mp = htmlspecialchars($_POST['mp']);

        // on verifie que l'utilisateur existe dans la base de données
        $query = "SELECT * FROM utilisateur WHERE mail = :mail";

        $statement = $pdo->prepare($query);
        $statement->bindValue(':mail', $mail);
        $statement->execute();

        $user = $statement->fetch(PDO::FETCH_OBJ);

        // si l'utilisateur existe on le connecte
        if ($user && password_verify($mp, $user->mp)) {

            session_start();
            // si l'utilisateur est un admin on le connecte en tant qu'admin
            if ($user->role == 1) {

                $_SESSION['admin'] = $user;
                $_SESSION['flash']['success'] = "Vous êtes connecté en tant qu'administrateur";
                header('Location: ../page/admin.php');
                exit();

            } else { // sinon on le connecte en tant qu'utilisateur

                $_SESSION['utilisateur'] = $user;
                $_SESSION['flash']['success'] = "Vous êtes connecté";
                header('Location: ../page/profil.php?id='. $_SESSION['utilisateur']->idutilisateur);
                exit();

            }
        } else { // sinon on affiche un message d'erreur

            session_start();
            $_SESSION['flash']['danger'] = "Identifiants ou mot de passe incorrects";
            header('Location: ../page/connexion.php');
            exit();
        }
    }
}
