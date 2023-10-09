<?php

require_once MODEL . "destination.php";
require_once MODEL . "user.php";
require_once APP . "helper.php";

if(session_status() !== PHP_SESSION_ACTIVE) session_start();

$dst_idx = $_GET[0];

try
{
    $destination = new Destination($dst_idx);
} 
catch (Exception $e)
{
    header("Location: /");
    exit();
}

$is_logged_in = isset($_SESSION["user_id"]);

// Save the index in the session.
$_SESSION['last_destination_idx'] = $dst_idx;

// Add a review
if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    $comment = $_POST["comment"] ?? "";
    $rating = $_POST["rating"] ?? "";

    if (empty($comment) || empty($rating))
    {
        header("Location: /");
        exit();
    }

    $user_id = $_SESSION["user_id"];

    // Get user (the one who posted the review)
    try
    {
        $user = new User($user_id);
    } catch (Exception $e) {
        header("Location: /");
        exit();
    }

    // Sanitization
    $rating = max(0, min(5, $rating));
    $comment = sanitize_review_comment($comment);

    $destination->add_review($user_id, $comment, $rating);
    $destination->update_reviews();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <style>
        .star { cursor: pointer; padding: 2px;}
        .star-active { color: gold; }
        .carousel-img { width: 640px; height: 360px; }
    </style>
    <title><?= $destination->get_title() ?></title>
</head>
<body class="d-flex flex-column">

    <?php include(TEMPLATE . "header.php"); ?>

    <main class="d-flex flex-column align-items-center">

        <section class="mt-5 d-flex">
            <div id="destinationCarousel" class="carousel slide carousel-fade flex-fill">
                <div class="carousel-indicators">
                    <?php foreach ($destination->get_images() as $index => $image): ?>
                        <button 
                            type="button" 
                            data-bs-target="#destinationCarousel" 
                            data-bs-slide-to="<?= $index ?>" 
                            <?= $index === 0 ? 'class="active" aria-current="true"' : '' ?>
                            aria-label="Slide <?= $index + 1 ?>">
                        </button>
                    <?php endforeach; ?>
                </div>
                <div class="carousel-inner text-center">
                    <?php 
                    foreach ($destination->get_images() as $index => $image): 
                        $isActive = $index === 0 ? 'active' : '';
                    ?>
                        <div class="carousel-item <?= $isActive ?>">
                            <img src="/<?= $image["path"] ?>" alt="Image <?= $index + 1 ?>" class="img-fluid carousel-img">
                        </div>
                    <?php endforeach; ?>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#destinationCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#destinationCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
            <div class="ms-5 flex-fill">
                <h1><?= $destination->get_title() ?></h1>
                <p><?= $destination->get_description() ?></p>
                <?= Destination::get_rating_stars($destination->get_rating()); ?>
            </div>
        </section>

        <?php if ($is_logged_in): ?>
        <section class="mt-5 w-75 ">
            <h2>Laisser un avis</h2>
            <div class="container mt-5">
                <form action="" method="post">
                    <div class="form-group">
                        <textarea class="form-control" id="reviewContent" rows="4" name="comment" required></textarea>
                    </div>
                    <div class="form-group">
                        <div class="star-rating">
                            <span data-value="1" class="star">★</span>
                            <span data-value="2" class="star">★</span>
                            <span data-value="3" class="star">★</span>
                            <span data-value="4" class="star">★</span>
                            <span data-value="5" class="star">★</span>
                            <input hidden id="rating" name="rating" required/>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary mt-2">Poster</button>
                </form>
            </div>
        </section>
        <?php endif; ?>

        <?php if (count($destination->get_reviews()) != 0): ?>
        <section class="mt-5 w-75 ">
            <h2>Avis des utilisateurs</h2>

            <?php 
            foreach ($destination->get_reviews() as $review):
                $author = new User($review["id_User"]);
            ?>
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title"><?= $author->get_username() ?></h5>
                    <?= Destination::get_rating_stars($review["rating"]) ?>
                    <p class="card-text mt-3"><?= $review["comment"] ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </section>
        <?php endif; ?>

    </main>

    <?php include(TEMPLATE . "footer.php"); ?>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const stars = document.querySelectorAll('.star');
        stars.forEach(star => {
            star.addEventListener('click', function() {
                const value = this.getAttribute('data-value');
                console.log(document.getElementById('rating'));
                document.getElementById('rating').setAttribute('value',value);
                updateStars(value);
            });
        });
    });

    function updateStars(rating) {
        const stars = document.querySelectorAll('.star');
        stars.forEach((star, index) => {
            if (index < rating) {
                star.classList.add('star-active');
            } else {
                star.classList.remove('star-active');
            }
        });
    }
    </script>


</body>
</html>