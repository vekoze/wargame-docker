<?php

require_once MODEL . "user.php";
require_once APP . "helper.php";

if(session_status() !== PHP_SESSION_ACTIVE) session_start();

$is_logged_in = isset($_SESSION["user_id"]);

?>
<header>
    <nav class="navbar navbar-expand-md bg-body-tertiary w-100">
        <div class="container-fluid">
            <a class="navbar-brand" href="/">Voyage++ ✨</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse"
                aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <ul class="navbar-nav mb-2 mb-md-0">
                    <li class="nav-item active">
                        <a class="nav-link" href="/">Accueil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/random">Destination aléatoire</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/contact">Nous contacter</a>
                    </li>
                </ul>

                <div class="d-flex ms-auto">
                    <?php 
                    if ($is_logged_in):
                        $connected_user = new User($_SESSION["user_id"]);
                        $id = $connected_user->get_id(); 
                    ?>
                        <a href="/user/<?= encode_user_id($id) ?>"><img src="/img/icon/login.png" alt="Profil" title="Login" width="50" height="50"></a>
                        <a href="/logout"><img src="/img/icon/logout.png" alt="Profil" title="Logout" width="70" height="50"></a>
                    <?php else: ?>
                        <a href="/login" class="btn btn-primary me-2">Connexion</a>
                        <a href="/register" class="btn btn-danger">Inscription</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>
</header>