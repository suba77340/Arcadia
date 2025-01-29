<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Dashboard Employé</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container mt-4">
        <h1 class="title">Dashboard employé</h1>

        <h2>Liste des Animaux</h2>
        <?php if (!empty($animaux)): ?>
            <ul class="list-group mb-4">
                <?php foreach ($animaux as $animal): ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <?= htmlspecialchars($animal['id']) ?> - <?= htmlspecialchars($animal['nom']) ?>
                        <a href="/employe/ajouterNourriture/<?= htmlspecialchars($animal['id']) ?>" class="btn btn-primary btn-sm">Ajouter Nourriture</a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p class="text-warning">Aucun animal trouvé.</p>
        <?php endif; ?>

        <h2>Liste des Nourrissages</h2>
        <?php if (!empty($nourrissages)): ?>
            <ul class="list-group mb-4">
                <?php foreach ($nourrissages as $nourrissage): ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <?= htmlspecialchars($nourrissage['id_animal'], ENT_QUOTES, 'UTF-8') ?> - <?= htmlspecialchars($nourrissage['type_nourriture'], ENT_QUOTES, 'UTF-8') ?> - <?= htmlspecialchars($nourrissage['quantite'], ENT_QUOTES, 'UTF-8') ?> - <?= htmlspecialchars($nourrissage['date_repas'], ENT_QUOTES, 'UTF-8') ?> - <?= htmlspecialchars($nourrissage['heure_repas'], ENT_QUOTES, 'UTF-8') ?>
                        <form action="/dashboard/employe/supprimerNourriture/<?= htmlspecialchars($nourrissage['id']) ?>" method="POST" style="display:inline;">
                            <button type="submit" class="btn btn-danger btn-sm">Supprimer</button>
                        </form>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p class="text-warning">Aucun nourrissage trouvé.</p>
        <?php endif; ?>

        <h2>Liste des Services</h2>
        <?php if (!empty($services)): ?>
            <ul class="list-group mb-4">
                <?php foreach ($services as $service): ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <?= htmlspecialchars($service['nom']) ?> : <?= htmlspecialchars($service['descriptif']) ?>
                        <a href="/services/modifier/<?= htmlspecialchars($service['id']) ?>" class="btn btn-primary btn-sm">Modifier</a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p class="text-warning">Aucun service trouvé.</p>
        <?php endif; ?>

        <h2>Liste des Avis Non Validés</h2>
        <?php if (!empty($avisNonValidés)): ?>
            <ul class="list-group mb-4">
                <?php foreach ($avisNonValidés as $avis): ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <p><strong>Pseudo:</strong> <?= htmlspecialchars($avis['pseudo']) ?></p>
                            <p><strong>Commentaire:</strong> <?= htmlspecialchars($avis['commentaire']) ?></p>
                        </div>
                        <a href="/avis/validerAvis/<?= htmlspecialchars($avis['id']) ?>" class="btn btn-success btn-sm">Valider</a>
                        <form action="/avis/supprimerAvis/<?= htmlspecialchars($avis['id']) ?>" method="POST" style="display:inline;">
                            <button type="submit" class="btn btn-danger btn-sm">Supprimer</button>
                        </form>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p class="text">Aucun avis non validé.</p>
        <?php endif; ?>
    </div>
</body>

</html>