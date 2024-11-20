<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Arcadia</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="/Assets/css/index.css">
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg">
            <div class="container-fluid">
                <a class="navbar-brand" href="/">
                    <img src="/Assets/images/LOGO.png" alt="Logo Arcadia" ;>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                    <div class="navbar-nav ms-auto">
                        <a class="nav-link" href="/">Accueil</a>
                        <a class="nav-link" href="/habitats">Habitats</a>
                        <a class="nav-link" href="/services">Services</a>
                        <a class="nav-link" href="/contact">Contact</a>
                        <?php if (isset($_SESSION['users'])): ?>
                            <li class="nav-item">
                                <a href="/users/logout" class="nav-link btn btn-secondary">Déconnexion</a>
                            </li>
                        <?php else: ?>
                            <li class="nav-item">
                                <a href="/users/login" class="nav-link btn btn-secondary">Connexion</a>
                            </li>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </nav>

    </header>

    <main>
        <div class="container">
            <?php if (!empty($_SESSION['flash_message'])): ?>
                <div class="alert alert-success" role="alert">
                    <?php echo $_SESSION['flash_message'];
                    unset($_SESSION['flash_message']); ?>
                </div>
            <?php endif; ?>

            <?php if (!empty($_SESSION['erreur'])): ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo $_SESSION['erreur'];
                    unset($_SESSION['erreur']); ?>
                </div>
            <?php endif; ?>
            <?= $contenu ?>
        </div>

    </main>

    <footer class="footer">
        <div class="container p-4">
            <div class="row">
                <div class="col-md-3 mb-2">
                    <h5>Adresse</h5>
                    <p>Zoo Arcadia <br>
                        24 Forêt Broceliande <br>
                        36110 Bretagne <br>
                        Tél: 01 02 03 04 05</p>
                </div>
                <div class="col-md-3 mb-2">
                    <h5>Nos Horaires</h5>
                    <p>Lundi: 9h30 - 18h00<br>
                        Mardi: 9h30 - 18h00<br>
                        Mercredi: 9h30 - 18h00<br>
                        Jeudi: 9h30 - 18h00<br>
                        Vendredi: 9h30 - 18h00<br>
                        Samedi: 9h30 - 20h00<br>
                        Dimanche: 9h00 - 19h00</p>
                </div>
                <div class="col-md-3 mb-2">
                    <h5>Suivez-nous</h5>
                    <p>
                        <a href="https://www.facebook.com">Facebook</a> |
                        <a href="https://www.twitter.com">Twitter</a> |
                        <a href="https://www.instagram.com">Instagram</a>
                    </p>
                </div>
                <div class="col-md-3 mb-2">
                    <h5>Mentions légales</h5>
                    <p>Respect de la vie privée et des données personnelles</p>
                </div>
            </div>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>