<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gestion_taches";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Vérifier si l'ID et le nouveau message sont bien reçus
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id']) && isset($_POST['message'])) {
    $id = intval($_POST['id']);
    $message = $conn->real_escape_string($_POST['message']);

    $sql = "UPDATE messages SET message='$message' WHERE id=$id";
    
    if ($conn->query($sql) === TRUE) {
        echo "success";
    } else {
        echo "error";
    }
}

$conn->close();
?>
