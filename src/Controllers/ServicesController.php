<?php

namespace App\Controllers;

use App\Config\Form;
use App\Models\ServicesModel;

class ServicesController extends Controller
{
    public function index(): void
    {
        $servicesModel = new ServicesModel();
        $services = $servicesModel->findAll();
        if (!is_array($services)) {
            $services = [];
        }
        $this->render('services/index', ['services' => $services]);
    }

    public function lire(int $id): void
    {
        $servicesModel = new ServicesModel();
        $service = $servicesModel->find($id);
        $this->render('services/lire', ['service' => $service]);
    }

    public function ajouter()
    {
        if (isset($_SESSION['users']) && !empty($_SESSION['users']['id'])) {
            if (Form::validate($_POST, ['nom', 'descriptif'])) {
                $nom = strip_tags($_POST['nom']);
                $descriptif = strip_tags($_POST['descriptif']);
                $image = '';

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
                 // Création d'un nouveau service via le modèle
                $service = new ServicesModel();
                $service->setNom($nom)
                    ->setDescriptif($descriptif)
                    ->setImage($image)
                    ->create();

                $_SESSION['message'] = "Le service a été ajouté avec succès";
                header('Location: /services');
                exit;
            }
            // Affichage du formulaire
            $form = new Form();
            $form->debutForm('POST', '/services/ajouter', ['enctype' => 'multipart/form-data'])
                ->ajoutLabelFor('nom', 'Nom du service:')
                ->ajoutInput('text', 'nom', [
                    'id' => 'nom',
                    'class' => 'form-control'
                ])
                ->ajoutLabelFor('descriptif', 'Descriptif du service:')
                ->ajoutTextarea('descriptif', '', [
                    'id' => 'descriptif',
                    'class' => 'form-control'
                ])
                ->ajoutLabelFor('image', 'Image du service:')
                ->ajoutInput('file', 'image', [
                    'id' => 'image',
                    'class' => 'form-control'
                ])
                ->ajoutBouton('Ajouter', ['class' => 'btn btn-primary'])
                ->finForm();
            // Génération du formulaire
            $this->render('services/ajouter', ['form' => $form->create()]);
        } else {
            $_SESSION['erreur'] = 'Vous devez être connecté pour accéder à cette page';
            header('Location: /users/login');
            exit;
        }
    }

    public function modifier(int $id)
    {
        if (isset($_SESSION['users']) && !empty($_SESSION['users']['id'])) {
            $servicesModel = new ServicesModel();
            $service = $servicesModel->find($id);

            if (!$service) {
                http_response_code(404);
                $_SESSION['erreur'] = "Le service recherché n'existe pas";
                header('Location: /services');
                exit;
            }

            if (Form::validate($_POST, ['nom', 'descriptif'])) {
                $nom = strip_tags($_POST['nom']);
                $descriptif = strip_tags($_POST['descriptif']);
                $image = $_FILES['image']['name'] ?? $service['image'];

                $serviceModif = new ServicesModel();
                $serviceModif->setId($service['id'])
                    ->setNom($nom)
                    ->setDescriptif($descriptif);

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

                $serviceModif->setImage($image);
                $serviceModif->update($id);

                $_SESSION['message'] = 'Votre service a été modifié avec succès';
                header('Location: /admin/dashboard');
                exit;
            }

            $form = new Form();
            $form->debutForm('POST', '/services/modifier/' . $service['id'], ['enctype' => 'multipart/form-data'])
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
            $this->render('services/modifier', ['form' => $form->create(), 'service' => $service]);
        } else {
            $_SESSION['erreur'] = 'Vous devez être connecté pour accéder à cette page';
            header('Location: /users/login');
            exit;
        }
    }

    public function supprimer()
    {
        if (isset($_SESSION['users']) && !empty($_SESSION['users']['id'])) {
            if (isset($_POST['id'])) {
                $servicesModel = new ServicesModel();
                $servicesModel->delete($_POST['id']);
                $_SESSION['message'] = "Le service a été supprimé avec succès";
            }
            header('Location: /admin/dashboard');
            exit;
        } else {
            $_SESSION['erreur'] = 'Vous devez être connecté pour accéder à cette page';
            header('Location: /users/login');
            exit;
        }
    }
}
