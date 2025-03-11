<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password_db = "";
$dbname = "gestion_taches";

$conn = new mysqli($servername, $username, $password_db, $dbname);

// Vérification de la connexion
if ($conn->connect_error) {
    die("Erreur de connexion : " . $conn->connect_error);
}

// Traitement du formulaire
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Requête préparée pour récupérer l'utilisateur
    $sql = "SELECT id, name, password FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Vérification du mot de passe
        if (password_verify($password, $user["password"])) {
            $_SESSION["email"] = $email;
            $_SESSION["name"] = $user["name"];
            $_SESSION["id"] = $user["id"];
            
            header("Location: ../gestion_taches/admin/PHP/dashboard.php");
             exit;

        } else {
            $error = "Mot de passe incorrect.";
        }
    } else {
        $error = "Email non trouvé.";
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;600;700&display=swap">
    <title>connexion</title>
    <link rel="stylesheet" href="../CSS/styles.css">
    <style>
    /* Styles de base */
    body {
            font-family: 'Open Sans', sans-serif;
            background-color: #fff;
            color: #444;
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

    .nav-right i {
        cursor: pointer;
    }
    .nav-right{
        display: flex;
        align-items: center;
        justify-content: flex-end;
    }

    form {
        max-width: 400px;
        margin: 40px auto;
        padding: 20px;
        background-color: #fff;
        border: 1px solid #ddd;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    form h2 {
        text-align: center;
        margin-bottom: 20px;
    }

    label {
        display: block;
        margin-bottom: 10px;
    }

    input[type="email"], input[type="password"] {
        width: 100%;
        padding: 10px;
        height: 20px;
        margin-bottom: 20px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

   
    button[type="submit"] {
        width: 30%;
        padding: 10px;
        background-color: #000;
        color: #fff;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        margin: 0 auto;
        display: block;
    }
    

    button[type="submit"]:hover {
        background-color: #333;
    }

    p {
        text-align: center;
        margin-top: 20px;
    }

    form a {
        text-decoration: none;
        color: #000;
    }

    form a:hover {
        text-decoration: underline;
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

    <form id="connexion-form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <h2>Connexion</h2>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <label for="password">Mot de passe:</label>
        <input type="password" id="password" name="password" required>

        <button type="submit">Se connecter</button>

        <?php if (isset($error)) { ?>
            <p style="color: red;"><?php echo $error; ?></p>
        <?php } ?>

        <p>Vous n'avez pas de compte ? <a href="signup.php">S'inscrire</a></p>
    </form>
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



