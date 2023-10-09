<?php

class Database
{

    private static $instance;
    private $database;

    private function __construct()
    {
        $this->database = new SQLite3(ROOT . getenv("DATABASE_PATH"));
    }

    public static function get_connection()
    {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance->database;
    }

};

?>