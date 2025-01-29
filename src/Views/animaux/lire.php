<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Informations de l'Animal</title>
</head>

<body>
    <h1 class="title">Informations de l'Animal</h1>
    <div class="container">
        <div class="details">
            <p>Nom: <?= htmlspecialchars($animal['nom']) ?></p>
            <p>Race: <?= htmlspecialchars($animal['race']) ?></p>
            <p>État: <?= htmlspecialchars($animal['etat']) ?></p>
        </div>
        <div class="image-container">
            <img src="/uploads/<?= htmlspecialchars($animal['image']) ?>" alt="Photo de l'animal">
        </div>
    </div>
    <div class="link-container">
        <a href="/animaux" class="back-link">Galerie des Animaux</a>
    </div>
</body>

</html>