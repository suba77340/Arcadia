<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Galerie des Animaux</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <h1 class="title">Galerie des Animaux</h1>
    <div class="gallery-grid">
        <?php foreach ($animaux as $animal): ?>
            <div class="gallery-item">
                <img src="/uploads/<?= htmlspecialchars($animal['image']) ?>" class="gallery-image" alt="Photo de <?= htmlspecialchars($animal['nom']) ?>">
                <div class="gallery-caption"><?= htmlspecialchars($animal['nom']) ?></div>
            </div>
        <?php endforeach; ?>
    </div>
    <a href="/habitats" class="back-link">Retour à la liste des habitats</a>
</body>

</html>