<?php

namespace App\Controllers;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use App\Models\ContactModel;
use Dotenv\Dotenv;

class ContactController extends Controller
{
    private $contactModel;

    public function __construct()
    {
    // Vérifie si tu n'es pas en environnement de production (Heroku)
    if ($_SERVER['APP_ENV'] !== 'production') {
        // Charger les variables d'environnement à partir du fichier .env local (en dehors de Heroku)
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../');
        $dotenv->load();
    }

        $this->contactModel = new ContactModel();
    }

    public function index(): void
    {
        $contacts = $this->contactModel->findAllContact();
        if (!is_array($contacts)) {
            $contacts = [];
        }
        $this->render('contact/index', ['contacts' => $contacts]);
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
        }
    }

    private function envoyerEmail($titre, $description, $email)
    {
        $mail = new PHPMailer(true);


        try {
            $mail->isSMTP();
            $mail->Host = $_ENV['SMTP_HOST'];
            $mail->SMTPAuth = true;
            $mail->Username = $_ENV['SMTP_USERNAME'];
            $mail->Password = $_ENV['SMTP_PASSWORD'];
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom('arcadiazoo36110@gmail.com', 'Contact');
            $mail->addAddress('arcadiazoo36110@gmail.com', 'Paul');

            $mail->isHTML(true);
            $mail->Subject = 'Nouveau message de contact : ' . $titre;
            $mail->Body    = "Vous avez reçu un nouveau message de contact.<br><br><strong>Titre :</strong> $titre<br><strong>Description :</strong> $description<br><strong>Email du client :</strong> $email";

            $mail->send();
            return true;
        } catch (Exception $e) {
        }
    }
}
