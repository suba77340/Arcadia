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

// Vérifie si on est sur Heroku ou en local pour charger correctement les variables d'environnement
if (file_exists(ROOT . '/.env') && getenv('HEROKU') === false) {
    // Charge les variables d'environnement depuis le fichier .env en local uniquement
    $dotenv->load();
} else {
    // Si sur Heroku, on n'a pas besoin de .env, les variables d'env sont définies dans Heroku
    error_log('Sur Heroku, les variables d\'environnement sont définies via la plateforme.');
}

// Main est le routeur
    $app = new Main();

// Démarre l'application (start la méthode)
    $app->start();

