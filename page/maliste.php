<?php

require_once '../include/database.php';

session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['utilisateur'])) {
    header("Location: ../page/login.php");
    exit();
}

// Récupérer l'id de l'utilisateur connecté
$idutilisateur = $_SESSION['utilisateur']->idutilisateur;

// Récupérer la liste des articles depuis la base de données
$query = "SELECT idArticle, nom FROM article";
$statement = $pdo->prepare($query);
$statement->execute();
$articles = $statement->fetchAll(PDO::FETCH_ASSOC);

// Vérifier si le formulaire a été soumis
if (isset($_POST['ajouter'])) {
    $idArticle = $_POST['article'];

    // Vérifier si l'article existe dans la liste de souhaits de l'utilisateur
    $query = "SELECT idArticle FROM listesouhait WHERE idutilisateur = :idutilisateur AND idArticle = :idArticle";
    $statement = $pdo->prepare($query);
    $statement->execute([':idUtilisateur' => $idUtilisateur, ':idArticle' => $idArticle]);
    $existingArticle = $statement->fetch(PDO::FETCH_ASSOC);

    if (!$existingArticle) {
        // Ajouter l'article à la liste de souhaits de l'utilisateur
        $query = "INSERT INTO listesouhait (idutilisateur, idArticle) VALUES (:idutilisateur, :idArticle)";
        $statement = $pdo->prepare($query);
        $statement->execute([':idutilisateur' => $idutilisateur, ':idArticle' => $idArticle]);

        $_SESSION['flash']['success'] = "L'article a été ajouté à votre liste de souhaits.";
    } else {
        $_SESSION['flash']['error'] = "Cet article est déjà dans votre liste de souhaits.";
    }

    header("Location: wishlist.php");
    exit();
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Ma liste de souhaits</title>
</head>
<body>
    <h1>Ma liste de souhaits</h1>

    <?php if (isset($_SESSION['flash']['success'])): ?>
        <div class="flash-success">
            <?php echo $_SESSION['flash']['success']; ?>
        </div>
        <?php unset($_SESSION['flash']['success']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['flash']['error'])): ?>
        <div class="flash-error">
            <?php echo $_SESSION['flash']['error']; ?>
        </div>
        <?php unset($_SESSION['flash']['error']); ?>
    <?php endif; ?>

    <form method="POST" action="wishlist.php">
        <label for="article">Choisir un article :</label>
        <select name="article" id="article">
            <?php foreach ($articles as $article): ?>
                <option value="<?php echo $article['idArticle']; ?>"><?php echo $article['nom']; ?></option>
            <?php endforeach; ?>
        </select>
        <button type="submit" name="ajouter">Ajouter à ma liste de souhaits</button>
    </form>

    <h2>Ma liste de souhait</h2>
    

</body>
</html>
