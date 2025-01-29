<?php

require_once '../vendor/autoload.php'; // Inclure l'autoloader de Composer

use App\Autoloader;
use App\Config\Main;

// constante contenant dossier racine du projet ARCADIA
define('ROOT', dirname(__DIR__));
//on importe autoloader
require_once ROOT.'/src/Autoloader.php';
Autoloader::register();

// Main est le routeur 
    $app = new Main();

// Démarre l'application (start la méthode)
    $app->start();