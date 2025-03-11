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



$nom_utilisateur = $_SESSION['name'];

// Ajouter un message
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['send_message'])) {
    $message = $conn->real_escape_string($_POST['message']); // Échapper le message
    $sql = "INSERT INTO messages (nom_utilisateur, message) VALUES ('$nom_utilisateur', '$message')";
    $conn->query($sql);
}

// Récupérer tous les messages
$sql = "SELECT * FROM messages ORDER BY date_envoi DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messagerie</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #fff;
            color: #000;
            margin: 0;
            padding: 0;
            height: 100vh;
            display: flex;
            flex-direction: column;
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

        .navbar .links {
            display: flex;
            align-items: center;
        }

        .navbar .links a {
            color: white;
            text-decoration: none;
            margin-left: 20px;
            font-size: 16px;
            display: flex;
            align-items: center;
        }

        .navbar .links a:hover {
            color: #f00;
        }

        /* Conteneur principal */
        .main-container {
            display: flex;
            flex: 1;
            margin-top: 10px;
            height: calc(100vh - 60px);
        }

        /* Zone d'entrée */
        .input-container {
            width: 30%;
            padding: 20px;
            background-color: #f4f4f4;
            display: flex;
            flex-direction: column;
            align-items: center;
            border-right: 2px solid #ddd;
        }

        .input-container form {
            width: 100%;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .input-container input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 20px;
            font-size: 14px;
            outline: none;
        }

        .input-container button {
            padding: 10px;
            background-color: #0078ff;
            color: white;
            border: none;
            border-radius: 20px;
            cursor: pointer;
            width: 100%;
        }

        .input-container button:hover {
            background-color: #005bb5;
        }

        /* Zone de messagerie */
        .chat-container {
            width: 70%;
            padding: 20px;
            overflow-y: auto;
        }

        .messages {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .message {
            max-width: 75%;
            padding: 10px;
            border-radius: 10px;
            background-color: #e1e1e1;
            display: flex;
            flex-direction: column;
            word-wrap: break-word;
            position: relative;
        }

        .my-message {
            background-color: #0078ff;
            color: white;
            align-self: flex-end;
        }

        .message-header {
            font-weight: bold;
            color: #333;
            margin-bottom: 5px;
        }

        .message-options {
            display: none;
            position: absolute;
            top: 5px;
            right: 10px;
            background: rgba(0, 0, 0, 0.8);
            color: white;
            padding: 5px;
            border-radius: 5px;
        }

        .message:hover .message-options {
            display: flex;
            gap: 10px;
            font-size: 14px;
        }

        .message-options i {
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
        <a href="../admin/messagerie.php"><span class="fas fa-comments"></span>&nbsp; Messagerie</a>
        <a href="../admin/personnel.php"><span class="fas fa-users"></span>&nbsp; Personnel</a>
        <a href="../admin/dashboard.php"><span class="fas fa-chart-line"></span>&nbsp; Tableau de bord</a>
        <a href="index.php"><span class="fas fa-sign-out-alt"></span>&nbsp; Déconnexion</a>
    </div>
</div>
    </div>

<div class="main-container">
    <!-- Zone de saisie -->
    <div class="input-container">
        <form action="messagerie.php" method="POST">
            <input type="text" name="message" placeholder="Écrivez votre message..." required>
            <button type="submit" name="send_message"><i class="fas fa-paper-plane"></i> Envoyer</button>
        </form>
    </div>

    <!-- Zone de chat -->
    <div class="chat-container">
        <div class="messages">
            <?php while ($row = $result->fetch_assoc()) { ?>
                <div class="message <?php echo $row['nom_utilisateur'] == $nom_utilisateur ? 'my-message' : 'other-message'; ?>" data-id="<?php echo $row['id']; ?>">
                    <div class="message-header"><?php echo $row['nom_utilisateur']; ?></div>
                    <div class="message-body"><?php echo $row['message']; ?></div>
                    <div class="message-options">
                        <i class="fas fa-trash" onclick="deleteMessage(<?php echo $row['id']; ?>)"></i>
                        <i class="fas fa-edit" onclick="editMessage(<?php echo $row['id']; ?>)"></i>
                        <i class="fas fa-copy" onclick="copyMessage('<?php echo addslashes($row['message']); ?>')"></i>
                        <i class="fas fa-reply" onclick="replyMessage('<?php echo addslashes($row['message']); ?>')"></i>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>



<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Fonction pour supprimer un message
        function deleteMessage(messageId) {
            if (confirm("Voulez-vous supprimer ce message ?")) {
                fetch('delete_message.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: 'id=' + encodeURIComponent(messageId)
                })
                .then(response => response.text())
                .then(data => {
                    if (data.trim() === "success") {
                        document.querySelector(`.message[data-id='${messageId}']`).remove();
                    } else {
                        alert("Erreur lors de la suppression.");
                    }
                })
                .catch(error => console.error('Erreur:', error));
            }
        }

        // Fonction pour modifier un message
        function editMessage(messageId) {
            let messageElement = document.querySelector(`.message[data-id='${messageId}'] .message-body`);
            let newMessage = prompt("Modifiez votre message :", messageElement.innerText);
            if (newMessage !== null) {
                fetch('edit_message.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: 'id=' + encodeURIComponent(messageId) + '&message=' + encodeURIComponent(newMessage)
                })
                .then(response => response.text())
                .then(data => {
                    if (data.trim() === "success") {
                        messageElement.innerText = newMessage;
                    } else {
                        alert("Erreur lors de la modification.");
                    }
                })
                .catch(error => console.error('Erreur:', error));
            }
        }

        // Fonction pour copier un message
        function copyMessage(message) {
            navigator.clipboard.writeText(message).then(() => {
                alert("Message copié !");
            }).catch(err => console.error('Erreur de copie:', err));
        }

        // Fonction pour répondre à un message
        function replyMessage(message) {
            document.querySelector('input[name="message"]').value = "Réponse : " + message;
        }

        // Ajout des événements sur les icônes
        document.querySelectorAll('.message-options .fa-trash').forEach(icon => {
            icon.addEventListener('click', function () {
                let messageId = this.closest('.message').getAttribute('data-id');
                deleteMessage(messageId);
            });
        });

        document.querySelectorAll('.message-options .fa-edit').forEach(icon => {
            icon.addEventListener('click', function () {
                let messageId = this.closest('.message').getAttribute('data-id');
                editMessage(messageId);
            });
        });

        document.querySelectorAll('.message-options .fa-copy').forEach(icon => {
            icon.addEventListener('click', function () {
                let message = this.closest('.message').querySelector('.message-body').innerText;
                copyMessage(message);
            });
        });

        document.querySelectorAll('.message-options .fa-reply').forEach(icon => {
            icon.addEventListener('click', function () {
                let message = this.closest('.message').querySelector('.message-body').innerText;
                replyMessage(message);
            });
        });
    });
</script>


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

<?php $conn->close(); ?>
