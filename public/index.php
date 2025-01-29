<?php

use App\Autoloader;
use App\Config\Main;
use Dotenv\Dotenv;

// constante contenant dossier racine du projet ARCADIA
define('ROOT', dirname(__DIR__));
//on importe autoloader
require_once ROOT.'/src/Autoloader.php';
Autoloader::register();

$ENV['HOST'] = getenv('HOST');
$ENV['DBNAME'] = getenv('DBNAME');
$ENV['USERNAME'] = getenv('USERNAME');
$ENV['PASSWORD'] = getenv('PASSWORD');

// Main est le routeur
    $app = new Main();

// Démarre l'application (start la méthode)
    $app->start();

