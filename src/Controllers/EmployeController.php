<?php

namespace App\Controllers;

use App\Config\Form;
use App\Models\AnimauxModel;
use App\Models\AvisModel;
use App\Models\NourrissageModel;
use App\Models\ServicesModel;
use App\Models\ContactModel;

class EmployeController extends Controller
{
    public function dashboard()
    {
        if ($_SESSION['users']['role'] !== 2) {
            header('Location:/users/login');
            exit;
        }

        $animauxModel = new AnimauxModel();
        $animaux = $animauxModel->findAll();

        $avisModel = new AvisModel();
        $avisNonValidés = $avisModel->findUnvalidated();

        $servicesModel = new ServicesModel();
        $services = $servicesModel->findAll();

        $nourrissageModel = new NourrissageModel();
        $nourrissages = $nourrissageModel->findWithAnimalNames();

        $this->render('dashboard/employe/dashboard', [
            'animaux' => $animaux,
            'avisNonValidés' => $avisNonValidés,
            'services' => $services,
            'nourrissages' => $nourrissages
        ]);
    }

    public function ajouterNourriture($id_animal)
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if ($_SESSION['users']['role'] !== 2) {
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
            $type_nourriture = $_POST['type_nourriture'];
            $quantite = $_POST['quantite'];
            $date_repas = $_POST['date_repas'];
            $heure_repas = $_POST['heure_repas'];

            $nourrissageModel = new NourrissageModel();
            $nourrissageModel->setIdAnimal($id_animal)
                ->setIdUsers($_SESSION['users']['id'])
                ->setTypeNourriture($type_nourriture)
                ->setQuantite($quantite)
                ->setDateRepas($date_repas)
                ->setHeureRepas($heure_repas);

            if ($nourrissageModel->nourrissage()) {
                header('Location: /employe/dashboard');
                exit;
            } else {
                echo "Erreur lors de l'ajout de la nourriture.";
            }
        }

        $form = new Form();
        $form->debutForm('POST', '/employe/ajouterNourriture/' . $id_animal, ['enctype' => 'multipart/form-data'])
            ->ajoutLabelFor('type_nourriture', 'Type de nourriture:')
            ->ajoutInput('text', 'type_nourriture', ['id' => 'type_nourriture', 'class' => 'form-control'])
            ->ajoutLabelFor('quantite', 'Quantité:')
            ->ajoutInput('number', 'quantite', ['id' => 'quantite', 'class' => 'form-control'])
            ->ajoutLabelFor('date_repas', 'Date du repas:')
            ->ajoutInput('date', 'date_repas', ['id' => 'date_repas', 'class' => 'form-control'])
            ->ajoutLabelFor('heure_repas', 'Heure du repas:')
            ->ajoutInput('time', 'heure_repas', ['id' => 'heure_repas', 'class' => 'form-control'])
            ->ajoutBouton('Ajouter', ['class' => 'btn btn-primary'])
            ->finForm();

        $this->render('dashboard/employe/ajouterNourriture', ['form' => $form->create(), 'animal' => $animal]);
    }


    public function supprimerNourriture($id)
    {
        if ($_SESSION['users']['role'] !== 2) {
            header('Location:/users/login');
            exit;
        }
        $nourrissageModel = new NourrissageModel();
        $nourrissage = $nourrissageModel->find($id);
        if (!$nourrissage) {
            http_response_code(404);
            $_SESSION['erreur'] = "Le nourrissage recherché n'existe pas";
            header('Location: /employe/dashboard');
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($nourrissageModel->delete($id)) {
                $_SESSION['message'] = "Le nourrissage a été supprimé avec succès";
                header('Location: /employe/dashboard');
                exit;
            } else {
                echo "Erreur lors de la suppression du nourrissage.";
            }
        }
        $this->render('dashboard/employe/supprimerNourriture', ['nourrissage' => $nourrissage]);
    }


    public function modifierService($id)
    {
        if ($_SESSION['users']['role'] !== 2) {
            header('Location:/users/login');
            exit;
        }

        $servicesModel = new ServicesModel();
        $service = $servicesModel->find($id);

        if (!$service) {
            echo "Service non trouvé.";
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nom = strip_tags($_POST['nom']);
            $descriptif = strip_tags($_POST['descriptif']);
            $image = $_FILES['image']['name'] ?? $service['image'];

            if (isset($_FILES["image"]) && $_FILES["image"]["error"] === 0) {
                $allowed = ["jpg" => "image/jpeg", "jpeg" => "image/jpeg", "png" => "image/png"];
                $filename = $_FILES["image"]["name"];
                $filetype = $_FILES["image"]["type"];
                $filesize = $_FILES["image"]["size"];
                $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

                if (!array_key_exists($extension, $allowed) || !in_array($filetype, $allowed)) {
                    die("Erreur: format du fichier incorrect");
                }

                if ($filesize > 20 * 1024 * 1024) {
                    die("Erreur: fichier trop volumineux");
                }

                $newname = uniqid();
                $newfilename = __DIR__ . "/../../public/uploads/" . $newname . "." . $extension;

                if (!move_uploaded_file($_FILES["image"]["tmp_name"], $newfilename)) {
                    die("Erreur: l'upload a échoué");
                }
                chmod($newfilename, 0644);
                $image = "$newname.$extension";
            }

            $servicesModel->setId($service['id'])
                ->setNom($nom)
                ->setDescriptif($descriptif)
                ->setImage($image)
                ->update($id);

            header('Location:/employe/dashboard');
            exit;
        }

        $form = new Form();
        $form->debutForm('POST', '/employe/modifierService/' . $service['id'], ['enctype' => 'multipart/form-data'])
            ->ajoutLabelFor('nom', 'Nom du service:')
            ->ajoutInput('text', 'nom', [
                'id' => 'nom',
                'class' => 'form-control',
                'value' => $service['nom']
            ])
            ->ajoutLabelFor('descriptif', 'Descriptif du service:')
            ->ajoutTextarea('descriptif', $service['descriptif'], [
                'id' => 'descriptif',
                'class' => 'form-control'
            ])
            ->ajoutLabelFor('image', 'Image du service:')
            ->ajoutInput('file', 'image', [
                'id' => 'image',
                'class' => 'form-control'
            ])
            ->ajoutBouton('Modifier', ['class' => 'btn btn-primary'])
            ->finForm();

        $this->render('dashboard/employe/modifierService', ['form' => $form->create(), 'service' => $service]);
    }

    public function supprimerService()
    {
        if ($_SESSION['users']['role'] !== 2) {
            header('Location:/users/login');
            exit;
        }

        if (isset($_POST['id'])) {
            $servicesModel = new ServicesModel();
            $servicesModel->delete($_POST['id']);
            $_SESSION['message'] = "Le service a été supprimé avec succès";
        }

        header('Location:/employe/dashboard');
        exit;
    }

    public function afficherContact()
    {
        $contactModel = new ContactModel();
        $contact = $contactModel->findAllContact();

        $this->render('employe/contact', ['contact' => $contact]);
    }
}
