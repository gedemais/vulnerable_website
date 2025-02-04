<?php
session_start();

// Connexion à la base de données
$conn = new mysqli("localhost", "admin", "SuperSecurePassword", "site_web");

// Vérification de la connexion
if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}

// Vérification que les données sont bien envoyées
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $conn->real_escape_string($_POST["username"]);
    $password = password_hash($_POST["password"], PASSWORD_BCRYPT);
    $description = $conn->real_escape_string($_POST["description"]);

    // Gestion de l'upload de l'image
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["photo"]["name"]);

    if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
        $photo_path = $target_file;
    } else {
        die("Erreur lors de l'upload du fichier.");
    }

    // Insertion des données dans la base
    $sql = "INSERT INTO users (username, password, description, photo) VALUES ('$username', '$password', '$description', '$photo_path')";

    if ($conn->query($sql) === TRUE) {
        header("Location: index.html"); // Redirection après succès
        exit();
    } else {
        die("Erreur lors de l'inscription : " . $conn->error);
    }
}

$conn->close();
?>

