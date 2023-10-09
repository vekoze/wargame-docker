<?php

require_once "../config/config.php";
require_once CONFIG . "routes.php";

// Parse URI and render view
$uri = $_SERVER['PATH_INFO'] ?? $_SERVER['REQUEST_URI'] ?? '/';
$view = Router::parse($uri);

// If view does not exist, redirect to home by resetting URI
if (!file_exists($view))
{
    header('Location: /');
    exit();
}

require $view;

?>