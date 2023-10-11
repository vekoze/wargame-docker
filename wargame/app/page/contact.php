<?php

require_once PHPMAILER . "PHPMailerAutoload.php";

if(session_status() !== PHP_SESSION_ACTIVE) session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    $name = $_POST["name"] ?? "";
    $email = $_POST["email"] ?? "";
    $content = $_POST["content"] ?? "";

    // Check if fields are empty
    if (empty($name) || empty($email) || empty($content))
    {
        $_SESSION["feedback"] = ["type" => "danger", "message" => "PHPMailer 5.2.16 : Un ou plusieurs champs manquant(s)."];
        goto end;
    }

    $mail = new PHPMailer();
    $mail->IsSMTP();
    $mail->Host = "wsmtp";
    $mail->Port = 25;

    $mail->setFrom($email, "Wargame");
    $mail->addAddress('wargame@example.com', 'Wargame');
    $mail->Subject = "Message de $name";
    $mail->Body = $content;
    
    if(!$mail->send())
    {
        $_SESSION["feedback"] = ["type" => "danger", "message" => "Le message n'a pas pu être envoyé (" . $mail->ErrorInfo . ")"];
        goto end;
    }

    $_SESSION["feedback"] = ["type" => "success", "message" => "PHPMailer 5.2.16 : Le message a bien été envoyé"];

    end:
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
    <title>Nous contacter</title>
</head>
<body class="d-flex flex-column vh-100">

    <?php include(TEMPLATE . "header.php"); ?>

    <main class="w-50 align-self-center">
        <form class="row g-3" action="" method="post">
            <div class="col-md-6">
                <label for="inputEmail4" class="form-label">Nom</label>
                <input name="name" type="text" class="form-control" id="inputEmail4">
            </div>
            <div class="col-12">
                <label for="inputAddress" class="form-label">Adresse électronique</label>
                <input name="email" type="text" class="form-control" id="inputAddress" placeholder="name@example.com">
            </div>
            <div class="col-12">
                <label for="inputAddress2" class="form-label">Message</label>
                <textarea name="content" class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-primary">Envoyer</button>
            </div>
        </form>
    </main>

    <?php
        if (isset($_SESSION["feedback"]))
        {
            echo "<div class='alert alert-" . $_SESSION["feedback"]["type"] . "' role='alert'>" . $_SESSION["feedback"]["message"] . "</div>";
            unset($_SESSION["feedback"]);
        }
    ?>

    <?php include(TEMPLATE . "footer.php"); ?>

</body>
</html>