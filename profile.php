<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Profil de <?php echo $_SESSION['username']; ?></title>
</head>
<body>
    <h2>Bienvenue, <?php echo $_SESSION['username']; ?> !</h2>
    <p><strong>Description :</strong> <?php echo $_SESSION['description']; ?></p>
    <p><strong>Photo :</strong></p>
    <img src="<?php echo $_SESSION['photo']; ?>" alt="Photo de profil" width="200"><br><br>
    <a href="logout.php"><button>Déconnexion</button></a>
</body>
</html>
