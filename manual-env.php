<?php
function loadEnv($path) {
    if (!file_exists($path)) {
        throw new Exception("Le fichier .env est introuvable.");
    }

    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) {
            continue;
        }

        list($name, $value) = explode('=', $line, 2);
        $name = trim($name);
        $value = trim($value);

        putenv(sprintf('%s=%s', $name, $value));
        $_ENV[$name] = $value;
        $_SERVER[$name] = $value;
    }
}

// Chemin vers le fichier .env
$env_path = __DIR__ . '/.env';
loadEnv($env_path);

