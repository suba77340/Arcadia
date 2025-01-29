<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Tableau de Bord Admin du Zoo</title>
</head>

<body>
    <div class="container mt-4">
        <h1 class="title">Dashboard administrateur</h1>

        <h2>Liste des Animaux</h2>
        <?php if (!empty($animaux)): ?>
            <ul class="list-group mb-4">
                <?php foreach ($animaux as $animal): ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                    <?= htmlspecialchars($animal['id']) ?>:<?= htmlspecialchars($animal['nom']) ?> : <?= htmlspecialchars($animal['etat']) ?> | ( Vue : <?= htmlspecialchars($animal['compteur']) ?>)
                        <div>
                            <a href="/admin/modifier/<?= $animal['id']; ?>" class="btn btn-primary btn-sm">Modifier</a>
                            <form method="POST" action="/admin/supprimer" style="display:inline;">
                                <input type="hidden" name="id" value="<?= $animal['id']; ?>">
                                <button type="submit" class="btn btn-danger btn-sm">Supprimer</button>
                            </form>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p class="text-warning">Aucun animal trouvé.</p>
        <?php endif; ?>
        <div class="button-container">
            <a href="/animaux/ajouter" class="btn btn-primary btn-md">Ajouter un animal</a>
        </div>

        <h2>Liste des Services</h2>
        <?php if (!empty($services)): ?>
            <ul class="list-group mb-4">
                <?php foreach ($services as $service): ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <?= htmlspecialchars($service['nom']) ?> : <?= htmlspecialchars($service['descriptif']) ?>
                        <div>
                            <a href="/services/modifier/<?= $service['id']; ?>" class="btn btn-primary btn-sm">Modifier</a>
                            <form method="POST" action="/services/supprimer" style="display:inline;">
                                <input type="hidden" name="id" value="<?= $service['id']; ?>">
                                <button type="submit" class="btn btn-danger btn-sm">Supprimer</button>
                            </form>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p class="text-warning">Aucun service trouvé.</p>
        <?php endif; ?>
        <div class="button-container">
            <a href="/services/ajouter" class="btn btn-primary btn-md">Ajouter un service</a>
        </div>

        <h2>Liste des Habitats</h2>
        <?php if (!empty($habitats)): ?>
            <ul class="list-group mb-4">
                <?php foreach ($habitats as $habitat): ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <?= htmlspecialchars($habitat['nom']) ?> : <?= htmlspecialchars($habitat['descriptif']) ?><br>
                        Commentaire: <?= htmlspecialchars($habitat['commentaire']) ?>
                        <div>
                            <a href="/habitats/modifier/<?= $habitat['id'] ?>" class="btn btn-primary btn-sm">Modifier</a>
                            <form method="POST" action="/habitats/supprimer" style="display:inline;">
                                <input type="hidden" name="id" value="<?= $habitat['id'] ?>">
                                <button type="submit" class="btn btn-danger btn-sm">Supprimer</button>
                            </form>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p class="text-warning">Aucun habitat trouvé.</p>
        <?php endif; ?>
        <div class="button-container">
            <a href="/habitats/ajouter" class="btn btn-primary btn-md ">Ajouter un habitat</a>
        </div>

        <h2>Rapports Vétérinaires</h2>
        <form method="GET" action="/admin/dashboard" class="mb-4">
            <div class="mb-3">
                <label for="animal_id" class="form-label">ID de l'animal</label>
                <input type="text" name="animal_id" id="animal_id" class="form-control">
            </div>
            <div class="mb-3">
                <label for="date_start" class="form-label">Date de début</label>
                <input type="date" name="date_start" id="date_start" class="form-control">
            </div>
            <div class="mb-3">
                <label for="date_end" class="form-label">Date de fin</label>
                <input type="date" name="date_end" id="date_end" class="form-control">
            </div>
            <div class="button-container">
                <button type="submit" class="btn btn-primary btn-md">Filtrer</button>
            </div>
        </form>

        <?php if (!empty($rapports)): ?>
            <ul class="list-group mb-4">
                <?php foreach ($rapports as $rapport): ?>
                    <li class="list-group-item">
                        <p>ID Animal: <?= htmlspecialchars($rapport['id_animal']) ?>, Date: <?= htmlspecialchars($rapport['la_date']) ?><br>
                            Rapport: <?= nl2br(htmlspecialchars($rapport['rapport'])) ?></p>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p class="text-warning">Aucun rapport trouvé.</p>
        <?php endif; ?>

        <h2>Les Horaires</h2>
        <form id="form-ajout-horaire" class="mb-4">
            <div class="mb-3">
                <label for="jour" class="form-label">Jour :</label>
                <input type="text" id="jour" name="jour" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="ouverture" class="form-label">Heure d'ouverture :</label>
                <input type="time" id="ouverture" name="ouverture" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="fermeture" class="form-label">Heure de fermeture :</label>
                <input type="time" id="fermeture" name="fermeture" class="form-control" required>
            </div>
            <div class="btn-center"> <button type="submit" class="btn btn-primary btn-md">Ajouter</button> </div>
        </form>

        <?php if (!empty($horaires)): ?>
            <ul class="list-group mb-4">
                <?php foreach ($horaires as $horaire): ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <?= htmlspecialchars($horaire['jour']) ?> : <?= htmlspecialchars($horaire['ouverture']) ?> - <?= htmlspecialchars($horaire['fermeture']) ?>
                        <div>
                            <button class="btn btn-primary btn-sm edit-btn" data-id="<?= $horaire['_id'] ?>">Modifier</button>
                            <form id="form-<?= $horaire['_id'] ?>" class="edit-form" style="display:none;">
                                <input type="hidden" name="id" value="<?= $horaire['_id'] ?>">
                                <input type="text" id="jour-<?= $horaire['_id'] ?>" name="jour" value="<?= htmlspecialchars($horaire['jour']) ?>">
                                <input type="time" id="ouverture-<?= $horaire['_id'] ?>" name="ouverture" value="<?= htmlspecialchars($horaire['ouverture']) ?>">
                                <input type="time" id="fermeture-<?= $horaire['_id'] ?>" name="fermeture" value="<?= htmlspecialchars($horaire['fermeture']) ?>">
                                <button type="submit" class="btn btn-primary btn-sm">Enregistrer</button>
                            </form>
                            <button class="btn btn-danger btn-sm delete-btn" data-id="<?= $horaire['_id'] ?>">Supprimer</button>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p class="text-warning">Aucun horaire trouvé.</p>
        <?php endif; ?>

        <script src="/js/editHoraire.js"></script>
    </div>
</body>

</html>