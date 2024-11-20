<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Ajouter un Rapport</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container mt-4">
        <h1>Ajouter un Rapport pour <?= htmlspecialchars($animal['nom']) ?></h1>
        <div class="form-column">
            <?= $form ?>
        </div>
    </div>
</body>

</html>
