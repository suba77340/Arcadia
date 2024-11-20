<?php

namespace App\Controllers;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use App\Models\ContactModel; 

class ContactController
{
    private $contactModel;

    public function __construct()
    {
        $this->contactModel = new ContactModel();
    }

    public function index()
    {
        // voir le formulaire de contact
        require_once ROOT . '/src/Views/contact/index.php';
    }

    public function envoyer()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $titre = $_POST['titre'];
            $description = $_POST['description'];
            $email = $_POST['email'];

            // Créer un nouveau contact dans MongoDB
            $this->contactModel->createContact($titre, $description, $email);

            // Envoi de l'email
            $this->envoyerEmail($titre, $description, $email);

            echo "Merci pour votre message ! Nous vous répondrons dès que possible.";
        } else {
            echo "Méthode de requête non valide.";
        }
    }

    private function envoyerEmail($titre, $description, $email)
    {
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host = getenv('SMTP_HOST');
            $mail->SMTPAuth = true;
            $mail->Username = getenv('SMTP_USERNAME');
            $mail->Password = getenv('SMTP_PASSWORD');
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom('arcadiazoo36110@gmail.com', 'Contact');
            $mail->addAddress('arcadiazoo36110@gmail.com', 'Paul');
            $mail->Subject = 'Nouveau message de contact : ' . $titre;
            $mail->Body    = "Vous avez reçu un nouveau message de contact.\n\nTitre : $titre\nDescription : $description\nEmail du client : $email";

            $mail->send();
            echo 'Email envoyé avec succès !';
        } catch (Exception $e) {
            echo "L'envoi de l'email a échoué : Erreur SMTP : {$mail->ErrorInfo}";
        }
    }
}
