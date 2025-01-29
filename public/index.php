<?php

require_once '../vendor/autoload.php';

use App\Autoloader;
use App\Config\Main;
use Dotenv\Dotenv;

// Define the ROOT constant to indicate the root directory of the project
define('ROOT', dirname(__DIR__));

// Include the autoloader to automatically manage the loading of classes
require_once __DIR__ . '/../Autoloader.php';

Autoloader::register();

// Load environment variables from the .env file in the root directory
// Assurez-vous que les variables d'environnement sont définies dans Heroku
$_ENV['HOST'] = getenv('HOST');
$_ENV['DBNAME'] = getenv('DBNAME');
$_ENV['USERNAME'] = getenv('USERNAME');
$_ENV['PASSWORD'] = getenv('PASSWORD');


// Start the application
$app = new Main();
$app->start();
