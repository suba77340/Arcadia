<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Contact</title>
    <link rel="stylesheet" href="styles.css">

</head>
<body>
    <h1 class="title">Contactez-nous</h1>
    <form method="POST" action="/contact/envoyer" class="form-column" novalidate>
        <div class="form-group mb-3">
            <label for="titre" class="form-label">Titre</label>
            <input type="text" name="titre" id="titre" class="form-control" placeholder="Entrez le titre" required>
        </div>
        <div class="form-group mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" id="description" class="form-control" rows="5" placeholder="Décrivez votre message" required></textarea>
        </div>
        <div class="form-group mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" id="email" class="form-control" placeholder="Entrez votre email" required>
        </div>
        <button type="submit" class="btn btn-primary">Envoyer</button>
    </form>
</body>
</html>
