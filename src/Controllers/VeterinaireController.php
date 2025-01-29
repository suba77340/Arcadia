<?php

namespace App\Controllers;

use App\Config\Form;
use App\Models\AnimauxModel;
use App\Models\RapportVetModel;
use App\Models\NourrissageModel;
use App\Models\HabitatsModel;

class VeterinaireController extends Controller
{
    public function dashboard()
    {
        if ($_SESSION['users']['role'] !== 3) {
            header('Location:/users/login');
            exit;
        }

        $animauxModel = new AnimauxModel();
        $animaux = $animauxModel->findAll();

        $nourrissageModel = new NourrissageModel();
        $nourrissages = $nourrissageModel->findAll();

        $habitatsModel = new HabitatsModel();
        $habitats = $habitatsModel->findAll();
        $commentaire = $habitatsModel->getCommentaires();

        $rapportVetModel = new RapportVetModel();
        $rapports = $rapportVetModel->findAll();

        $this->render('dashboard/veterinaire/dashboard', [
            'animaux' => $animaux,
            'nourrissages' => $nourrissages,
            'habitats' => $habitats,
            'commentaire' => $commentaire,
            'rapports' => $rapports
        ]);
    }

    public function ajouterAvisHabitats($id_habitat)
    {
        if ($_SESSION['users']['role'] !== 3) {
            header('Location:/users/login');
            exit;
        }

        $habitatsModel = new HabitatsModel();
        $habitat = $habitatsModel->find($id_habitat);

        if (!$habitat) {
            echo "Habitat non trouvé.";
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $commentaire = $_POST['commentaire'];

            $habitatsModel->setIdUsers($_SESSION['users']['id'])
                ->setCommentaire($commentaire);

            if ($habitatsModel->updateCommentaire($id_habitat)) {
                header('Location: /veterinaire/dashboard');
                exit;
            } else {
                echo "Erreur lors de l'ajout du commentaire.";
            }
        }

        $form = new Form();
        $form->debutForm('POST', '/veterinaire/ajouterAvisHabitats/' . $id_habitat, ['enctype' => 'multipart/form-data'])
            ->ajoutLabelFor('commentaire', 'Ajouter un commentaire:')
            ->ajoutTextarea('commentaire', '', ['id' => 'commentaire', 'class' => 'form-control'])
            ->ajoutBouton('Soumettre', ['class' => 'btn btn-primary'])
            ->finForm();
        $this->render('dashboard/veterinaire/ajouterAvisHabitats', ['form' => $form->create(), 'habitat' => $habitat]);
    }

    public function ajouterRapport($id_animal)
    {
        if ($_SESSION['users']['role'] !== 3) {
            header('Location:/users/login');
            exit;
        }

        $animauxModel = new AnimauxModel();
        $animal = $animauxModel->find($id_animal);

        if (!$animal) {
            echo "Animal non trouvé.";
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $rapport = $_POST['rapport'];
            $la_date = date('Y-m-d H:i:s');

            $rapportVetModel = new RapportVetModel();
            $rapportVetModel->setIdAnimal($id_animal)
                ->setIdUsers($_SESSION['users']['id'])
                ->setLaDate($la_date)
                ->setRapport($rapport);
            if ($rapportVetModel->create()) {
                header('Location: /veterinaire/dashboard');
                exit;
            } else {
                echo "Erreur lors de l'ajout du rapport.";
            }
        }
        $form = new Form();
        $form->debutForm('POST', '/veterinaire/ajouterRapport/' . $animal['id'], [])
            ->ajoutLabelFor('rapport', 'Rapport:')
            ->ajoutTextarea('rapport', '', ['id' => 'rapport', 'class' => 'form-control', 'rows' => 4])
            ->ajoutBouton('Soumettre', ['class' => 'btn btn-primary'])
            ->finForm();

        $this->render('dashboard/veterinaire/ajouterRapport', ['animal' => $animal, 'form' => $form->create()]);
    }

    public function ajouterAvisHabitat($id_habitat)
    {
        if ($_SESSION['users']['role'] !== 3) {
            header('Location:/users/login');
            exit;
        }

        $habitatsModel = new HabitatsModel();
        $habitat = $habitatsModel->find($id_habitat);

        if (!$habitat) {
            echo "Habitat non trouvé.";
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $commentaire = $_POST['commentaire'];

            $habitatsModel->setIdUsers($_SESSION['users']['id'])
                ->setCommentaire($commentaire);

            if ($habitatsModel->updateCommentaire($id_habitat)) {
                header('Location: /veterinaire/dashboard');
                exit;
            } else {
                echo "Erreur lors de l'ajout du commentaire.";
            }
        }
    }
}
