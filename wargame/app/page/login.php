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
    $password = $_POST["password"] ?? "";

    if (empty($username) || empty($password))
    {
        $message = "Un ou plusieurs champs manquant(s).";
        goto end;
    }
    
    $user = User::get_from_username($username);

    if (!$user)
    {
        $message = "Utilisateur inexistant.";
        goto end;
    }
    
    $password_md5 = md5($password);

    if ($password_md5 != $user->get_password())
    {
        $message = "Mot de passe incorrect.";
        goto end;
    }

    // Set wargame-flag based on username
    switch ($user->get_username())
    {
        case "admin":
            $_SESSION["wargame-flag"] = "flag{Adm1n_4dm1n_Really?}";
            break;
        case "d3vel0per":
            $_SESSION["wargame-flag"] = "flag{wa1t...s0UrcE_c0de_1s_n0t_s3cr3t?}";
            break;
    }

    $_SESSION["user_id"] = $user->get_id();
    header("Location: /");
    exit();

    end:
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <title>Connexion</title>
</head>
<body class="d-flex flex-column vh-100">

    <?php include(TEMPLATE . "header.php"); ?>

    <!-- Formulaire de connexion -->
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        Connexion
                    </div>
                    <div class="card-body">
                        <form action="" method="post">
                            <div class="form-group">
                                <label>Username :</label>
                                <input type="text" class="form-control" placeholder="Entrez votre nom d'utilisateur" name="username" required>
                            </div>
                            <div class="form-group">
                                <label>Mot de Passe :</label>
                                <input type="password" class="form-control" placeholder="Entrez votre mot de passe" name="password" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Se connecter</button>
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