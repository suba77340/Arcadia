<?php

namespace App\Controllers;

use App\Models\NourrissageModel;
use App\Models\AnimauxModel;

class NourrissageController extends Controller
{
    public function index(): void
    {
        $nourrissageModel = new NourrissageModel();
        $nourrissages = $nourrissageModel->findAll();

        if (!is_array($nourrissages)) {
            $nourrissages = [];
        }
        $this->render('nourrissage/index', ['nourrissages' => $nourrissages]);
    }

    public function afficher($id): void
    {
        $nourrissageModel = new NourrissageModel();
        $nourrissage = $nourrissageModel->find($id);

        if (!$nourrissage) {
            http_response_code(404);
            $_SESSION['erreur'] = "Le nourrissage recherché n'existe pas";
            header('Location: /nourrissage');
            exit;
        }
        $this->render('nourrissage/afficher', ['nourrissage' => $nourrissage]);
    }
}
