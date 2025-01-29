<?php

namespace App\Controllers;

use App\Models\HoraireModel;
use App\Config\Form;

class HoraireController extends Controller
{
    private $horaireModel;

    public function __construct()
    {
        $this->horaireModel = new HoraireModel();
    }

    private function Admin()
    {
        if (!isset($_SESSION['users']) || $_SESSION['users']['role'] !== 1) {
            header('Location:/users/login');
            exit();
        }
    }

    public function edit($id)
    {
        $this->Admin();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (Form::validate($_POST, ['jour', 'ouverture', 'fermeture'])) {
                $data = $_POST;
                $this->horaireModel->updateHoraire($data['id'], $data['jour'], $data['ouverture'], $data['fermeture']);
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Validation a échoué']);
            }
        } else {
            $horaire = $this->horaireModel->findHoraireById($id);
            echo json_encode($horaire ? $horaire : ['success' => false, 'message' => 'Horaire non trouvé']);
        }
        exit();
    }

    public function create()
    {
        $this->Admin();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (Form::validate($_POST, ['jour', 'ouverture', 'fermeture'])) {
                $data = $_POST;
                $this->horaireModel->createHoraire($data['jour'], $data['ouverture'], $data['fermeture']);
                echo json_encode(['success' => true, 'message' => "L'horaire a été ajouté avec succès"]);
            } else {
                echo json_encode(['success' => false, 'message' => "Échec de l'ajout de l'horaire"]);
            }
        }
        exit();
    }

    public function delete($id)
    {
        $this->Admin();

        $result = $this->horaireModel->deleteHoraire($id);
        echo json_encode($result->getDeletedCount() === 1 ?
            ['success' => true, 'message' => "L'horaire a été supprimé avec succès"] :
            ['success' => false, 'message' => "Échec de la suppression."]);
        exit();
    }

    public function read()
    {
        $horaires = $this->horaireModel->findAllHoraires();
        foreach ($horaires as &$horaire) {
            $horaire['_id'] = (string) $horaire['_id'];
        }
        header('Content-Type: application/json');
        echo json_encode($horaires);
        exit();
    }
}
