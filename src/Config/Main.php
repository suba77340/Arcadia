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
        error_log("Requested URI: " . $uri);
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

        if (!empty($params) && $params[0] != '') {
            $controllerName = '\\App\\Controllers\\' . ucfirst(array_shift($params)) . 'Controller';
            if (class_exists($controllerName)) {
                $controller = new $controllerName();
                $action = (isset($params[0])) ? array_shift($params) : 'index';
                error_log("Controller: " . $controllerName . ", Action: " . $action);

                if (method_exists($controller, $action)) {
                    call_user_func_array([$controller, $action], $params);
                } else {
                    error_log("Method not found: " . $action);
                    http_response_code(404);
                    echo "La page recherchée n'existe pas";
                }
            } else {
                error_log("Controller not found: " . $controllerName);
                http_response_code(404);
                echo "La page recherchée n'existe pas";
            }
        } else {
            $controller = new MainController();
            $controller->index();
        }
    }

    public function addRoute($method, $route, $handler)
    {
        $this->routes[$method][$route] = $handler;
    }

    public function dispatch()
    {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $method = $_SERVER['REQUEST_METHOD'];
        error_log("Dispatching URI: " . $uri . ", Method: " . $method);

        if (!isset($this->routes[$method])) {
            error_log("No routes defined for method: " . $method);
            http_response_code(404);
            echo "La page recherchée n'existe pas";
            return;
        }

        foreach ($this->routes[$method] as $route => $handler) {
            $pattern = preg_replace('/{[^\/]+}/', '([^\/]+)', $route);
            if (preg_match('#^' . $pattern . '$#', $uri, $matches)) {
                array_shift($matches);
                if (is_callable($handler)) {
                    call_user_func_array($handler, $matches);
                } else {
                    list($controllerName, $method) = $handler;
                    $controller = new $controllerName();
                    if (method_exists($controller, $method)) {
                        call_user_func_array([$controller, $method], $matches);
                    } else {
                        error_log("Method not found in controller: " . $method);
                        http_response_code(404);
                        echo "La page recherchée n'existe pas";
                        return;
                    }
                }
                return;
            }
        }
    }
}

$main = new Main();
$main->addRoute('GET', '/admin/dashboard', [AdminController::class, 'dashboard']);
$main->addRoute('POST', '/admin/horaires/create', [HoraireController::class, 'create']);
$main->addRoute('GET', '/admin/horaires/edit/{id}', [HoraireController::class, 'edit']);
$main->addRoute('POST', '/admin/horaires/edit/{id}', [HoraireController::class, 'edit']);
$main->addRoute('POST', '/admin/horaires/delete/{id}', [HoraireController::class, 'delete']);
$main->addRoute('GET', '/horaire/read', [HoraireController::class, 'read']);
$main->addRoute('GET', '/users/login', [UsersController::class, 'login']);
$main->addRoute('POST', '/users/login', [UsersController::class, 'login']);

$main->dispatch();
