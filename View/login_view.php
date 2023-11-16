<?php
session_start();

require_once('../Database/database.php');
require_once('../Controller/user.php');

$db = new Database("localhost", "root", "", "bddcrud");
$user = new User($db);
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];
    // Dans login_view.php
    $userData = $user->getUserData($email);

    if ($userData && password_verify($password, $userData['mot_de_passe'])) {
        $_SESSION['user_email'] = $email;
        $_SESSION['user_id'] = $userData['id'];
        $_SESSION['admin'] = $userData['Admin'];
        $_SESSION['connexion_status'] = "Connexion réussie!";
        header("Location: bienvenue.php");
        exit();
    } else {
        $_SESSION['connexion_status'] = "Échec de la connexion. Veuillez vérifier vos informations de connexion.";
        header("Location: login_view.php");
        exit();
    }

}




// if ($_SERVER["REQUEST_METHOD"] == "POST") {
//     $email = $_POST["email"];
//     $password = $_POST["password"];
//     $userData = $user->getUserData($email);

//     if ($userData && password_verify($password, $userData['mot_de_passe'])) {
//         // Connexion réussie
//         $_SESSION['user_email'] = $email;
//         $_SESSION['user_id'] = $userData['id'];
//         $_SESSION['admin'] = $userData['admin'];
//         $_SESSION['connexion_status'] = "Connexion réussie!";
//         header("Location: bienvenue.php");
//         exit();
//     } else {
//         // Échec de la connexion
//         $_SESSION['connexion_status'] = "Échec de la connexion. Veuillez vérifier vos informations de connexion.";
//         header("Location: login_view.php");
//         exit();
//     }
// }

$db->closeConnection();
?>

<?php
include('../header.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <style>
        body {
            background-color: #f8f9fa;
        }

        .login-container {
            max-width: 400px;
            margin: auto;
            margin-top: 50px;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .login-container h2 {
            text-align: center;
        }

        .login-container p {
            color: <?php echo isset($_SESSION['connexion_status']) ? ($_SESSION['connexion_status'] === "Connexion réussie!" ? "green" : "red") : "inherit"; ?>;
        }

        .form-group {
            margin-bottom: 20px;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        button {
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <h2>Connexion</h2>
        <?php
        if (isset($_SESSION['connexion_status'])) {
            echo "<p>{$_SESSION['connexion_status']}</p>";
            unset($_SESSION['connexion_status']);
        }
        ?>
        <form action="login_view.php" method="post">
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="password">Mot de passe:</label>
                <input type="password" id="password" name="password" class="form-control" required>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Se connecter</button>
            </div>
            <div class="form-group">
                <a href="reset_password.php">Mot de passe oublié ?</a>
            </div>
        </form>
    </div>
</body>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>

</html>
