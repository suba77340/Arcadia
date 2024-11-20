<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Détails du Service</title>
</head>

<body>
    <h1> <?= htmlspecialchars($service['nom']) ?></h1>
    <p> <?= htmlspecialchars($service['descriptif']) ?></p>
    <?php if (!empty($service['image'])): ?>
        <p> <img src="/uploads/<?= htmlspecialchars($service['image']) ?>" alt="Photo du service"></p>
    <?php endif; ?>
    <a href="/services">Retour à la liste des services</a>
</body>

</html>