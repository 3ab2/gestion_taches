
<?php
// Configuration de la base de données
$host = 'localhost';
$dbname = 'gestion_taches';
$user = 'root';
$password = '';

// Connexion à la base de données
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Erreur de connexion : ' . $e->getMessage();
}

// Fonction pour exécuter une requête SQL
function executeQuery($sql, $params = array()) {
    global $pdo;
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    return $stmt;
}

// Fonction pour récupérer les données de la base de données
function getData($sql, $params = array()) {
    $stmt = executeQuery($sql, $params);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Fonction pour insérer des données dans la base de données
function insertData($sql, $params = array()) {
    executeQuery($sql, $params);
}

// Fonction pour mettre à jour des données dans la base de données
function updateData($sql, $params = array()) {
    executeQuery($sql, $params);
}

// Fonction pour supprimer des données dans la base de données
function deleteData($sql, $params = array()) {
    executeQuery($sql, $params);
}
?>
