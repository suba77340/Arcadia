<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use App\Controllers\UsersController;
use App\Config\Form;
use App\Models\UsersModel;

class UsersControllerTest extends TestCase
{
    public function testLoginPageRendersCorrectly()
    {
        // Préparer les données attendues
        $expectedHtml = '<form action="#" method="POST"><label for="email">Email:</label><input type="email" name="email" class="form-control" id="email"><label for="pass">Mot de passe:</label><input type="password" name="password" class="form-control" id="pass"><button class="btn btn-primary">Me connecter</button></form>';
        
        // Récupérer le formulaire généré par le contrôleur
        $actualHtml = $this->getActualHtml(); // Remplace cette méthode par celle qui récupère réellement le HTML généré par ton contrôleur
        
        // Remplacer les guillemets simples par doubles pour comparer les deux chaînes
        $expectedHtml = str_replace("'", '"', $expectedHtml);
        $actualHtml = str_replace("'", '"', $actualHtml);
    
        // Comparer les deux chaînes
        $this->assertEquals($expectedHtml, $actualHtml);
    }
    
    
}