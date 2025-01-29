<?php

namespace App\Config;

use PDO;
use PDOException;

class Db extends PDO
{
    private static $instance;

    private function __construct()
    {
        $host = getenv('HOST');
        $dbname = getenv('DBNAME');
        $username = getenv('USERNAME');
        $password = getenv('PASSWORD');

        $_dsn = "mysql:dbname=$dbname;host=$host";
        try {
            parent::__construct($_dsn, $username, $password);

            $this->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES utf8');
            $this->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
            $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
}