<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>

<?php
session_start();
$conn = new mysqli("localhost", "admin", "SuperSecurePassword", "site_web");

if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}

// Pas d'échappement ou de validation des entrées
$username = $_POST["username"];
$password = $_POST["password"]; // Stockage en clair du mot de passe
$description = $_POST["description"];

// Gestion de l'upload de l'image
$target_dir = "/var/www/html/uploads/";
$target_file = $target_dir . basename($_FILES["photo"]["name"]);

if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
    $photo_path = $target_file;
} else {
    die("Erreur lors de l'upload du fichier.");
}


$target_dir = "uploads/";
$photo_path = $target_dir . basename($_FILES["photo"]["name"]);
// Requête SQL directement construite avec les entrées utilisateur
$sql = "INSERT INTO users (username, password, description, photo) VALUES ('$username', '$password', '$description', '$photo_path')";

if ($conn->query($sql) === TRUE) {
    header("Location: index.html"); // Redirection après succès
    exit();
} else {
    die("Erreur lors de l'inscription : " . $conn->error);
}

$conn->close();
?>
