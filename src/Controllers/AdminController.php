<?php

namespace App\Controllers;

use App\Models\AnimauxModel;
use App\Models\ServicesModel;
use App\Models\HabitatsModel;
use App\Models\RapportVetModel;
use App\Models\HoraireModel;
use App\Config\Form;

class AdminController extends Controller
{
    public function dashboard()
    {
        if (!isset($_SESSION['users']) || $_SESSION['users']['role'] !== 1) {
            header('Location:/users/login');
            exit;
        }
        $animauxModel = new AnimauxModel();
        $animaux = $animauxModel->findAll();

        $servicesModel = new ServicesModel();
        $services = $servicesModel->findAll();

        $habitatsModel = new HabitatsModel();
        $habitats = $habitatsModel->findAll();

        $rapportVetModel = new RapportVetModel();
        $filtres = [];
        if (!empty($_GET['animal_id'])) {
            $filtres['animal_id'] = $_GET['animal_id'];
        }
        if (!empty($_GET['date_start']) && !empty($_GET['date_end'])) {
            $filtres['date_start'] = $_GET['date_start'];
            $filtres['date_end'] = $_GET['date_end'];
        }
        $rapports = $rapportVetModel->findByFiltre($filtres);

        $horaireModel = new HoraireModel();
        $horaires = $horaireModel->findAllHoraires();

        $this->render('dashboard/admin/dashboard', [
            'animaux' => $animaux,
            'services' => $services,
            'habitats' => $habitats,
            'rapports' => $rapports,
            'horaires' => $horaires,
        ]);
    }

    
    public function ajouter()
    {
        if ($_SESSION['users']['role'] !== 1) {
            header('Location:/users/login');
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nom = $_POST['nom'];
            $etat = $_POST['etat'];
            $race = $_POST['race'];
            $image = $_FILES['image'];
            if ($image['error'] === UPLOAD_ERR_OK) {
                $targetDir = 'uploads/';
                $targetFile = $targetDir . basename($image['name']);
                if (move_uploaded_file($image['tmp_name'], $targetFile)) {
                    $animauxModel = new AnimauxModel();
                    $animauxModel->setNom($nom)
                        ->setEtat($etat)
                        ->setRace($race)
                        ->setImage($targetFile);
                    $animauxModel->create();
                    header('Location:/admin/dashboard');
                    exit;
                } else {
                    echo "Erreur lors du téléchargement de l'image.";
                }
            }
        }
    }

    public function modifier($id)
    {
        if ($_SESSION['users']['role'] !== 1) {
            header('Location:/users/login');
            exit;
        }
        $animauxModel = new AnimauxModel();
        $animal = $animauxModel->find($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nom = $_POST['nom'];
            $etat = $_POST['etat'];
            $race = $_POST['race'];
            $image = $_FILES['image'];

            if ($image['error'] === UPLOAD_ERR_OK) {
                $targetDir = 'uploads/';
                $targetFile = $targetDir . basename($image['name']);
                if (move_uploaded_file($image['tmp_name'], $targetFile)) {
                    $animauxModel->setNom($nom)
                        ->setEtat($etat)
                        ->setRace($race)
                        ->setImage($targetFile)
                        ->update($id);
                    header('Location:/admin/dashboard');
                    exit;
                } else {
                    echo "Erreur lors du téléchargement de l'image.";
                }
            } else {
                $animauxModel->setNom($nom)
                    ->setEtat($etat)
                    ->setRace($race)
                    ->setImage($image)
                    ->update($id);
                header('Location:/admin/dashboard');
                exit;
            }
        } else {
            $animal = $animauxModel->find($id);

            $form = new Form();
            $form->debutForm('POST', '/admin/modifier/' . $animal['id'], ['enctype' => 'multipart/form-data'])
                ->ajoutLabelFor('nom', 'Nom:')
                ->ajoutInput('text', 'nom', ['required' => true, 'value' => $animal['nom'],'class' => 'form-control'])
                ->ajoutLabelFor('etat', 'État:')
                ->ajoutInput('text', 'etat', ['required' => true, 'value' => $animal['etat'],'class' => 'form-control'])
                ->ajoutLabelFor('race', 'Race:')
                ->ajoutInput('text', 'race', ['required' => true, 'value' => $animal['race'],'class' => 'form-control'])
                ->ajoutLabelFor('image', 'Image:')
                ->ajoutInput('file', 'image', ['class' => 'form-control'])
                ->ajoutBouton('Modifier', ['class' => 'btn btn-primary'])
                ->finForm();

            $this->render('dashboard/admin/modifier', ['form' => $form->create(), 'animal' => $animal]);
        }
    }

    public function supprimer()
    {
        if ($_SESSION['users']['role'] !== 1) {
            header('Location:/users/login');
            exit;
        }
        if (isset($_POST['id'])) {
            $animauxModel = new AnimauxModel();
            $animauxModel->delete($_POST['id']);
        }
        header('Location:/admin/dashboard');
        exit;
    }
}
