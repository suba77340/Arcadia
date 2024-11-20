<?php

namespace App\Controllers;

abstract class Controller
{
    public function render(string $fichier, array $data = [], string $template = 'default')
    {
        //extrait le contenu des donnees pour rendre la vue
        extract($data);

        //demarre buffer sortie, memoire stocke temp
        ob_start();

        //chemain vers fichier vue (animaux / index)
        require_once ROOT . '/src/Views/' . $fichier . '.php';
        // transfert buffer dans son $contenu
        $contenu = ob_get_clean();
        //inclus fichier default pour template global
        require_once ROOT . '/src/Views/' . $template . '.php';
    }
}
