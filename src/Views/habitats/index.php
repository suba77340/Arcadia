<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Galerie des Animaux</title>
    <link rel="stylesheet" href="styles.css">
</head>

<h1 class="title">Nos Habitats</h1>
<div class="habitat-container">
    <?php if (!empty($habitats)): ?>
        <?php foreach ($habitats as $habitat): ?>
            <div class="habitat-item">
                <div class="habitat-image">
                    <img src="/<?= htmlspecialchars($habitat['photo'], ENT_QUOTES, 'UTF-8') ?>" alt="Photo de <?= htmlspecialchars($habitat['nom'], ENT_QUOTES, 'UTF-8') ?>">
                </div>
                <div class="habitat-text">
                    <a href="/habitats/afficherAnimaux/<?= htmlspecialchars($habitat['id']) ?>" class="habitat-link">
                        <?= htmlspecialchars($habitat['nom']) ?>
                        <p><?= nl2br(htmlspecialchars($habitat['descriptif'], ENT_QUOTES, 'UTF-8')) ?></p>
                    </a>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>