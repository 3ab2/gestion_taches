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

// Ajouter un nouveau personnel
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_personnel'])) {
    $nom = $_POST['nom'];
    $tache = $_POST['tache'];
    $statut = $_POST['statut'];
    $disponibilite = $_POST['disponibilite'];

    $sql = "INSERT INTO personnel (nom, tache, statut, disponibilite)
            VALUES ('$nom', '$tache', '$statut', '$disponibilite')";

    if ($conn->query($sql) === TRUE) {
        echo "Nouveau personnel ajouté avec succès!";
    } else {
        echo "Erreur: " . $sql . "<br>" . $conn->error;
    }
}

// Supprimer un utilisateur
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM personnel WHERE id = $id";
    if ($conn->query($sql) === TRUE) {
        echo "Utilisateur supprimé avec succès!";
    } else {
        echo "Erreur: " . $conn->error;
    }
}

// Récupérer les utilisateurs existants
$sql = "SELECT * FROM personnel";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Utilisateurs</title>
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

        h1 {
            text-align: center;
            color: #333;
        }

        .explanation {
            text-align: center;
            margin-bottom: 30px;
            font-size: 1.1em;
            color: #666;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #333;
            color: white;
        }

        td {
            color: #333;
        }

        button {
            padding: 5px 10px;
            background-color: #333;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
        }

        button:hover {
            background-color: #555;
        }

        .add-personnel-form {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-top: 30px;
        }

        .add-personnel-form input {
            padding: 10px;
            margin-bottom: 10px;
            width: 250px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .add-personnel-form button {
           
            width: 200px;
            height: 40px;
            display: flex;
            align-self: center;
            background-color: #28a745;
        }

        .add-personnel-form button:hover {
            background-color: #218838;
        }

        .action-buttons i {
            margin-right: 10px;
            cursor: pointer;
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
        <h1>Gestion des Utilisateurs</h1>
        <p class="explanation">
            Sur cette page, vous pouvez gérer les utilisateurs, attribuer des tâches et suivre leur statut.
        </p>

        <table>
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Tâche</th>
                    <th>Statut</th>
                    <th>Disponibilité</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $row['nom']; ?></td>
                        <td><?php echo $row['tache']; ?></td>
                        <td><?php echo $row['statut']; ?></td>
                        <td><?php echo $row['disponibilite']; ?></td>
                        
                        <td class="action-buttons">
                         <a href="personnel.php?delete=<?php echo $row['id']; ?>"><button><i class="fas fa-trash-alt"></i> Supprimer</button></a>
                        <a href="modifier_personnel.php?id=<?php echo $row['id']; ?>"><button><i class="fas fa-edit"></i> Modifier</button></a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <div class="add-personnel-form">
            <h2>Ajouter un nouveau personnel</h2>
            <form action="personnel.php" method="POST">
                <input type="text" name="nom" placeholder="Nom" required>
                <input type="text" name="tache" placeholder="Tâche" required>
                <input type="text" name="statut" placeholder="Statut" required>
                <input type="text" name="disponibilite" placeholder="Disponibilité" required>
                <button type="submit" name="add_personnel">Ajouter Personnel</button>
            </form>
        </div>
    </div>

   
</body>
<footer style=" color: #555; padding: 1em; text-align: center;  bottom: 0; width: 100%;">
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
