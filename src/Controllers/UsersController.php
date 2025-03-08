<?php

namespace App\Controllers;

use App\Config\Form;
use App\Models\UsersModel;

class UsersController extends Controller
{
    // Connexion utilisateur
    public function login()
    {
        // Validation des champs du formulaire
        if (Form::validate($_POST, ['email', 'password'])) {
            // Validation de l'email
            $email = filter_var(strip_tags($_POST['email']), FILTER_SANITIZE_EMAIL);
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $_SESSION['erreur'] = "L'adresse email n'est pas valide.";
                header('Location:/users/login');
                exit;
            }

            // Nettoyage du mot de passe
            $password = strip_tags($_POST['password']);

            $usersModel = new UsersModel;
            $userArray = $usersModel->findOneByEmail($email);

            // Vérification de l'existence de l'utilisateur
            if (!$userArray) {
                $_SESSION['erreur'] = 'L\'adresse email et/ou le mot de passe sont incorrects.';
                header('Location:/users/login');
                exit;
            }

            // Hydratation de l'utilisateur
            $user = $usersModel->hydrate($userArray);

            // Vérification du mot de passe
            if (password_verify($password, $user->getPassword())) {
                $user->setSession();  // Mettre l'utilisateur en session

                // Redirection selon le rôle
                switch ($user->getId_Role()) {
                    case 1:
                        header('Location:/admin/dashboard');
                        break;
                    case 2:
                        header('Location:/employe/dashboard');
                        break;
                    case 3:
                        header('Location:/veterinaire/dashboard');
                        break;
                    default:
                        $_SESSION['erreur'] = 'Rôle inconnu';
                        header('Location:/users/login');
                        break;
                }
                exit;
            } else {
                $_SESSION['erreur'] = 'L\'adresse email et/ou le mot de passe sont incorrects.';
                header('Location:/users/login');
                exit;
            }
        }

        // Création du formulaire de connexion
        $form = new Form;
        $form->debutForm()
            ->ajoutLabelFor('email', 'Email:')
            ->ajoutInput('email', 'email', ['class' => 'form-control', 'id' => 'email'])
            ->ajoutLabelFor('pass', 'Mot de passe:')
            ->ajoutInput('password', 'password', ['class' => 'form-control', 'id' => 'pass'])
            ->ajoutBouton('Me connecter', ['class' => 'btn btn-primary'])
            ->finForm();

        // Rendu du formulaire
        $this->render('users/login', ['loginForm' => $form->create()]);
    }


    // Inscription des utilisateurs
    public function register()
    {
        if (Form::validate($_POST, ['email', 'password', 'nom', 'prenom'])) {
            // Validation de l'email
            $email = filter_var(strip_tags($_POST['email']), FILTER_SANITIZE_EMAIL);
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $_SESSION['erreur'] = "L'adresse email n'est pas valide.";
                header('Location:/users/register');
                exit;
            }

            // Nettoyage du mot de passe
            $password = strip_tags($_POST['password']);
            if (strlen($password) < 8) {
                $_SESSION['erreur'] = "Le mot de passe doit comporter au moins 8 caractères.";
                header('Location:/users/register');
                exit;
            }
            $password = password_hash($password, PASSWORD_ARGON2I);

            // Nettoyage du prénom et du nom
            $nom = htmlspecialchars(strip_tags($_POST['nom']));
            $prenom = htmlspecialchars(strip_tags($_POST['prenom']));

            // Création de l'utilisateur
            $user = new UsersModel;
            $user->setEmail($email)
                ->setPassword($password)
                ->setNom($nom)
                ->setPrenom($prenom);
            $user->create();

            // Rediriger vers la page de connexion
            header('Location:/users/login');
            exit;
        }

        $form = new Form;
        $form->debutForm()
            ->ajoutLabelFor('prenom', 'Prénom:')
            ->ajoutInput('prenom', 'prenom', ['class' => 'form-control', 'id' => 'prenom'])
            ->ajoutLabelFor('nom', 'Nom:')
            ->ajoutInput('nom', 'nom', ['class' => 'form-control', 'id' => 'nom'])
            ->ajoutLabelFor('email', 'Email:')
            ->ajoutInput('email', 'email', ['class' => 'form-control', 'id' => 'email'])
            ->ajoutLabelFor('pass', 'Mot de passe:')
            ->ajoutInput('password', 'password', ['class' => 'form-control', 'id' => 'pass'])
            ->ajoutBouton('Créer un compte', ['class' => 'btn btn-primary'])
            ->finForm();

        $this->render('users/register', ['registerForm' => $form->create()]);
    }

    // Déconnexion
    public function logout()
    {
        unset($_SESSION['users']);
        // Ajouter un message de déconnexion
        $_SESSION['flash_message'] = 'Vous êtes déconnecté.';

        header('Location:/users/login');
        exit;
    }
}
