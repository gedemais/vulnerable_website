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

// Requête SQL directement construite avec les entrées utilisateur
$sql = "SELECT id, password, photo, description FROM users WHERE username = '$username'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    
    // Vérifier le mot de passe
    if ($password === $row['password']) { //  Comparaison directe vulnérable
        $_SESSION['username'] = $username;
        $_SESSION['photo'] = $row['photo'];
        $_SESSION['description'] = $row['description'];
        header("Location: profile.php");
        exit();
    } else {
        echo "Mot de passe incorrect.";
    }
} else {
    echo "Utilisateur introuvable.";
}

$conn->close();
?>
