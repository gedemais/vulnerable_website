<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>

<?php
session_start();
session_destroy();
header("Location: index.html");
exit();
?>
