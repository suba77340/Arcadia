<?php

require_once ROOT . '/vendor/autoload.php';
use App\Autoloader;
use App\Config\Main;
use Dotenv\Dotenv;  // Ici, tu importes correctement la classe Dotenv


// constante contenant dossier racine du projet ARCADIA
define('ROOT', dirname(__DIR__));

// On importe l'autoloader
require_once ROOT . '/src/Autoloader.php';
Autoloader::register();

// Charger les variables d'environnement à partir du fichier .env
$dotenv = Dotenv::createImmutable(ROOT); // Crée l'instance et charge les variables
$dotenv->load(); // Charge les variables dans $_ENV

// Main est le routeur
$app = new Main();

// Démarre l'application (start la méthode)
$app->start();
