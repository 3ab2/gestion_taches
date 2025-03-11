<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password_db = "";
$dbname = "gestion_taches";

$conn = new mysqli($servername, $username, $password_db, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Erreur de connexion : " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm-password"];

    if ($password == $confirm_password) {
        // Vérifier si l'email existe déjà
        $sql = "SELECT id FROM users WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            echo "Cet email est déjà utilisé.";
        } else {
            // Hachage du mot de passe
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Insertion des données
            $sql = "INSERT INTO users (name, email, password) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sss", $name, $email, $hashed_password);

            if ($stmt->execute()) {
                echo "Inscription réussie.";
            } else {
                echo "Erreur lors de l'inscription.";
            }
        }
        $stmt->close();
    } else {
        echo "Les mots de passe ne correspondent pas.";
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
   
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;600;700&display=swap">
    
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

        .nav-left {
            display: flex;
            align-items: center;
        }

        .nav-left i {
            margin-right: 10px;
        }

        .nav-right {
            display: flex;
            align-items: center;
            justify-content: flex-end;
        }

        form {
            max-width: 400px;
            margin: 50px auto;
            padding: 30px;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 0 0 12px rgba(0, 0, 0, 0.1);
        }

        form h2 {
            text-align: center;
            margin-bottom: 25px;
            color: #333;
        }

        label {
            display: block;
            margin-bottom: 10px;
            font-weight: 600;
            color: #555;
        }

        input[type="text"], input[type="email"], input[type="password"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 16px;
        }

        input[type="text"]:focus, input[type="email"]:focus, input[type="password"]:focus {
            border-color: #007BFF;
            outline: none;
        }

        button[type="submit"] {
            width: 100%;
            padding: 12px;
            background-color: #000;
            color: #fff;
            border: none;
            border-radius: 6px;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button[type="submit"]:hover {
            background-color:rgb(1, 6, 11);
        }

        p {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            color: #555;
        }

        form a {
            color: #333;
            text-decoration: none;
        }

        form a:hover {
            text-decoration: underline;
        }

        footer {
            color: #555;
            text-align: center;
            padding: 1em;
            background-color: #f8f8f8;
        }

        footer .social-links a {
            margin: 0 10px;
            color: #555;
        }

        footer .social-links a:hover {
            color: #007BFF;
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
    <a href="index.php" style="text-decoration: none; color: white; display: flex; align-items: center;">
        <span class="material-icons" style="font-size: 30px; margin-right: 10px;">task</span>
        <span style="font-size: 22px; font-weight: 600;">TaskEasy</span>
    </a>
</div>
        <div class="links">
            
            
            
            <a href="http://localhost/gestion_taches/login.php">
                <span class="material-icons">exit_to_app</span>
                Connexion
            </a>
            <a href="http://localhost/gestion_taches/signup.php">
                <span class="material-icons">fact_check</span>
                Inscription
            </a>
        </div>
    </div>

    <form id="inscription-form" action="signup.php" method="POST">
        <h2>Créer un compte</h2>

        <label for="name">Nom :</label>
        <input type="text" id="name" name="name" required>

        <label for="email">Email :</label>
        <input type="email" id="email" name="email" required>

        <label for="password">Mot de passe :</label>
        <input type="password" id="password" name="password" required>

        <label for="confirm-password">Confirmer le mot de passe :</label>
        <input type="password" id="confirm-password" name="confirm-password" required>

        <button type="submit">S'inscrire</button>

        <p>Vous avez déjà un compte ? <a href="login.php">Se connecter</a></p>
    </form>

    <footer>
        <p>&copy; 2023 TaskEasy. Tous droits réservés.</p>
        <div class="social-links">
            <a href="https://facebook.com/3ab2u.art"><i class="fab fa-facebook" style="font-size: 1.5em;"></i></a>
            <a href="https://instagram.com/3ab2u.art"><i class="fab fa-instagram" style="font-size: 1.5em;"></i></a>
            <a href="https://youtube.com/@3ab2u_54"><i class="fab fa-youtube" style="font-size: 1.5em;"></i></a>
            <a href="https://github.com/3ab2"><i class="fab fa-github" style="font-size: 1.5em;"></i></a>
        </div>
    </footer>
</body>
</html>
