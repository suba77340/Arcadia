<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Dashboard Vétérinaire</title>
    <link rel="stylesheet" href="/public/Assets/css/index.css">
</head>

<body>
    <div class="container mt-4">
        <h1 class="title">Dashboard vétérinaire</h1>

        <h2>Liste des Animaux</h2>
        <?php if (!empty($animaux)): ?>
            <ul class="list-group mb-4">
                <?php foreach ($animaux as $animal): ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <?= htmlspecialchars($animal['id']) ?> - <?= htmlspecialchars($animal['nom']) ?> : <?= htmlspecialchars($animal['etat']) ?>
                        <a href="/veterinaire/ajouterRapport/<?= htmlspecialchars($animal['id']) ?>" class="btn btn-primary btn-sm">Ajouter Rapport</a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p class="text-warning">Aucun animal trouvé.</p>
        <?php endif; ?>

        <h2>Les Rapports Vétérinaires</h2>
        <?php if (!empty($rapports)): ?>
            <ul class="list-group mb-4">
                <?php foreach ($rapports as $rapport): ?>
                    <li class="list-group-item">
                        <p>Rapport pour l'Animal ID: <?= htmlspecialchars($rapport->id_animal) ?></p>
                        <p>Date: <?= htmlspecialchars($rapport->la_date) ?></p>
                        <p>Rapport: <?= nl2br(htmlspecialchars($rapport->rapport)) ?></p>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p class="text-warning">Aucun rapport trouvé.</p>
        <?php endif; ?>

        <h2>Les Habitats</h2>
        <?php if (!empty($habitats)): ?>
            <ul class="list-group mb-4">
                <?php foreach ($habitats as $habitat): ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <h5><?= htmlspecialchars($habitat['nom']) ?></h5>
                            <p>Commentaire: <?= htmlspecialchars($habitat['commentaire']) ?></p>
                        </div>
                        <a href="/veterinaire/ajouterAvisHabitats/<?= htmlspecialchars($habitat['id']) ?>" class="btn btn-primary btn-sm">Ajouter un commentaire</a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p class="text-warning">Aucun habitat trouvé.</p>
        <?php endif; ?>

        <h2>Nourrissage quotidien des animaux</h2>
        <?php if (!empty($nourrissages)): ?>
            <ul class="list-group mb-4">
                <?php foreach ($nourrissages as $nourrissage): ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <?= htmlspecialchars($nourrissage['id_animal'], ENT_QUOTES, 'UTF-8') ?> - <?= htmlspecialchars($nourrissage['type_nourriture'], ENT_QUOTES, 'UTF-8') ?> - <?= htmlspecialchars($nourrissage['quantite'], ENT_QUOTES, 'UTF-8') ?> - <?= htmlspecialchars($nourrissage['date_repas'], ENT_QUOTES, 'UTF-8') ?> - <?= htmlspecialchars($nourrissage['heure_repas'], ENT_QUOTES, 'UTF-8') ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p class="text-warning">Aucun nourrissage trouvé.</p>
        <?php endif; ?>
    </div>
</body>

</html>