<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>

<?php
session_start();
$conn = new mysqli('localhost', 'admin', 'SuperSecurePassword', 'site_web');

if ($conn->connect_error) {
    die("Connexion échouée : " . $conn->connect_error);
}

$username = $_POST['username'];
$password = $_POST['password'];

// Vérifier si l'utilisateur existe
$stmt = $conn->prepare("SELECT id, password, photo, description FROM utilisateurs WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    $stmt->bind_result($id, $hashed_password, $photo, $description);
    $stmt->fetch();

    // Vérifier le mot de passe
    if (password_verify($password, $hashed_password)) {
        // Stocker les infos en session et rediriger vers la page de profil
        $_SESSION['username'] = $username;
        $_SESSION['photo'] = $photo;
        $_SESSION['description'] = $description;
        header("Location: profile.php");
        exit();
    } else {
        echo "Mot de passe incorrect.";
    }
} else {
    echo "Utilisateur introuvable.";
}

$stmt->close();
$conn->close();
?>
