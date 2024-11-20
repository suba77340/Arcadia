<?php

namespace App\Controllers;

use App\Models\AvisModel;

class MainController extends Controller
{
    public function index(): void
    {
        $avisModel = new AvisModel();
        $avisValidés = $avisModel->findAllValid();
        $this->render('main/index', ['avisValidés' => $avisValidés]);
    }

    public function ajouter(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $pseudo = $_POST['pseudo'];
            $commentaire = $_POST['commentaire'];

            $avisModel = new AvisModel();
            $avisModel->setPseudo($pseudo)
                ->setCommentaire($commentaire)
                ->setIdUsers($_SESSION['users']['id'] ?? null);

            if ($avisModel->create()) {
                header('Location: /employe/dashboard');
                exit;
            } else {
                echo "Erreur lors de l'ajout de l'avis.";
            }
        } else {
            $this->render('avis/ajouter');
        }
    }
}
