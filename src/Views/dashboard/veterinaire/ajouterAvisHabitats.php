<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Ajouter un avis</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container mt-4">
        <h1>Ajouter un avis pour la <?= htmlspecialchars($habitat->nom) ?></h1>
        <div class="form-column">
            <?= $form ?>
        </div>
    </div>
</body>

</html>

