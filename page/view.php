<!--affichage des listes de souhaits par utilisateur-->
<!DOCTYPE html>
<html>
<head>
    <title>Affichage des articles</title>
<body>
  <?php
$pdo = new PDO('mysql:host=localhost;dbname=souhait', 'root', '', [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
]);

$query = "SELECT * FROM utilisateur";
$statement = $pdo->query($query);
$utilisateurs = $statement->fetchAll(PDO::FETCH_ASSOC);

foreach ($utilisateurs as $utilisateur) {
    echo '<div class="utilisateur">';
    echo '<h2>Utilisateur : ' . $utilisateur['nom'] . '</h2>';

    $query = "SELECT * FROM listeSouhait WHERE utilisateur_idutilisateur = :utilisateur_id";
    $statement = $pdo->prepare($query);
    $statement->bindValue(':utilisateur_id', $utilisateur['idutilisateur']);
    $statement->execute();
    $listesSouhaits = $statement->fetchAll(PDO::FETCH_ASSOC);

    foreach ($listesSouhaits as $listeSouhait) {
        echo '<div class="liste-souhait">';
        echo '<h3>Liste de souhaits : ' . $listeSouhait['nom'] . '</h3>';

        $query = "SELECT article.* FROM article
                      JOIN listeSouhait_has_article ON article.idarticle = listeSouhait_has_article.article_idarticle
                      WHERE listeSouhait_has_article.listeSouhait_idlisteSouhait = :listeSouhait_id";
        $statement = $pdo->prepare($query);
        $statement->bindValue(':listeSouhait_id', $listeSouhait['idlisteSouhait']);
        $statement->execute();
        $articles = $statement->fetchAll(PDO::FETCH_ASSOC);

        foreach ($articles as $article) {
            echo '<div class="article">';
            echo '<p>Nom : ' . $article['nom'] . '</p>';
            echo '<p>Description : ' . $article['description'] . '</p>';
            echo '</div>';
        }

        echo '</div>'; // Fin de la liste de souhaits
    }

    echo '</div>'; // Fin de l'utilisateur
}
?>

</body>
</html>

