<?php
// Connexion à la base de données
$conn = new mysqli('localhost', 'nom_utilisateur', 'mot_de_passe', 'site_web');

// Vérifier la connexion
if ($conn->connect_error) {
    die("Connexion échouée : " . $conn->connect_error);
}

// Récupérer les données du formulaire
$username = $_POST['username'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hachage du mot de passe
$description = $_POST['description'];

// Gestion de l'upload de la photo
if ($_FILES['photo']['error'] == UPLOAD_ERR_OK) {
    $tmp_name = $_FILES['photo']['tmp_name'];
    $photo_name = basename($_FILES['photo']['name']);
    move_uploaded_file($tmp_name, "uploads/$photo_name");
    $photo_path = "uploads/$photo_name";
} else {
    $photo_path = null;
}

// Insertion des données dans la base
$stmt = $conn->prepare("INSERT INTO utilisateurs

