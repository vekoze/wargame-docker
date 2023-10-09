<?php

require_once ROOT . "/app/router.php";

// Static routes
Router::connect("/", "home.php");
Router::connect("/register", "register.php");
Router::connect("/login", "login.php");
Router::connect("/random", "random.php");
Router::connect("/contact", "contact.php");
Router::connect("/secret", "secret.php");
Router::connect("/stats", "statistics.php");
Router::connect("/logout", "logout.php");

// Pattern routes
Router::connect("/destination/:id", "destination.php");
Router::connect("/user/:id", "profile.php");

?>