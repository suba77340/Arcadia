<?php

namespace App\Config;

use PDO;

class Db extends PDO
{
    private static $instance;

    private function __construct()
    {
    
        if (!isset($_ENV['HOST'], $_ENV['DBNAME'], $_ENV['USERNAME'], $_ENV['PASSWORD'])) {
            throw new \Exception("Les variables d'environnement pour la base de données sont manquantes.");
        }

        $dsn = 'mysql:host=' . $_ENV['HOST'] . ';dbname=' . $_ENV['DBNAME'];
        parent::__construct($dsn, $_ENV['USERNAME'], $_ENV['PASSWORD']);
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

