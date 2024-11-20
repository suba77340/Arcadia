<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Les animaux de la <?= htmlspecialchars($id == 1 ? 'Savane' : ($id == 2 ? 'Jungle' : ($id == 3 ? 'Marais' : 'Habitat Inconnu'))) ?></title>
</head>

<body>
    <h1 class="title">Les Animaux de la <?= htmlspecialchars($id == 1 ? 'Savane' : ($id == 2 ? 'Jungle' : ($id == 3 ? 'Marais' : 'Habitat Inconnu'))) ?></h1>
    <div class="cards-container">
        <?php if (!empty($animaux)): ?>
            <?php foreach ($animaux as $animal): ?>
                <div class="cards-body">
                    <h2><a href="/animaux/lire/<?= htmlspecialchars($animal['id']) ?>"><?= htmlspecialchars($animal['nom']) ?></a></h2>
                    <div class="cards">
                        <img src="/uploads/<?= htmlspecialchars($animal['image']) ?>" alt="Photo de <?= htmlspecialchars($animal['nom']) ?>">
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Aucun animal trouvé dans cet habitat.</p>
        <?php endif; ?>
    </div>
    <a href="/habitats" class="back-link">Retour à la liste des habitats</a>
</body>

</html>