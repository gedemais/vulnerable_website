<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.html");
    exit();
}

// Récupérer les données de l'utilisateur
$username = $_SESSION['username'];
$photo = $_SESSION['photo'];
$description = $_SESSION['description'];

// Charger le contenu HTML et insérer les données dynamiquement
$html = file_get_contents("profile.html");
$html = str_replace("{{USERNAME}}", $username, $html);
$html = str_replace("{{PHOTO}}", $photo, $html);
$html = str_replace("{{DESCRIPTION}}", $description, $html);

echo $html;
?>
