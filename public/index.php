<?php

use App\Autoloader;
use App\Config\Main;
use Dotenv\Dotenv;

// constante contenant dossier racine du projet ARCADIA
define('ROOT', dirname(__DIR__));
//on importe autoloader
require_once ROOT.'/src/Autoloader.php';
Autoloader::register();

// Load environment variables from the .env file in the root directory
$dotenv = Dotenv::createImmutable(ROOT);
$dotenv->load();

// Main est le routeur 
    $app = new Main();

// Démarre l'application (start la méthode)
    $app->start();

