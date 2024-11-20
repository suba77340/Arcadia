<?php

namespace App\Controllers;

use App\Models\AvisModel;

class AvisController extends Controller
{
    public function dashboard()
    {
        if ($_SESSION['users']['role'] !== 2) {
            header('Location:/users/login');
            exit;
        }

        $avisModel = new AvisModel();
        $avisNonValidés = $avisModel->findUnvalidated();
        $avisValidés = $avisModel->findAllValid();
        $this->render('dashboard/employe/dashboard', [
            'avisNonValidés' => $avisNonValidés,
            'avisValidés' => $avisValidés,
        ]);
    }

    public function validerAvis($id)
    {
        if ($_SESSION['users']['role'] !== 2) {
            header('Location:/users/login');
            exit;
        }
        $avisModel = new AvisModel();
        if ($avisModel->validate($id)) {
            header('Location: /employe/dashboard');
            exit;
        } else {
            echo "Erreur lors de la validation de l'avis.";
        }
    }

    public function supprimerAvis($id)
    {
        if ($_SESSION['users']['role'] !== 2) {
            header('Location:/users/login');
            exit;
        }

        $avisModel = new AvisModel();
        if ($avisModel->delete($id)) {
            header('Location: /employe/dashboard');
            exit;
        } else {
            echo "Erreur lors de la suppression de l'avis.";
        }
    }
}
