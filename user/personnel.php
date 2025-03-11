<?php
session_start();
if (!isset($_SESSION['email']) || $_SESSION['is_admin']) {
    header('Location: ../login.php');
    exit;
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gestion_taches";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Gérer les réactions emoji
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_reaction'])) {
    $personnel_id = $_POST['personnel_id'];
    $emoji = $_POST['emoji'];
    $user_id = $_SESSION['id'];

    // Vérifier si une réaction existe déjà
    $check_sql = "SELECT * FROM reactions WHERE user_id = ? AND personnel_id = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("ii", $user_id, $personnel_id);
    $check_stmt->execute();
    $result = $check_stmt->get_result();

    if ($result->num_rows > 0) {
        // Mettre à jour la réaction existante
        $update_sql = "UPDATE reactions SET emoji = ? WHERE user_id = ? AND personnel_id = ?";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param("sii", $emoji, $user_id, $personnel_id);
        $update_stmt->execute();
    } else {
        // Ajouter une nouvelle réaction
        $insert_sql = "INSERT INTO reactions (user_id, personnel_id, emoji) VALUES (?, ?, ?)";
        $insert_stmt = $conn->prepare($insert_sql);
        $insert_stmt->bind_param("iis", $user_id, $personnel_id, $emoji);
        $insert_stmt->execute();
    }
}

// Récupérer les utilisateurs existants avec leurs réactions
$sql = "SELECT p.*, 
        GROUP_CONCAT(r.emoji) as reactions,
        GROUP_CONCAT(r.user_id) as reaction_users
        FROM personnel p 
        LEFT JOIN reactions r ON p.id = r.personnel_id 
        GROUP BY p.id";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste du Personnel</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;600;700&display=swap">
    <style>
        body {
            font-family: 'Open Sans', sans-serif;
            background-color: #f5f5f5;
            color: #333;
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
            margin: 20px auto;
            padding: 20px;
            max-width: 1200px;
        }

        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
        }

        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }

        th {
            background-color: #000;
            color: white;
            font-weight: 600;
        }

        tr:hover {
            background-color: #f9f9f9;
        }

        .action-buttons {
            display: flex;
            gap: 10px;
            justify-content: flex-end;
        }

        .action-buttons button {
            padding: 8px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 5px;
            transition: background-color 0.3s;
        }

        .print-btn {
            background-color: #4CAF50;
            color: white;
        }

        .download-btn {
            background-color: #2196F3;
            color: white;
        }

        .emoji-reactions {
            display: flex;
            gap: 5px;
        }

        .emoji-btn {
            background: none;
            border: none;
            font-size: 1.2em;
            cursor: pointer;
            padding: 2px 5px;
            border-radius: 4px;
            transition: background-color 0.2s;
        }

        .emoji-btn:hover {
            background-color: #f0f0f0;
        }

        .emoji-btn.active {
            background-color: #e3e3e3;
        }

        .tools-bar {
            margin-bottom: 20px;
            display: flex;
            justify-content: flex-end;
            gap: 10px;
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
        <a href="http://localhost/gestion_taches/index.php"><span class="fas fa-sign-out-alt"></span>&nbsp; Déconnexion</a>
    </div>
</div>
    </div>

    <div class="content">
        <h1>Liste du Personnel</h1>
        
        <div class="tools-bar">
            <button onclick="window.print()" class="print-btn">
                <i class="material-icons">print</i> Imprimer
            </button>
            <button onclick="exportToCSV()" class="download-btn">
                <i class="material-icons">download</i> Télécharger CSV
            </button>
        </div>

        <table id="personnelTable">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Tâche</th>
                    <th>Statut</th>
                    <th>Disponibilité</th>
                    <th>Réactions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        $reactions = $row['reactions'] ? explode(',', $row['reactions']) : [];
                        $reaction_users = $row['reaction_users'] ? explode(',', $row['reaction_users']) : [];
                        
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['nom']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['tache']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['statut']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['disponibilite']) . "</td>";
                        echo "<td class='emoji-reactions'>";
                        
                        // Emoji buttons
                        $emojis = ['👍', '❤️', '👏', '🌟', '💪'];
                        foreach ($emojis as $emoji) {
                            $isActive = in_array($emoji, $reactions) && in_array($_SESSION['id'], $reaction_users);
                            $activeClass = $isActive ? 'active' : '';
                            echo "<form method='post' style='display: inline;'>";
                            echo "<input type='hidden' name='personnel_id' value='" . $row['id'] . "'>";
                            echo "<input type='hidden' name='emoji' value='" . $emoji . "'>";
                            echo "<button type='submit' name='add_reaction' class='emoji-btn $activeClass' title='Réagir avec $emoji'>$emoji</button>";
                            echo "</form>";
                        }
                        
                        echo "</td>";
                        echo "</tr>";
                    }
                }
                ?>
            </tbody>
        </table>
    </div>

    <script>
    function exportToCSV() {
        const table = document.getElementById('personnelTable');
        let csv = [];
        
        // Get headers
        let headers = [];
        for (let cell of table.rows[0].cells) {
            headers.push(cell.textContent);
        }
        csv.push(headers.join(','));
        
        // Get data
        for (let i = 1; i < table.rows.length; i++) {
            let row = [];
            for (let j = 0; j < table.rows[i].cells.length - 1; j++) { // Skip reactions column
                row.push('"' + table.rows[i].cells[j].textContent + '"');
            }
            csv.push(row.join(','));
        }
        
        // Download CSV
        const csvContent = csv.join('\n');
        const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
        const link = document.createElement('a');
        link.href = URL.createObjectURL(blob);
        link.download = 'personnel_list.csv';
        link.click();
    }
    </script>
</body>
</html>
<?php $conn->close(); ?>
