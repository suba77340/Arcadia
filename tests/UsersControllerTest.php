<?php

use PHPUnit\Framework\TestCase;
use Dotenv\Dotenv;

class UsersControllerTest extends TestCase
{
    protected $pdo;

    protected function setUp(): void
    {
        echo "Début de la méthode setUp\n";
        try {
            $dotenv = Dotenv::createImmutable(__DIR__);
            $dotenv->load();
            echo "Variables d'environnement chargées\n";
    
            $this->pdo = new PDO(
                'mysql:host=' . $_ENV['DB_HOST'] . ';dbname=' . $_ENV['DB_DATABASE'], 
                $_ENV['DB_USERNAME'], 
                $_ENV['DB_PASSWORD']
            );
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            echo "Connexion à la base de données réussie\n";
        } catch (PDOException $e) {
            echo "Échec de la connexion : " . $e->getMessage() . "\n";
            $this->fail("Échec de la connexion à la base de données : " . $e->getMessage());
        }
        echo "Fin de la méthode setUp\n";
    }
    
    protected function tearDown(): void
    {
        $this->pdo = null;
        echo "Connexion PDO réinitialisée\n";
    }

    public function testLoginSuccess()
    {
        echo "Début du test testLoginSuccess\n";
    
        // Simuler un POST avec un email et un mot de passe valides
        $_POST['email'] = 'alice@example.com';
        $_POST['password'] = 'Alicepass';
    
        // Créer une instance du contrôleur UsersController
        $controller = new \App\Controllers\UsersController();
        
        // Commence à capturer la sortie
        ob_start();
        header_remove();  // Supprimer les en-têtes existants
    
        // Appel à la méthode de login
        $controller->login();
    
        // Récupère toute la sortie capturée
        $output = ob_get_clean();
    
        // Vérification des en-têtes de redirection
        $headers = headers_list();
        var_dump($headers);  // Affiche les en-têtes de redirection pour voir où l'utilisateur est envoyé
    
        // Vous pouvez vérifier si l'utilisateur est redirigé vers le bon dashboard
        $this->assertContains('Location: /admin/dashboard', $headers);  // Exemple si vous vous attendez à une redirection vers le tableau de bord admin
    
        // Vérification de la session utilisateur
        session_start();  // Démarre la session pour accéder aux variables
        $this->assertNotEmpty($_SESSION);  // Vérifie que la session n'est pas vide
        $this->assertEquals('alice@example.com', $_SESSION['email']);  // Vérifie que l'email est bien enregistré en session
    }
    
    
    
}
