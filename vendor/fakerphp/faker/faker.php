<?php

require_once 'vendor/autoload.php';
require_once 'include/database.php';

use Faker\Factory;

$faker = Factory::create();

function getRandomKeyValue($array) {
    $keys = array_keys($array); // Récupérer toutes les clés du tableau
    $randomKey = $keys[array_rand($keys)]; // Sélectionner une clé aléatoirement
    $randomValue = $array[$randomKey]; // Récupérer la valeur correspondante à la clé

    return array('clé' => $randomKey, 'valeur' => $randomValue);
}

$articles = array(
    'velo' => 'Un vélo de haute qualité pour vos balades en plein air.',
    'bague' => 'Une magnifique bague en argent incrustée de diamants.',
    'voyage' => 'Un voyage de rêve dans une destination exotique de votre choix.',
    'chaussures' => 'Des chaussures élégantes et confortables pour toutes les occasions.',
    'livre' => 'Un best-seller captivant qui vous emmènera dans un autre monde.',
    'montre' => 'Une montre sophistiquée avec un design élégant et des fonctionnalités avancées.',
    'ordinateur' => 'Un ordinateur portable puissant pour répondre à tous vos besoins informatiques.',
    'parfum' => 'Un parfum envoûtant qui laisse une trace de séduction partout où vous allez.',
    'appareil photo' => 'Un appareil photo professionnel pour capturer des moments précieux.',
    'sac à dos' => 'Un sac à dos spacieux et résistant pour vos aventures en plein air.',
    'chemise' => 'Une chemise de qualité supérieure avec un style intemporel.',
    'bracelet' => 'Un bracelet élégant et raffiné pour compléter votre tenue.',
    'téléphone' => 'Un smartphone dernier cri avec des performances exceptionnelles.',
    'console de jeux' => 'Une console de jeux pour des heures de divertissement interactif.',
    'maquillage' => 'Une collection complète de maquillage pour sublimer votre beauté naturelle.',
    'couteau suisse' => 'Un couteau polyvalent et compact avec de nombreuses fonctionnalités.',
    'casque audio' => 'Un casque audio sans fil pour profiter de votre musique avec une qualité sonore exceptionnelle.',
    'carte cadeau' => 'Une carte cadeau flexible pour offrir la liberté de choisir.',
    'pantalon' => 'Un pantalon élégant et confortable pour toutes les occasions.',
    'jouet' => 'Un jouet éducatif amusant pour divertir et stimuler l\'imagination des enfants.',
    'rasoir électrique' => 'Un rasoir électrique performant pour une peau lisse et soignée.',
    'cafetière' => 'Une cafetière automatique pour savourer un délicieux café à tout moment de la journée.',
    'enceinte portable' => 'Une enceinte portable pour profiter de votre musique préférée n\'importe où.',
    'bouteille de vin' => 'Une bouteille de vin raffinée pour accompagner vos repas et célébrations.',
    'tapis de yoga' => 'Un tapis de yoga antidérapant pour pratiquer vos exercices de relaxation.',
    'valise' => 'Une valise robuste et pratique pour faciliter vos voyages.',
    'crème hydratante' => 'Une crème hydratante nourrissante pour prendre soin de votre peau.',
    'jeu de société' => 'Un jeu de société divertissant à partager en famille ou entre amis.',
    'plante verte' => 'Une plante verte d\'intérieur pour apporter une touche de nature à votre espace.',
    'coussin' => 'Un coussin doux et confortable pour vous reposer et vous détendre.',
    'portefeuille' => 'Un portefeuille élégant avec de multiples compartiments pour organiser vos cartes et votre argent.'
);

for ($k = 0; $k < 10; $k++) {
    $result = getRandomKeyValue($articles);
	$query = "INSERT INTO article (nom, description) VALUES (:nom, :description)";
	$statement = $pdo->prepare($query);
	$statement->bindValue(':nom', $result['clé']);
	$statement->bindValue(':description', $result['valeur']);
	$statement->execute();
}
for ($i = 0; $i < 5; $i++) {
	$query = "INSERT INTO utilisateur (nom, email, mp, role, isActive, avatar) VALUES (:nom, :email, :mp, :role, :isActive, :avatar)";
	$statement = $pdo->prepare($query);
	$statement->bindValue(':nom', $faker->name);
	$statement->bindValue(':email', $faker->email);
	$statement->bindValue(':mp', $faker->password);
	$statement->bindValue(':role', 1);
	$statement->bindValue(':isActive', 1);
	$statement->bindValue(':avatar', $faker->imageUrl(300, 300, 'people'));
	$statement->execute();

	$user_id = $pdo->lastInsertId();
	for ($j = 0; $j < 5; $j++) {
		$query = "INSERT INTO listeDeSouhait (nom, description, utilisateur_idutilisateur, createdAt) VALUES (:nom, :description, :utilisateur_idutilisateur, :createdAt)";
		$statement = $pdo->prepare($query);
		$statement->bindValue(':nom', $faker->words(2, true));
		$statement->bindValue(':description', $faker->text);
		$statement->bindValue(':createdAt', $faker->date());
		$statement->bindValue(':utilisateur_idutilisateur', $user_id);
		$statement->execute();
	}

}
$query = "SELECT idlisteDeSouhait FROM listeDeSouhait";
$statement = $pdo->query($query);
$listeDeSouhait = $statement->fetchAll(PDO::FETCH_OBJ);

$query = "SELECT idarticle FROM article";
$statement = $pdo->query($query);
$article = $statement->fetchAll(PDO::FETCH_OBJ);

$query = "SELECT idutilisateur FROM utilisateur";
$statement = $pdo->query($query);
$utilisateur = $statement->fetchAll(PDO::FETCH_OBJ);




foreach ($listeDeSouhait as $liste) {
	$query = "INSERT INTO listeDeSouhait_has_article (listeDeSouhait_idlisteDeSouhait, article_idarticle) VALUES (:listeDeSouhait_idlisteDeSouhait, :article_idarticle)";
	for ($l = 0; $l < 5; $l++) {
		$statement = $pdo->prepare($query);
		$statement->bindValue(':listeDeSouhait_idlisteDeSouhait', $liste->idlisteDeSouhait);
		$statement->bindValue(':article_idarticle', $article[$l]->idarticle);
		$statement->execute();
	}
}

for($e = 0; $e <= 5; $e++){
    $randomUser = array_rand($utilisateur); // Sélectionner un index aléatoire du tableau
    $randomIdUtilisateur = $utilisateur[$randomUser]->idutilisateur;
    $randomIdListSouhait = array_rand($listeDeSouhait);
    $wish = $listeDeSouhait[$randomIdListSouhait]->idlisteDeSouhait;

    $query = "INSERT INTO commentaire (description, createdAt, utilisateur_idutilisateur, listeDeSouhait_idlisteDeSouhait) VALUES (:description, :createdAt, :utilisateur_idutilisateur, :listeDeSouhait_idlisteDeSouhait)";
    $statement = $pdo->prepare($query);
    $statement->bindValue(':description', $faker->text);
    $statement->bindValue(':createdAt', $faker->date());
    $statement->bindValue(':utilisateur_idutilisateur', $randomIdUtilisateur);
    $statement->bindValue(':listeDeSouhait_idlisteDeSouhait',$wish);
    $statement->execute();
}
