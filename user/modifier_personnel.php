<?php
$servername = "localhost";
$username = "root";  // À adapter avec votre utilisateur de base de données
$password = "";  // À adapter avec votre mot de passe
$dbname = "gestion_taches";  // Remplacez par le nom de votre base de données

// Créer une connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Vérifier si l'ID est passé en paramètre GET
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Récupérer les informations de l'utilisateur à modifier
    $sql = "SELECT * FROM personnel WHERE id = $id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Récupérer les données de l'utilisateur
        $row = $result->fetch_assoc();
        $nom = $row['nom'];
        $tache = $row['tache'];
        $statut = $row['statut'];
        $disponibilite = $row['disponibilite'];
    } else {
        echo "Utilisateur non trouvé.";
        exit;
    }
}

// Mettre à jour les informations du personnel
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_personnel'])) {
    $nom = $_POST['nom'];
    $tache = $_POST['tache'];
    $statut = $_POST['statut'];
    $disponibilite = $_POST['disponibilite'];

    $sql = "UPDATE personnel SET nom = '$nom', tache = '$tache', statut = '$statut', disponibilite = '$disponibilite' WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        echo "Les informations du personnel ont été mises à jour avec succès!";
        header("Location: personnel.php");  // Rediriger vers la page du personnel
        exit();
    } else {
        echo "Erreur: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier le Personnel</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;600;700&display=swap">
    <style>
       body {
            font-family: 'Open Sans', sans-serif;
            background-color: #fff;
            color: #fff;
            margin: 0;
            padding: 0;
        }

        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #000;
            height: 60px;
            color: #fff;
            padding: 1em;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .navbar .brand {
            display: flex;
            align-items: center;
            color: white;
            font-size: 22px;
            font-weight: 600;
        }

        .navbar .brand .material-icons {
            margin-right: 10px;
            font-size: 30px;
        }

        .navbar .links {
            display: flex;
            align-items: center;
            margin-left: auto;
        }

        .navbar .links a {
            color: white;
            text-decoration: none;
            margin-left: 20px;
            font-size: 16px;
            display: flex;
            align-items: center;
        }

        .navbar .links a .material-icons {
            margin-right: 8px;
        }

        .navbar .links a:hover {
            color: #f00;
        }

        .content {
            margin-top: 20px;
            padding: 20px;
        }

        .content h1 {
            text-align: center;
        }

        .form-container {
            max-width: 500px;
            margin: 0 auto;
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .form-container input {
            padding: 10px;
            margin-bottom: 10px;
            width: 100%;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .form-container button {
            width: 100%;
            padding: 10px;
            background-color:rgb(31, 87, 171);
            border: none;
            color: white;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
        }

        .form-container button:hover {
            background-color:rgb(63, 61, 151);
        }
    </style>
</head>
<body>

   <!-- Barre de navigation -->
   
   <div class="navbar">
    <div class="brand">
        <span class="fas fa-tasks"></span>&nbsp;
        TaskEasy
    </div>
    <div class="links">
        <a href="../user/messagerie.php"><span class="fas fa-comments"></span>&nbsp; Messagerie</a>
        <a href="../user/personnel.php"><span class="fas fa-users"></span>&nbsp; Personnel</a>
        <a href="../user/dashboard.php"><span class="fas fa-chart-line"></span>&nbsp; Tableau de bord</a>
        <a href="index.php"><span class="fas fa-sign-out-alt"></span>&nbsp; Déconnexion</a>
    </div>
</div>
    </div>

    <div class="content">
        <h1>Modifier le Personnel</h1>

        <div class="form-container">
            <form action="modifier_personnel.php?id=<?php echo $id; ?>" method="POST">
                <input type="text" name="nom" value="<?php echo $nom; ?>" required>
                <input type="text" name="tache" value="<?php echo $tache; ?>" required>
                <input type="text" name="statut" value="<?php echo $statut; ?>" required>
                <input type="text" name="disponibilite" value="<?php echo $disponibilite; ?>" required>
                <button type="submit" name="update_personnel">Mettre à jour</button>
            </form>
        </div>
    </div>

</body>
<footer style=" color: #555; padding: 1em; text-align: center; position:fixed; bottom: 0; width: 100%;">
    <p>&copy; 2023 TaskEasy. Tous droits réservés.</p>
    <div style="display: flex; justify-content: center; align-items: center;">
        <a href="https://facebook.com/3ab2u.art" style="color: #555; margin: 0 0.5em;">
            <i class="fab fa-facebook" style="font-size: 1.5em;"></i>
        </a>
        <a href="https://instagram.com/3ab2u.art" style="color: #555; margin: 0 0.5em;">
            <i class="fab fa-instagram" style="font-size: 1.5em;"></i>
        </a>
        <a href="https://youtube.com/@3ab2u_54?si=f_yHSsOCx0flf3ii" style="color: #555; margin: 0 0.5em;">
            <i class="fab fa-youtube" style="font-size: 1.5em;"></i>
        </a>
        <a href="https://github.com/3ab2" style="color: #555; margin: 0 0.5em;">
            <i class="fab fa-github" style="font-size: 1.5em;"></i>
        </a>
    </div>
</footer>
</html>

<?php
// Fermer la connexion
$conn->close();
?>
