<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Détails du Service</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <h1 class="title"> <?= htmlspecialchars($service['nom']) ?></h1>
    <p class="description"> <?= htmlspecialchars($service['descriptif']) ?></p>
    <?php if (!empty($service['image'])): ?>
        <div class="image-container">
            <img src="/uploads/<?= htmlspecialchars($service['image']) ?>" alt="Photo du service" class="services-image">
        </div>
    <?php endif; ?>
    <div class="link-container">
        <a href="/services" class="back-link">Retour à la liste des services</a>
    </div>
</body>

</html>
