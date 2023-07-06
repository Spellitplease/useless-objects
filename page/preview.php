<?php
include('../link/liens.php');
include ('../include/function.php');


$previsualisation = false; // Initialise la variable $previsualisation

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    $nom = isset($_POST['nom']) ? $_POST['nom'] : '';
    $description = isset($_POST['description']) ? $_POST['description'] : '';
    $objets_selectionnes = isset($_POST['objets']) ? $_POST['objets'] : [];

    // Préparer les données pour la prévisualisation
    $listeSouhait = [
        'nom' => $nom,
        'description' => $description,
        'objets' => []
    ];

    // Récupérer les détails des objets sélectionnés
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

    $previsualisation = true; // Définir $previsualisation à true après la préparation des données
}

include 'menu.php';
?>

<div class="previsualisation">
    <?php if ($previsualisation && !empty($listeSouhait['objets'])) : ?>
        <h2>Prévisualisation de la liste de souhaits :</h2>
        <h3>Nom : <?= $listeSouhait['nom'] ?></h3>
        <p>Description : <?= $listeSouhait['description'] ?></p>
        <h3>Objets :</h3>
        <?php foreach ($listeSouhait['objets'] as $objet) : ?>
            <div>
                <p>Nom : <?= $objet['nom'] ?></p>
                <p>Description : <?= $objet['description'] ?></p>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
