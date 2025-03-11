<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gestion_taches";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = $_POST['nom'];
    $tache = $_POST['tache'];
    $statut = $_POST['statut'];
    $disponibilite = $_POST['disponibilite'];

    $sql = "INSERT INTO personnel (nom, tache, statut, disponibilite)
            VALUES ('$nom', '$tache', '$statut', '$disponibilite')";

    if ($conn->query($sql) === TRUE) {
        echo "Nouvel utilisateur ajouté avec succès";
    } else {
        echo "Erreur: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>



<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;600;700&display=swap">
    <title>Dashboard</title>
    <style>
        /* Styles de base */
        body {
            font-family: 'Open Sans', sans-serif;
            background-color: #fff;
            color: #fff;
            margin: 0;
            padding: 0;
            transition: background 0.3s, color 0.3s;
        }

        /* Barre de navigation */
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

        .navbar .actions {
            display: flex;
            align-items: center;
        }

        .navbar .actions .material-icons {
            cursor: pointer;
            font-size: 24px;
            margin-left: 15px;
            color: white;
        }

        /* Liens dans la barre de navigation */
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

        /* Contenu principal */
        .content {
            margin-left: 100px;
            margin-top: 70px; /* Ajustement pour la barre de navigation */
            padding: 20px;
            transition: margin-left 0.3s ease-in-out;
        }

        /* Ajuster le contenu lorsque la barre latérale est active */
        .content.active {
            margin-left: 250px;
        }

        h1, p {
            text-align: center;
            color: #222;
        }

        .header {
            margin-bottom: 40px;
        }
        .brand a:hover{
        -webkit-text-fill-color:lightcoral;

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
        <a href="../admin/messagerie.php"><span class="fas fa-comments"></span>&nbsp; Messagerie</a>
        <a href="../admin/personnel.php"><span class="fas fa-users"></span>&nbsp; Personnel</a>
        <a href="../admin/dashboard.php"><span class="fas fa-chart-line"></span>&nbsp; Tableau de bord</a>
        <a href="http://localhost/gestion_taches/index.php"><span class="fas fa-sign-out-alt"></span>&nbsp; Déconnexion</a>
    </div>
</div>
    </div>

    <!-- Contenu principal -->
    <div class="content" id="content">
        <div class="header">
            <h1>Tableau de Bord</h1>
            <p>Gérez vos tâches efficacement et suivez leur évolution en temps réel.</p>
        </div>
        
        <canvas id="myChart" width="300" height="200"></canvas>
    </div>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Initialisation du graphique
        const ctx = document.getElementById('myChart').getContext('2d');
        const myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Jour 1', 'Jour 2', 'Jour 3', 'Jour 4', 'Jour 5'],
                datasets: [{
                    label: 'Tâches non terminées',
                    data: [10, 12, 15, 18, 20],
                    borderColor: 'rgb(255, 0, 0)',
                    backgroundColor: 'rgba(255, 0, 0, 0.5)',
                    tension: 0.1
                },
                {
                    label: 'Tâches terminées',
                    data: [5, 8, 12, 15, 18],
                    borderColor: 'rgb(0, 128, 0)',
                    backgroundColor: 'rgba(0, 128, 0, 0.5)',
                    tension: 0.1
                },
                {
                    label: 'Tâches en cours',
                    data: [8, 10, 12, 15, 18],
                    borderColor: 'rgb(255, 255, 0)',
                    backgroundColor: 'rgba(255, 255, 0, 0.5)',
                    tension: 0.1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Fonction pour afficher/masquer la barre latérale
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('active');
            document.getElementById('content').classList.toggle('active');
        }

        // Fonction pour basculer le mode sombre
        function toggleDarkMode() {
            document.body.classList.toggle('dark-mode');
        }
    </script>

</body>
<hr>
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
