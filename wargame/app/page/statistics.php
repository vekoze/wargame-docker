<?php

require_once MODEL . "user.php";

if(session_status() !== PHP_SESSION_ACTIVE) session_start();

$user_id = $_SESSION["user_id"];

// Redirect to home page if user is not logged in
if (!isset($user_id))
{
    header("Location: /");
    exit();
}

// Get user from ID
try
{
    $user = new User($user_id);
} catch (Exception $e) {
    header("Location: /");
    exit();
}

// Check if user is admin
if (!$user->is_admin())
{
    header("Location: /");
    exit();
}

// SSRF
if ($_SERVER['REQUEST_METHOD'] === 'POST')
{
    $url = $_POST["url"] ?? "";

    if (empty($url))
    {
        header("Location: /");
        exit(); 
    }

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'WARGAME-API-KEY: ' . getenv("WARGAME-API-KEY")
    ));

    $json_str = curl_exec($ch);

    if ($json_str === false) {
      echo 'cURL error: ' . curl_error($ch);
      exit();
    }

    curl_close($ch);

    $json_data = json_decode($json_str, true);

    if ($json_data === null) {
      echo 'JSON decoding error: ' . json_last_error_msg();
      exit();
  }
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
      
      <?php
        if (isset($json_data) && $json_data)
        {
            $total_visitor = $json_data["online-visitor"];

            echo "<h1>Statistiques</h1>
                    <p>Nombre de visiteur <span class='fw-bold'>" . $total_visitor . "</span></p>
                    <table class='table'>
                    <thead>
                        <tr>
                        <th scope='col'>Adresse IP</th>
                        <th scope='col'>Localisation</th>
                        </tr>
                    </thead>
                    <tbody>";
            
            foreach ($json_data["last-visitors"] as $visitor)
            {
                $ip = $visitor[0];
                $city = $visitor[1];
                echo "<tr>
                        <th scope='row'>" . $ip . "</th>
                        <td>" . $city . "</td>
                    </tr>";
            }

            echo    "</tbody>
                    </table>";
        }
      ?>

    </div>
  </main>

  <?php include(TEMPLATE . "footer.php"); ?>

</body>
</html>