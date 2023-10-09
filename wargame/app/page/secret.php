<?php

if(session_status() !== PHP_SESSION_ACTIVE) session_start();

$user_agent = $_SERVER['HTTP_USER_AGENT'];

if ($user_agent != "SecureBrowser/1.0 (SecureOS 1.0)")
{
    header("Location: /");
    exit();
}

$_SESSION["wargame-flag"] = "flag{Us3r_Ag3nts_Ar3nT_S3cur3_4uthM3ch4n1sms!}";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <title>Secret</title>
</head>
<body class="d-flex flex-column vh-100">
        
    <?php include(TEMPLATE . "header.php"); ?>

    <div class="h-100 d-flex justify-content-center align-items-center">
        <img class="w-50" src="/img/shocked.jpg"/>
    </div>

    <?php
      if (isset($_SESSION["wargame-flag"]))
      {
        include(TEMPLATE . "popup.php");
        unset($_SESSION["wargame-flag"]);
      }
      ?>

    <?php include(TEMPLATE . "footer.php"); ?>

</body>
</html>