<?php

namespace App\Controllers;

use App\Config\Form;
use App\Models\AnimauxModel;

class AnimauxController extends Controller
{
    // methode affichant page de tt les animaux de la BDD
    public function index(): void
    {
        // instancie modele table animaux
        $animauxModel = new AnimauxModel;
        //cherche tt les animaux
        $animaux = $animauxModel->findAll();
        if (!is_array($animaux)) {
            $animaux = [];
        }
        //genere la vue
        $this->render('animaux/index', ['animaux' => $animaux]);
    } //affiche animal via ID
    public function lire(int $id): void
    {
        $animauxModel = new AnimauxModel;
        $animal = $animauxModel->find($id);
        if ($animal) {
            $animauxModel->setId($id);
            $animauxModel->setNom($animal['nom']);
            $animauxModel->logConsultation();
            $animauxModel->Compteur($id);
            $this->render('animaux/lire', ['animal' => $animal]);
        } else {
            echo "Animal non trouvé.";
        }
    }
    // ajouter animal
    public function ajouter()
    {
        if (isset($_SESSION['users']) && !empty($_SESSION['users']['id'])) {
            if (Form::validate($_POST, ['nom', 'etat', 'race', 'id_habitats'])) {
                $nom = strip_tags($_POST['nom']);
                $etat = strip_tags($_POST['etat']);
                $race = strip_tags($_POST['race']);
                $id_habitats = strip_tags($_POST['id_habitats']);
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

                    if ($filesize > 2 * 1024 * 1024) {
                        die("Erreur: problème avec le fichier téléchargé");
                    }

                    $image_info = getimagesize($_FILES["image"]["tmp_name"]);
                    if ($image_info === false) {
                        die("Erreur: le fichier n'est pas une image valide");
                    }
                    $newname = uniqid();
                    $newfilename = __DIR__ . "/../../public/uploads/" . $newname . "." . $extension;

                    if (!move_uploaded_file($_FILES["image"]["tmp_name"], $newfilename)) {
                        die("Erreur: l'upload a échoué");
                    }

                    chmod($newfilename, 0644);  // Interdire l'exécution du fichier
                    $image = "$newname.$extension";
                }

                $animal = new AnimauxModel();
                $animal->setNom($nom)
                    ->setEtat($etat)
                    ->setRace($race)
                    ->setImage($image)
                    ->setId_Habitats($id_habitats)
                    ->create();

                $_SESSION['message'] = "Votre animal a été enregistré avec succès";
                header('Location: /animaux');
                exit;
            } else {
                // Formulaire
                $form = new Form();
                $form->debutForm('POST', '/animaux/ajouter', ['enctype' => 'multipart/form-data'])
                    ->ajoutLabelFor('nom', 'Nom de l\'animal:')
                    ->ajoutInput('text', 'nom', [
                        'id' => 'nom',
                        'class' => 'form-control'
                    ])
                    ->ajoutLabelFor('etat', 'État de l\'animal:')
                    ->ajoutInput('text', 'etat', [
                        'id' => 'etat',
                        'class' => 'form-control'
                    ])
                    ->ajoutLabelFor('race', 'Race de l\'animal:')
                    ->ajoutInput('text', 'race', [
                        'id' => 'race',
                        'class' => 'form-control'
                    ])
                    ->ajoutLabelFor('image', 'Image de l\'animal:')
                    ->ajoutInput('file', 'image', [
                        'id' => 'image',
                        'class' => 'form-control'
                    ])
                    ->ajoutLabelFor('id_habitats', 'ID de l\'habitat:')
                    ->ajoutInput('text', 'id_habitats', [
                        'id' => 'id_habitats',
                        'class' => 'form-control'
                    ])
                    ->ajoutBouton('Ajouter', ['class' => 'btn btn-primary'])
                    ->finForm();

                $this->render('animaux/ajouter', ['form' => $form->create()]);
            }
        } else {

            $_SESSION['erreur'] = 'Vous devez etre connecté pour acceder à cette page';
            header('Location: /users/login');
            exit;
        }
    }

    public function modifier(int $id)
    {
        if (isset($_SESSION['users']) && !empty($_SESSION['users']['id'])) {
            // verifie si annonce existe dans la BDD
            // instancie le modele
            $animauxModel = new AnimauxModel;
            $animal = $animauxModel->find($id);
            //si animal existe pas on retourne a la liste des animaux
            if (!$animal) {
                http_response_code(404);
                $_SESSION['erreur'] = "L'animal recherché n'existe pas";
                header('Location: /animaux');
                exit;
            }

            // on traite le formulaire
            if (form::validate($_POST, ['nom', 'etat', 'race'])) {
                // on se protege contre les failles XXS
                $nom = strip_tags($_POST['nom']);
                $etat = strip_tags($_POST['etat']);
                $race = strip_tags($_POST['race']);
                $image = $_FILES['image']['name'] ?? '';
                // on stocke l'annonce animal
                $animalModif = new AnimauxModel;
                // on hydrate
                $animalModif->setId($animal['id'])
                    ->setNom($nom)
                    ->setRace($race)
                    ->setEtat($etat)
                    ->setImage($image);
                //on met à jour annonce animal
                $animalModif->update($id);
                // on redigirige
                $_SESSION['message'] = 'Votre animal a été modifié avec succès';
                header('Location: /');
                exit;
            }

            $form = new Form;
            // formulaire d'ajout
            $form->debutForm('POST', '/animaux/modifier/' . $animal['id'], ['enctype' => 'multipart/form-data'])
                ->ajoutLabelFor('nom', 'Nom de l\'animal:')
                ->ajoutInput('text', 'nom', [
                    'id' => 'nom',
                    'class' => 'form-control',
                    'value' => $animal['nom']
                ])
                ->ajoutLabelFor('etat', 'Etat de l\'animal:')
                ->ajoutInput('text', 'etat', [
                    'id' => 'etat',
                    'class' => 'form-control',
                    'value' => $animal['etat']
                ])
                ->ajoutLabelFor('race', 'Race de l\'animal:')
                ->ajoutInput('text', 'race', [
                    'id' => 'race',
                    'class' => 'form-control',
                    'value' => $animal['race']
                ])
                ->ajoutLabelFor('image', 'Image de l\'animal:')
                ->ajoutInput('file', 'image', [
                    'id' => 'image',
                    'class' => 'form-control'
                ])
                ->ajoutBouton('Modifier', ['class' => 'btn btn-primary'])
                ->finForm();
            // envoie à la vue
            $this->render('animaux/modifier', ['form' => $form->create()]);
        } else { // utilisateur n'est pas connecté
            $_SESSION['erreur'] = 'Vous devez etre connecté pour acceder à cette page';
            header('Location: /users/login');
            exit;
        }
    }
}
