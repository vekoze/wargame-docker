<?php

require_once MODEL . "destination.php";
require_once MODEL . "user.php";

if(session_status() !== PHP_SESSION_ACTIVE) session_start();

$user_id = $_SESSION["user_id"] ?? "";

if(!empty($user_id))
{
    try
    {
        $user = new User($user_id);
        if ($user->is_superadmin())
        {
            $_SESSION["wargame-flag"] = "flag{mD5_4_ReAL?}";
        }
    } catch (Exception $e) {
        // Unset user_id if user not found
        unset($_SESSION["user_id"]);
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <!-- TODO : login d3vel0per/d3vel0per -->
    <title>Accueil</title>
</head>
<body class="d-flex flex-column vh-100">

    <?php include(TEMPLATE . "header.php"); ?>

    <main>
        <div class="container">
            <h1 class="mt-5 mb-5">Destinations :</h1>
            <div class="row">
                <?php foreach (Destination::get_destinations() as $destination):
                    $tabimages =  $destination->get_images();
                    $first_image = reset($tabimages);// get the first element of the array
                ?>
                <div class="col-lg-4 col-md-6 mb-4">
                    <a class="text-decoration-none" href="<?= "/destination/" . $destination->get_id();?>" class="card-link">
                        <div class="card">
                            <div class="card-body">
                                <!-- Title above the image -->
                                <h5 class="card-title"><?= $destination->get_title() ?></h5>
                            </div>
                            <!-- Centered and 75% width image with space at the bottom -->
                            <div class="text-center" style="margin-bottom: 20px;">
                                <img src="<?= $first_image["path"]; ?>" class="card-img img-fluid" style="width: 75%; height: 200px" alt="<?= $destination->get_title() ?>">
                            </div>
                            <!-- Absolute positioning for the larger rating stars -->
                            <div style="position: absolute; top: 10px; right: 10px; font-size: 24px;">
                                <?= Destination::get_rating_stars($destination->get_rating()) ?>
                            </div>
                        </div>
                    </a>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </main>

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