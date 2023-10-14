<?php

require_once MODEL . "user.php";
require_once APP . "helper.php";

if(session_status() !== PHP_SESSION_ACTIVE) session_start();

$user_id = decode_user_id($_GET[0]);

// Redirect to home page if user is not logged in
if (!isset($_SESSION["user_id"])) 
{
  header("Location: /");
  exit();
}

// Get user from ID
try
{
  $user = new User($user_id);
} 
catch (Exception $e) 
{
  header("Location: /");
  exit();
}

// IDOR
if ($user_id != $_SESSION["user_id"]) {
  $_SESSION["wargame-flag"] = "flag{Oops_forg0t_tH3_IDOR_1ock}";
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
  <title>Profil</title>
</head>

<body class="d-flex flex-column">

  <?php include(TEMPLATE . "header.php"); ?>

  <main class="container mt-4">
    <div class="container py-5">
      <div class="row d-flex justify-content-center align-items-center ">
        <div class="col col-md-9 col-lg-7 col-xl-5">
          <div class="card" style="border-radius: 15px;">
            <div class="card-body p-4">
              <div class="d-flex text-black">
                <div class="flex-shrink-0">
                  <img
                    src="https://media.istockphoto.com/id/1397556857/vector/avatar-13.jpg?s=612x612&w=0&k=20&c=n4kOY_OEVVIMkiCNOnFbCxM0yQBiKVea-ylQG62JErI="
                    alt="Generic placeholder image" class="img-fluid" style="width: 180px; border-radius: 10px;">
                </div>
                <div class="flex-grow-1 ms-3">
                  <h5 class="mb-1">
                    <?= $user->get_username() . " (" . $user->get_role() . ")" ?>
                  </h5>
                  <p class="mb-2 pb-1" style="color: #2b2a2a;">
                    <i>
                      <?= $user->get_email() ?>
                    </i>
                  </p>
                  <div class="d-flex justify-content-start rounded-3 p-2 mb-2" style="background-color: #efefef;">
                    <div>
                      <p class="small text-muted mb-1">Mot de passe : </p>
                      <p class="mb-0">
                        <?= $user->get_password() ?>
                      </p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!--
      <a href="/log.txt">Afficher les logs</a>
      -->
      
      <?php
        if ($user->get_role() == "Admin")
        {
          $default_url = "http://wapi:80";
          echo "<form id='stats' action='/stats' method='post'>
                  <input hidden name='url', value='" . $default_url . "'/>
                  <input type='submit' class='btn btn-primary mt-3' value='Afficher les statistiques du site'/>
                </form>";
        }
      ?>

      <?php
        if (isset($_SESSION["wargame-flag"]))
        {
          include(TEMPLATE . "popup.php");
          unset($_SESSION["wargame-flag"]);
        }
      ?>

  </main>

  <?php include(TEMPLATE . "footer.php"); ?>

</body>
</html>