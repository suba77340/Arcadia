<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Galerie des Animaux</title>
    <link rel="stylesheet" href="styles.css">
</head>

<div class="service-container">
    <h1 class="title">Nos Services</h1>
    <?php if (isset($services) && !empty($services)): ?>
        <?php foreach ($services as $service): ?>
            <section class="service-item">
                <div class="service-content">
                    <div class="service-text">
                        <p><?= nl2br(htmlspecialchars($service['descriptif'], ENT_QUOTES, 'UTF-8')) ?></p>
                        <h2><a href="/services/lire/<?= $service['id'] ?>"></a></h2>
                    </div>
                    <?php if ($service['image']): ?>
                        <div class="service-image">
                            <img src="/uploads/<?= htmlspecialchars($service['image'], ENT_QUOTES, 'UTF-8') ?>" alt="<?= htmlspecialchars($service['nom'], ENT_QUOTES, 'UTF-8') ?>">
                        </div>
                    <?php endif; ?>
                </div>
            </section>
        <?php endforeach; ?>
    <?php else: ?>
        <p>Aucun service trouvé.</p>
    <?php endif; ?>
</div>