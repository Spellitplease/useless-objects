<?php

$pdo = new PDO('mysql:host=localhost;dbname=souhait', 'root', '', [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
]);


$isAdmin = false;
if (isset($_SESSION['utilisateur']) && $_SESSION['utilisateur']->role === 'admin') {
    $isAdmin = true;
}



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['comment']) && isset($_POST['idcommentaire'])) {
        $comment = $_POST['comment'];
        $idcommentaire = $_POST['idcommentaire'];

        // Insert the comment into the database
        $query = "INSERT INTO commentaire (description, idcommentaire) VALUES (:description, :idcommentaire)";
        $statement = $pdo->prepare($query);
        $statement->bindValue(':description', $comment);
        $statement->bindValue(':idcommentaire', $idcommentaire);
        $statement->execute();
    }
}

$query = "SELECT * FROM utilisateur";
$statement = $pdo->query($query);
$utilisateurs = $statement->fetchAll(PDO::FETCH_ASSOC);

foreach ($utilisateurs as $utilisateur) {
    echo '<div class="utilisateur">';
    echo '<h2>Utilisateur : ' . $utilisateur['nom'] . '</h2>';

    // Afficher l'avatar de l'utilisateur s'il existe
    if (!empty($utilisateur['avatar']) && $utilisateur['avatar'] !== null) {
        echo '<img style="width: 200px; border-radius: 50%" src="' . $utilisateur['avatar'] . '" alt="Avatar" >';
    }

    $query = "SELECT * FROM listeSouhait WHERE utilisateur_idutilisateur = :utilisateur_id";
    $statement = $pdo->prepare($query);
    $statement->bindValue(':utilisateur_id', $utilisateur['idutilisateur']);
    $statement->execute();
    $listesSouhaits = $statement->fetchAll(PDO::FETCH_ASSOC);
    

    foreach ($listesSouhaits as $listeSouhait) {
        echo '<div class="liste-souhait" style="margin-bottom: 100px;">';
        echo '<h3>Liste de souhaits : ' . $listeSouhait['nom'] . '</h3>';

        $query = "SELECT * FROM utilisateur WHERE idutilisateur = :utilisateur_id";
        $statement = $pdo->prepare($query);
        $statement->bindValue(':utilisateur_id', $listeSouhait['Utilisateur_idUtilisateur']);
        $statement->execute();
        $user = $statement->fetch(PDO::FETCH_ASSOC);

        echo '<p class="when" style="color: darkslategray; font-weight: 600;">Date de création : ' . $listeSouhait['createdAt'] . '</p>';

        $query = "SELECT article.* FROM article
                  JOIN listeSouhait_has_article ON article.idarticle = listeSouhait_has_article.article_idarticle
                  WHERE listeSouhait_has_article.listeSouhait_idlisteSouhait = :listeSouhait_id";
        $statement = $pdo->prepare($query);
        $statement->bindValue(':listeSouhait_id', $listeSouhait['idlisteSouhait']);
        $statement->execute();
        $articles = $statement->fetchAll(PDO::FETCH_ASSOC);

        foreach ($articles as $article) {
            echo '<div class="article">';
            echo '<p class="objet" style="font-weight: bold">' . $article['nom'] . ' :</p>';
            echo '<p>Koikesdon : ' . $article['description'] . '</p>';
            echo '</div>';
        }

        $query = "SELECT * FROM commentaire WHERE idcommentaire = :idcommentaire";
        $statement = $pdo->prepare($query);
        $statement->bindValue(':idcommentaire', $listeSouhait['idlisteSouhait']);
        $statement->execute();
        $comments = $statement->fetchAll(PDO::FETCH_ASSOC);

        foreach ($comments as $comment) {
            echo '<div class="comment" style="color: darkslategray ;font-weight:bold;">';
            echo '<p class="phrase" style="width:50%; font-weight:lighter;">' . $comment['description'] . '</p>';
            echo '</div>';
        }

        // Afficher le bouton de suppression pour l'utilisateur admin
        if ($isAdmin) {
            echo '<button class="btn btn-danger" style="margin-bottom: 10px;" onclick="deleteListe(' . $listeSouhait['idlisteSouhait'] . ')">Supprimer</button>';
        }

        echo '<button class="btn btn-primary" style="margin-bottom: 30px;" onclick="showCommentForm(' . $listeSouhait['idlisteSouhait'] . ')">Commenter</button>';
        echo '<div id="commentForm' . $listeSouhait['idlisteSouhait'] . '" style="display: none;">';
        echo '<form method="post" action="">'; 
        echo '<textarea name="comment" rows="4" cols="50" placeholder="Saisissez votre commentaire ici"></textarea>';
        echo '<input type="hidden" name="idcommentaire" value="' . $listeSouhait['idlisteSouhait'] . '">';
        echo '<input type="submit" value="Submit Comment">';
        echo '</form>';
        echo '</div>';

        echo '</div>'; // Fin de la liste de souhaits
    }

    echo '</div>'; // Fin de l'utilisateur
}
?>
<script>
    function showCommentForm(id) {
        var commentForm = document.getElementById('commentForm' + id);
        commentForm.style.display = 'block';
    }

    function deleteListe(id) {
        if (confirm("Êtes-vous sûr de vouloir supprimer cette liste de souhaits ?")) {
            window.location.href = "delete_liste.php?id=" + id;
        }
    }
</script>

