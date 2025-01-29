<?php

namespace App\Config;

session_start();

use App\Controllers\MainController;
use App\Controllers\AdminController;
use App\Controllers\HoraireController;
use App\Controllers\UsersController;

class Main
{
    private $routes = [];

    public function start()
    {
        $uri = $_SERVER['REQUEST_URI'];
        // On supprime le dernier slash si présent
        if (!empty($uri) && $uri != '/' && $uri[-1] === "/") {
            $uri = substr($uri, 0, -1);
            http_response_code(301);
            header('Location: ' . $uri);
            exit();
        }

        $params = [];
        if (isset($_GET['p']) && !empty($_GET['p'])) {
            $params = explode('/', $_GET['p']);
        }

        // On vérifie si l'URL correspond à une route définie
        if (!empty($params) && $params[0] != '') {
            $this->handleRoute($params);
        } else {
            // Si aucune route n'est trouvée, on utilise le contrôleur par défaut
            $controller = new MainController();
            $controller->index();
        }
    }

    public function addRoute($method, $route, $handler)
    {
        $this->routes[$method][$route] = $handler;
    }

    private function handleRoute($params)
    {
        $controllerName = '\\App\\Controllers\\' . ucfirst(array_shift($params)) . 'Controller';
        $action = (isset($params[0])) ? array_shift($params) : 'index';

        if (class_exists($controllerName)) {
            $controller = new $controllerName();
            if (method_exists($controller, $action)) {
                call_user_func_array([$controller, $action], $params);
            } else {
                $this->sendError("Méthode non trouvée : " . $action);
            }
        } else {
            $this->sendError("Contrôleur non trouvé : " . $controllerName);
        }
    }

    private function sendError($message)
    {
        error_log($message);
        http_response_code(404);
        echo "";
    }

    public function dispatch()
    {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $method = $_SERVER['REQUEST_METHOD'];
        error_log("Dispatching URI: " . $uri . ", Method: " . $method);

        if (!isset($this->routes[$method])) {
            error_log("Aucune route définie pour la méthode : " . $method);
            $this->sendError("La page recherchée n'existe pas");
            return;
        }

        foreach ($this->routes[$method] as $route => $handler) {
            $pattern = preg_replace('/{[^\/]+}/', '([^\/]+)', $route);
            if (preg_match('#^' . $pattern . '$#', $uri, $matches)) {
                array_shift($matches); // Supprimer la première correspondance (URI)
                $this->callHandler($handler, $matches);
                return;
            }
        }

        // Si aucune route ne correspond
        $this->sendError("La page recherchée n'existe pas");
    }

    private function callHandler($handler, $matches)
    {
        if (is_callable($handler)) {
            call_user_func_array($handler, $matches);
        } else {
            list($controllerName, $method) = $handler;
            $controller = new $controllerName();
            if (method_exists($controller, $method)) {
                call_user_func_array([$controller, $method], $matches);
            } else {
                $this->sendError("Méthode non trouvée dans le contrôleur : " . $method);
            }
        }
    }
}

// Ajouter les routes
$main = new Main();
$main->addRoute('GET', '/admin/dashboard', [AdminController::class, 'dashboard']);
$main->addRoute('POST', '/admin/horaires/create', [HoraireController::class, 'create']);
$main->addRoute('GET', '/admin/horaires/edit/{id}', [HoraireController::class, 'edit']);
$main->addRoute('POST', '/admin/horaires/edit/{id}', [HoraireController::class, 'edit']);
$main->addRoute('POST', '/admin/horaires/delete/{id}', [HoraireController::class, 'delete']);
$main->addRoute('GET', '/horaire/read', [HoraireController::class, 'read']);
$main->addRoute('GET', '/users/login', [UsersController::class, 'login']);
$main->addRoute('POST', '/users/login', [UsersController::class, 'login']);

// Démarrer le dispatching
$main->dispatch();
