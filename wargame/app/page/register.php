<?php

require_once MODEL . "user.php";

if(session_status() !== PHP_SESSION_ACTIVE) session_start();

// Redirect to home page if user is already logged in
$user_id = $_SESSION["user_id"] ?? null;
if (!is_null($user_id))
{
    header("Location: /");
    exit();
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    $username = $_POST["username"] ?? "";
    $email = $_POST["email"] ?? "";
    $password = $_POST["password"] ?? "";
    $password_confirm = $_POST["password_confirm"] ?? "";

    // Check if all fields are filled
    if (empty($username) || empty($email) || empty($password) || empty($password_confirm))
    {
        $message = "Un ou plusieurs champs manquant(s).";
        goto end;
    }
    
    // Check if email is valid
    if (!filter_var($email, FILTER_VALIDATE_EMAIL))
    {
        $message = "Adresse email invalide.";
        goto end;
    }

    // Check if password and password_confirm are the same
    if ($password != $password_confirm)
    {
        $message = "Les mots de passe ne correspondent pas.";
        goto end;
    }

    // Check if user already exists
    if (User::get_from_username($username))
    {
        $message = "Nom d'utilisateur déjà utilisé.";
        goto end;
    }
    
    $password_md5 = md5($password);

    $user = User::create($username, $email, $password_md5);

    // Login the user after registration
    $_SESSION["user_id"] = $user->get_id();
    header("Location: /");
    exit();

    end:
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <title>Inscription</title>
</head>
<body class="d-flex flex-column vh-100">
    
    <?php include(TEMPLATE . "header.php"); ?>

    <!-- Formulaire d'inscription -->
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        Inscription
                    </div>
                    <div class="card-body">
                        <form action="" method="post">
                            <div class="form-group">
                                <label>Username :</label>
                                <input type="text" class="form-control" id="Username" placeholder="Entrez votre nom d'utilsateur" name="username" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Adresse Email :</label>
                                <input type="email" class="form-control" id="email" placeholder="Entrez votre email" name="email" required>
                            </div>
                            <div class="form-group">
                                <label for="pwd">Mot de Passe :</label>
                                <input type="password" class="form-control" id="password" placeholder="Entrez votre mot de passe" name="password" required>
                            </div>
                            <div class="form-group">
                                <label for="confirmPwd">Confirmez le Mot de Passe :</label>
                                <input type="password" class="form-control" id="password-confirm" placeholder="Confirmez votre mot de passe" name="password_confirm" required>
                            </div>
                            <button type="submit" class="btn btn-primary">S'inscrire</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
        if (!empty($message)) 
        {
            echo "<div class='alert alert-danger' role='alert'>" . $message . "</div>";
        }
    ?>

    <?php include(TEMPLATE . "footer.php"); ?>

</body>
</html>