<?php

namespace App\Controllers;

use App\Config\Form;
use App\Models\UsersModel;

class UsersController extends Controller
{   // connexion utilisateur
    public function login()
    {
        if (Form::validate($_POST, ['email', 'password'])) {
            $usersModel = new UsersModel;
            $userArray = $usersModel->findOneByEmail(strip_tags($_POST['email']));
            if (!$userArray) {
                $_SESSION['erreur'] = 'L\'adresse email et / le MDP est incorrect';
                header('Location:/users/login');
                exit;
            }
            $user = $usersModel->hydrate($userArray);
            if (password_verify($_POST['password'], $user->getPassword())) {
                $user->setSession();
                // Redirige l'utilisateur vers son tableau de bord respectif
                if ($user->getId_Role() === 1) {
                    header('Location:/admin/dashboard');
                } elseif ($user->getId_Role() === 3) {
                    header('Location:/veterinaire/dashboard');
                } elseif($user->getId_Role() === 2) {
                    header('Location:/employe/dashboard');
                    }else{
                        header('Location:/users/login');
                    }
                exit;
            } else {
                $_SESSION['erreur'] = 'L\'adresse email et / le MDP est incorrect';
                header('Location:/users/login');
                exit;
            }
        }   
        $form = new Form;
        $form->debutForm()
            ->ajoutLabelFor('email', 'Email:')
            ->ajoutInput('email', 'email', ['class' => 'form-control', 'id' => 'email'])
            ->ajoutLabelFor('pass', 'Mot de passe:')
            ->ajoutInput('password', 'password', ['class' => 'form-control', 'id' => 'pass'])
            ->ajoutBouton('Me connecter', ['class' => 'btn btn-primary'])
            ->finForm();
        $this->render('users/login', ['loginForm' => $form->create()]);
    }
       // inscription des utilisateurs ()
    public function register()
    { // verifie si formulaire est valide
        if (Form::validate($_POST, ['email', 'password', 'nom', 'prenom'])) {
            // formulaire est valide
            // on nettoie adresse mail, nom et prenom
            $email = strip_tags($_POST['email']);
            $nom = strip_tags($_POST['nom']);
            $prenom = strip_tags($_POST['prenom']);
            // chiffre mdp
            $password = password_hash($_POST['password'], PASSWORD_ARGON2I);
            //hydrate utilisateur en BDD
            $user = new UsersModel;
            $user->setEmail($email)
                ->setPassword($password)
                ->setNom($nom)
                ->setPrenom($prenom);
            // on stocke l'utilisateur 
            $user->create();
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
    public function logout()
    {
        unset($_SESSION['users']);
        // Ajouter un message de déconnexion
        $_SESSION['flash_message'] = 'Vous êtes déconnecté.';
        
        header('Location:/users/login');
        exit;
    }
}
