<?php

// Ajoute cette ligne au début du fichier index.php si elle n'existe pas déjà
require_once __DIR__ . '/../vendor/autoload.php';

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

// Vérifie si le fichier .env existe avant de le charger
if (file_exists(ROOT . '/.env')) {
    $dotenv->load();
} else {
    // Ou tu peux loguer une erreur si tu veux
    error_log('Le fichier .env n\'a pas été trouvé');
}

// Main est le routeur 
    $app = new Main();

// Démarre l'application (start la méthode)
    $app->start();

