<?php

namespace App\Config;

use PDO;
use PDOException;

class Db extends PDO
{
    private static $instance;
    private function __construct()
    {
        $dsn = 'mysql:host=' . $_ENV['DB_HOST'] . ';port=' . $_ENV['DB_PORT'] . ';dbname=' . $_ENV['DB_DATABASE'];
        parent::__construct($dsn, $_ENV['DB_USERNAME'], $_ENV['DB_PASSWORD']);
        $this->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }


    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
}