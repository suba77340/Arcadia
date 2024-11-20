<?php

namespace App\Controllers;

use App\Config\Form;
use App\Models\HabitatsModel;
use App\Models\AnimauxModel;

class HabitatsController extends Controller
{
    public function index(): void
    {
        $habitatsModel = new HabitatsModel();
        $habitats = $habitatsModel->findAll();
        if (!is_array($habitats)) {
            $habitats = [];
        }
        $this->render('habitats/index', ['habitats' => $habitats]);
    }


    public function afficherAnimaux(int $id): void
    {
        $animauxModel = new AnimauxModel();
        $animaux = $animauxModel->findByHabitat($id);

        $this->render('habitats/animaux', ['animaux' => $animaux, 'id' => $id]);
    }

    public function lire(int $id): void
    {
        $habitatsModel = new HabitatsModel();
        $habitats = $habitatsModel->findById($id);
        $this->render('habitats/lire', ['habitat' => $habitats]);
    }


    public function ajouter()
    {
        if (isset($_SESSION['users']) && !empty($_SESSION['users']['id'])) {
            if (Form::validate($_POST, ['nom', 'descriptif', 'commentaire'])) {
                $nom = strip_tags($_POST['nom']);
                $descriptif = strip_tags($_POST['descriptif']);
                $commentaire = strip_tags($_POST['commentaire']);
                $photo = '';

                if (isset($_FILES["photo"]) && $_FILES["photo"]["error"] === 0) {
                    $allowed = ["jpg" => "image/jpeg", "jpeg" => "image/jpeg", "png" => "image/png"];
                    $filename = $_FILES["photo"]["name"];
                    $filetype = $_FILES["photo"]["type"];
                    $filesize = $_FILES["photo"]["size"];
                    $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

                    if (!array_key_exists($extension, $allowed) || !in_array($filetype, $allowed)) {
                        die("Erreur: format du fichier incorrect");
                    }

                    if ($filesize > 20 * 1024 * 1024) {
                        die("Erreur: fichier trop volumineux");
                    }

                    $newname = uniqid();
                    $newfilename = __DIR__ . "/../../public/uploads/" . $newname . "." . $extension;

                    if (!move_uploaded_file($_FILES["photo"]["tmp_name"], $newfilename)) {
                        die("Erreur: l'upload a échoué");
                    }

                    chmod($newfilename, 0644);
                    $photo = "$newname.$extension";
                }

                $habitats = new HabitatsModel();
                $habitats->setNom($nom)
                    ->setDescriptif($descriptif)
                    ->setCommentaire($commentaire)
                    ->setPhoto($photo);
                $habitats->create();

                $_SESSION['message'] = "L'habitat a été ajouté avec succès";
                header('Location: /habitats');
                exit;
            }

            $form = new Form();
            $form->debutForm('POST', '/habitats/ajouter', ['enctype' => 'multipart/form-data'])
                ->ajoutLabelFor('nom', 'Nom de l\'habitat:')
                ->ajoutInput('text', 'nom', [
                    'id' => 'nom',
                    'class' => 'form-control'
                ])
                ->ajoutLabelFor('descriptif', 'Descriptif de l\'habitat:')
                ->ajoutTextarea('descriptif', '', [
                    'id' => 'descriptif',
                    'class' => 'form-control'
                ])
                ->ajoutLabelFor('commentaire', 'Commentaire:')
                ->ajoutTextarea('commentaire', '', [
                    'id' => 'commentaire',
                    'class' => 'form-control'
                ])
                ->ajoutLabelFor('photo', 'Photo de l\'habitat:')
                ->ajoutInput('file', 'photo', [
                    'id' => 'photo',
                    'class' => 'form-control'
                ])
                ->ajoutBouton('Ajouter', ['class' => 'btn btn-primary'])
                ->finForm();

            $this->render('habitats/ajouter', ['form' => $form->create()]);
        } else {
            $_SESSION['erreur'] = 'Vous devez être connecté pour accéder à cette page';
            header('Location: /users/login');
            exit;
        }
    }

    public function modifier(int $id)
    {
        if (isset($_SESSION['users']) && !empty($_SESSION['users']['id'])) {
            $habitatsModel = new HabitatsModel();
            $habitat = $habitatsModel->findById($id);

            if (Form::validate($_POST, ['nom', 'descriptif', 'commentaire'])) {
                $nom = strip_tags($_POST['nom']);
                $descriptif = strip_tags($_POST['descriptif']);
                $commentaire = strip_tags($_POST['commentaire']);
                $photo = $_FILES['photo']['name'] ?? $habitat['photo'];

                $habitatsModel->setNom($nom)
                    ->setDescriptif($descriptif)
                    ->setCommentaire($commentaire)
                    ->setPhoto($photo);
                $habitatsModel->update($id);

                $_SESSION['message'] = 'L\'habitat a été modifié avec succès';
                header('Location: /admin/dashboard');
                exit;
            }

            $form = new Form();
            $form->debutForm('POST', '/habitats/modifier/' . $habitat['id'], ['enctype' => 'multipart/form-data'])
                ->ajoutLabelFor('nom', 'Nom de l\'habitat:')
                ->ajoutInput('text', 'nom', [
                    'id' => 'nom',
                    'class' => 'form-control',
                    'value' => $habitat['nom']
                ])
                ->ajoutLabelFor('descriptif', 'Descriptif de l\'habitat:')
                ->ajoutTextarea('descriptif', $habitat['descriptif'], [
                    'id' => 'descriptif',
                    'class' => 'form-control'
                ])
                ->ajoutLabelFor('commentaire', 'Commentaire:')
                ->ajoutTextarea('commentaire', $habitat['commentaire'], [
                    'id' => 'commentaire',
                    'class' => 'form-control'
                ])
                ->ajoutLabelFor('photo', 'Photo de l\'habitat:')
                ->ajoutInput('file', 'photo', [
                    'id' => 'photo',
                    'class' => 'form-control'
                ])
                ->ajoutBouton('Modifier', ['class' => 'btn btn-primary'])
                ->finForm();

            $this->render('habitats/modifier', ['form' => $form->create(), 'habitat' => $habitat]);
        } else {
            $_SESSION['erreur'] = 'Vous devez être connecté pour accéder à cette page';
            header('Location: /users/login');
            exit;
        }
    }


    public function supprimer()
    {
        if (isset($_SESSION['users']) && !empty($_SESSION['users']['role']) && $_SESSION['users']['role'] === 1) {
            if (isset($_POST['id'])) {
                $habitatsModel = new HabitatsModel();
                $habitatsModel->delete($_POST['id']);
                $_SESSION['message'] = "L'habitat a été supprimé avec succès";
            }
            header('Location:/admin/dashboard');
            exit;
        } else {
            $_SESSION['erreur'] = 'Vous devez être connecté pour accéder à cette page';
            header('Location: /users/login');
            exit;
        }
    }
}
