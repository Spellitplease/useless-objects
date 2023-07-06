<?php

require_once '../include/database.php';
require_once '../include/function.php';

logged_only();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données du formulaire
    $nom = $_POST['nom'];
    $description = $_POST['description'];
    $utilisateur_id = $_SESSION['utilisateur']->idutilisateur;

    // Insérer la liste de souhaits dans la base de données
    $query = "INSERT INTO listesouhait (nom, description, createdAt, Utilisateur_idUtilisateur)
              VALUES (:nom, :description, NOW(), :utilisateur_id)";
    $statement = $pdo->prepare($query);
    $statement->execute([
        ':nom' => $nom,
        ':description' => $description,
        ':utilisateur_id' => $utilisateur_id
    ]);

    $listeSouhaitId = $pdo->lastInsertId(); // Récupérer l'ID de la liste de souhaits insérée

    // Récupérer les objets sélectionnés dans le menu déroulant
    if (isset($_POST['objets'])) {
        $objets = $_POST['objets'];

        // Insérer les objets sélectionnés dans la table de liaison "listesouhait_has_article"
        foreach ($objets as $objet) {
            $query = "INSERT INTO listesouhait_has_article (listeSouhait_idlisteSouhait, article_idarticle)
                      VALUES (:listeSouhaitId, :articleId)";
            $statement = $pdo->prepare($query);
            $statement->execute([
                ':listeSouhaitId' => $listeSouhaitId,
                ':articleId' => $objet
            ]);
        }
    }

    // Rediriger vers la page de liste de souhaits ou afficher un message de succès
    header("Location: preview.php");
    exit();
}

// Récupérer la liste des objets à afficher dans le menu déroulant
$query = "SELECT * FROM article";
$statement = $pdo->query($query);
$objets = $statement->fetchAll(PDO::FETCH_ASSOC);
?>

<!--HTML-->
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include('../link/liens.php');?>
    <title>Créer une liste de souhaits</title>
    
</head>

<body>
    
    
     <?php include 'menu.php'; ?>
    
    
<div class="container">
    <h1>Créer une liste de souhaits</h1>
    <form class="selection" method="post" action="">
        <div>
            <label for="nom">Nom :</label>
            <input type="text" name="nom" id="nom" required>
        </div>
        <div>
            <label for="description">Description :</label>
            <textarea name="description" id="description" required></textarea>
        </div>
        <div>
        <label for="objets">Sélectionnez les objets :</label>
        <select name="objets[]" id="objets">
            <?php foreach ($objets as $objet) : ?>
                <option value="<?= $objet['idarticle'] ?>"><?= $objet['nom'] ?></option>
            <?php endforeach; ?>
        </select>
        <button type="button" onclick="ajouterObjet()">Ajouter</button>
    </div>
          <button type="submit">Prévisualiser</button>
    </form>

    <?php if ($_SERVER['REQUEST_METHOD'] === 'POST') : ?>
        <?php
        $previsualisation = true;
        // Récupérer les données soumises du formulaire
        $nom = $_POST['nom'];
        $description = $_POST['description'];
        $objets_selectionnes = isset($_POST['objets']) ? $_POST['objets'] : [];

        // Prévisualisation des objets sélectionnés
        $listeSouhait = [
            'nom' => $nom,
            'description' => $description,
            'objets' => []
        ];

        foreach ($objets_selectionnes as $objet_id) {
            // Récupérer les détails de l'objet à partir de la base de données
            // et les ajouter au tableau des objets de la liste de souhaits
            $query = "SELECT * FROM article WHERE idarticle = :objet_id";
            $statement = $pdo->prepare($query);
            $statement->bindValue(':objet_id', $objet_id);
            $statement->execute();
            $objet = $statement->fetch(PDO::FETCH_ASSOC);

            if ($objet) {
                $listeSouhait['objets'][] = $objet;
            }
        }
        ?>
<?php endif; ?>
</div>

    
<script src="../js/main.js"></script>
</body>
</html>




