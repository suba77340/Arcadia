<?php

namespace App\Controllers;

use App\Models\AnimauxModel;

class CompteurController extends Controller
{
    public function incrementer(): void
    {
        $data = json_decode(file_get_contents('php://input'), true);

        if (isset($data['animal_id']) && isset($data['animal_nom'])) {
            $animauxModel = new AnimauxModel;
            $animauxModel->logConsultation($data['animal_id'], $data['animal_nom']);
            header('Content-Type: application/json');
            echo json_encode(['message' => 'Consultation enregistrée']);
        } else {
            header('Content-Type: application/json');
            echo json_encode(['message' => 'Données invalides']);
        }
        exit();
    }

    public function obtenirCompteur(int $animalId): void
    {
        $animauxModel = new AnimauxModel;
        $result = $animauxModel->getConsultations($animalId);
        header('Content-Type: application/json');
        echo json_encode($result);
        exit();
    }
}
