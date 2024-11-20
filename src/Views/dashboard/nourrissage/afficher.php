<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Information Nourriture</title>
    <link rel="stylesheet" href="/path/to/your/css/styles.css">
</head>

<body>
    <div class="container">
        <h1>Information Nourriture</h1>

        <?php if (isset($_SESSION['erreur'])): ?>
            <div class="alert alert-danger">
                <?= $_SESSION['erreur'] ?>
            </div>
            <?php unset($_SESSION['erreur']); ?>
        <?php endif; ?>

        <p>ID de l'Animal: <?= htmlspecialchars($nourrissage->id_animal, ENT_QUOTES, 'UTF-8') ?></p>
        <p>Type de Nourriture: <?= htmlspecialchars($nourrissage->type_nourriture, ENT_QUOTES, 'UTF-8') ?></p>
        <p>Quantité: <?= htmlspecialchars($nourrissage->quantite, ENT_QUOTES, 'UTF-8') ?></p>
        <p>Date du Repas: <?= htmlspecialchars($nourrissage->date_repas, ENT_QUOTES, 'UTF-8') ?></p>
        <p>Heure du Repas: <?= htmlspecialchars($nourrissage->heure_repas, ENT_QUOTES, 'UTF-8') ?></p>
    </div>
</body>

</html>