<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;600;700&display=swap">
    <title>TaskEasy</title>
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
        float: left;
    }

    .nav-right {
        float: right;
    }

    .nav-link {
        color: #fff;
        text-decoration: none;
        margin-left: 1em;
    }

    .nav-link:hover {
        color: #ccc;
    }

    .fas {
        margin-right: 0.5em;
    }

    #mode-toggle {
        cursor: pointer;
    }
    .log_sign{
        display: flex;
        justify-content: space-around;
        align-items: center;
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

<div class="container" style="display: flex; justify-content: center; align-items: center; flex-direction: column; padding: 2em; margin-top: 2em; background-color: #fff; border-radius: 0.5em; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
    <h1 style="font-size: 2em; margin-bottom: 0.5em;">Bienvenue sur TaskEasy</h1>
    <p style="font-size: 1.2em; margin-bottom: 1em;"><b>TaskEasy</b> c'ect une application web de gestion des tâches permettant de gérer et organiser votre tâches de manière efficace.</p>
    <div style="display: flex; justify-content: space-around; align-items: center; width: 100%; margin-bottom: 1em;">
        <div style="display: flex; flex-direction: column; align-items: center;">
            <i class="fas fa-lock" style="font-size: 2em; margin-bottom: 0.5em;"></i>
            <p style="font-size: 1em;">Système d'authentification</p>
        </div>
        <div style="display: flex; flex-direction: column; align-items: center;">
            <i class="fas fa-users" style="font-size: 2em; margin-bottom: 0.5em;"></i>
            <p style="font-size: 1em;">Rôles différenciés</p>
        </div>
        <div style="display: flex; flex-direction: column; align-items: center;">
            <i class="fas fa-comments" style="font-size: 2em; margin-bottom: 0.5em;"></i>
            <p style="font-size: 1em;">Fonctionnalité de communication</p>
        </div>
    </div>
    <p style="font-size: 1em; margin-bottom: 1em;">Le site sera multi-utilisateurs avec un administrateur unique et plusieurs utilisateurs réguliers.</p>
   <div class="log_sign">
   <a href="signup.php" style="text-decoration: none; color: #333; background-color: #fff; border: 1px solid #333; padding: 0.5em 1em; border-radius: 0.5em; ">S'inscrire</a>
   <a href="login.php" style="text-decoration: none; color: #333; background-color: #fff; border: 1px solid #333; padding: 0.5em 1em; border-radius: 0.5em; margin-left: 1em;">Se connecter</a>
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