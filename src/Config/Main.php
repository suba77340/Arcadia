<?php

namespace App\Config;

use App\Controllers\MainController;
//routeur principal
class Main
{
    public function start()
    {   //demarre session
        session_start();
        //recupere l'URL et verifie si elle est n'est pas vide et se termine par /
        $uri = $_SERVER['REQUEST_URI'];
        if (!empty($uri) && $uri != '/' && $uri[-1] === "/") {
            // enleve le /
            $uri = substr($uri, 0, -1);
            http_response_code(301);
            //redirige vers URL sans /
            header('location: ' . $uri);
        }
        $params = [];
        if (isset($_GET['p']))
            //separer parametre ds tableau dans fichier p(controleur,methode,parametre)
            $params = explode('/', $_GET['p']);

        if ($params[0] != '') {
            //au moins 1 parametre donc recupere nom du controleur à instancier
            //majuscle la 1ere letttre, ajoute namespace et "controller"
            $controller = '\\App\\Controllers\\' . ucfirst(array_shift($params)) . 'Controller';
            // Vérifie si la classe existe
            if (class_exists($controller)) {
                $controller = new $controller();
                // Récupère 2ème paramètre de l'URL
                $action = (isset($params[0])) ? array_shift($params) : 'index';

                if (method_exists($controller, $action)) {
                    // S'il reste des paramètres, les passer à la méthode
                    call_user_func_array([$controller, $action], $params);
                } else { // page n'existe pas
                    http_response_code(404);
                    echo "La page recherchée n'existe pas";
                }
            } else {
                http_response_code(404); // Classe non trouvée
            }
        } else {
            // Si pas de paramètres, instancier le contrôleur par défaut
            $controller = new MainController();
            // Appelle la méthode index
            $controller->index();
        }
    }

    
}
