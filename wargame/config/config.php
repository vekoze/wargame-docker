<?php

// Display errors
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL ^ E_DEPRECATED);

// Define constants
define("ROOT", dirname(dirname($_SERVER["SCRIPT_FILENAME"])) . "/");
define("APP", ROOT . "app/");
define("CONFIG", ROOT . "config/");
define("PHPMAILER", ROOT. "phpmailer/");

define("MODEL", ROOT . "app/model/");
define("VIEW", ROOT . "app/page/");
define("TEMPLATE", VIEW. "template/");

?>