<?php
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['utilisateur'])) {
    // Utilisateur non connecté, affichez un message ou redirigez vers la page de connexion
    echo "Vous devez être connecté pour commenter.";
    // ou rediriger vers la page de connexion :
    // header('Location: login.php');
    exit();
}

// Vérifier si le formulaire de commentaire a été soumis
if (isset($_POST['commenter'])) {
    // Récupérer les données du formulaire
    $listeId = $_POST['liste_id'];
    $commentaire = $_POST['commentaire'];

    // Effectuer le traitement et l'enregistrement du commentaire dans la base de données
    // ...

    // Rediriger vers la page de la liste après avoir commenté
    header('Location: liste.php?id=' . $listeId);
    exit();
}

// Afficher le formulaire de commentaire
?>
<!DOCTYPE html>
<html>
<head>
    <title>Page de Commentaire</title>
    <!-- Inclure les liens vers les fichiers CSS de Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1>Page de Commentaire</h1>
        <form method="post" action="">
            <input type="hidden" name="liste_id" value="<?php echo $_GET['liste_id']; ?>">
            <div class="form-group">
                <label for="commentaire">Commentaire</label>
                <textarea class="form-control" name="commentaire" id="commentaire" rows="3" required></textarea>
            </div>
            <button type="submit" name="commenter" class="btn btn-primary">Commenter</button>
        </form>
    </div>
    <!-- Inclure les liens vers les fichiers JavaScript de Bootstrap -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/js/bootstrap.min.js"></script>
</body>
</html>
