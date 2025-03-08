<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use App\Controllers\AnimauxController;
use App\Models\AnimauxModel;

class AnimauxControllerTest extends TestCase
{
    protected $animauxController;
    protected $animauxModelMock;

    protected function setUp(): void
    {
        // Créer un mock pour le modèle AnimauxModel
        $this->animauxModelMock = $this->createMock(AnimauxModel::class);

        // Créer l'instance du contrôleur AnimauxController
        $this->animauxController = new AnimauxController();

        // On injecte le mock dans le contrôleur (comme nous l'avons fait dans UsersController)
        $this->animauxController->animauxModel = $this->animauxModelMock;
    }

    public function testIndex()
    {
        // Simuler la réponse du modèle avec une liste d'animaux
        $this->animauxModelMock->method('findAll')
             ->willReturn([
                 ['id' => 1, 'nom' => 'Chien'],
                 ['id' => 2, 'nom' => 'Chat'],
             ]);

        // Exécuter la méthode index()
        $this->animauxController->index();

        // Vous pouvez vérifier ici si la vue est bien rendue avec les animaux
        // Par exemple, en vous assurant que la méthode render a été appelée correctement.
        // Pour tester cela, vous pouvez utiliser un Mock de la méthode render si nécessaire.
    }

    public function testLireAnimalTrouve()
    {
        // Simuler la réponse du modèle avec un animal trouvé
        $this->animauxModelMock->method('find')
             ->willReturn([
                 'id' => 1,
                 'nom' => 'Chien',
             ]);

        // Exécuter la méthode lire() avec l'ID 1
        $this->animauxController->lire(1);

        // Vérifier que la vue est rendue avec les données de l'animal
        // Assurez-vous que la méthode render est appelée avec les bons paramètres
    }

    public function testLireAnimalNonTrouve()
    {
        // Simuler la réponse du modèle avec un animal non trouvé
        $this->animauxModelMock->method('find')
             ->willReturn(null);

        // Exécuter la méthode lire() avec un ID invalide
        $this->animauxController->lire(999); // ID inexistant

        // Vérifier que le message "Animal non trouvé" est affiché
        // Vous pouvez capturer la sortie avec ob_start() et ob_get_contents()
        ob_start();
        $this->animauxController->lire(999);
        $output = ob_get_clean();

        // Vérifier que le message attendu est dans la sortie
        $this->assertStringContainsString('Animal non trouvé', $output);
    }
}
