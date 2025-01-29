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
                    <img src="/Assets/images/LOGO.png" alt="Logo Arcadia">
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

        <div id="mentionsLegalesModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <h1>Mentions Légales</h1><br>
                <h4>Informations sur l'Éditeur du Site</h4>
                <p>Nom : Zoo Arcadia<br>
                    Adresse : 24 Forêt Broceliande, 36110 Bretagne, France<br>
                    Téléphone : 01 02 03 04 05<br>
                    E-mail : jose@hotmail.fr<br>
                    Directeur de la publication : José Marchand</p><br>

                <h4>Informations sur l'Hébergeur du Site</h4>
                <p>Nom : Heroku<br>
                    Adresse : 650 7th Street, San Francisco, CA 94103, États-Unis<br>
                    Téléphone : +1 415-555-1234</p><br>

                <h4>Informations sur la Société</h4>
                <p>Forme juridique : SARL au capital de 10 000 €<br>
                    RCS : 123 456 789 RCS Paris<br>
                    Numéro de TVA : FR123456789</p><br>

                <h4>Propriété Intellectuelle</h4>
                <p>Le contenu du site Zoo Arcadia (textes, images, vidéos) est la propriété exclusive de la société Zoo Arcadia.
                    <br>Toute reproduction est interdite sans autorisation préalable.
                </p><br>

                <h4>Données Personnelles</h4>
                <p>Les données personnelles collectées sur ce site sont utilisées uniquement à des fins de communication avec les utilisateurs.
                    <br>Vous disposez d'un droit d'accès, de rectification, d'effacement, de limitation du traitement, d'opposition et de portabilité de vos données en nous contactant à l'adresse e-mail mentionnée ci-dessus.
                    <br>Le traitement des données est basé sur le consentement des utilisateurs, l'exécution d'un contrat ou une obligation légale.
                    <br>Les données personnelles sont conservées pendant une durée n'excédant pas celle nécessaire aux finalités pour lesquelles elles sont collectées et traitées.
                    <br>Nous avons mis en place des mesures de sécurité appropriées pour protéger vos données contre les accès non autorisés, la perte, la destruction ou la modification.
                    <br>Si vous avez des questions ou des préoccupations concernant vos données personnelles, vous pouvez contacter notre Délégué à la Protection des Données (DPD) à l'adresse e-mail mentionnée ci-dessus.
                </p><br>

                <h4>Cookies et Technologies de Suivi</h4>
                <p>Nous utilisons des cookies et d'autres technologies de suivi pour améliorer votre expérience sur notre site.
                    <br>Pour plus d'informations sur l'utilisation des cookies, veuillez consulter le site officiel de la <a href="https://www.cnil.fr/fr/cookies-et-autres-traceurs" target="_blank">CNIL</a>.
                </p>

                <h4>Liens Hypertextes</h4>
                <p>Zoo Arcadia décline toute responsabilité concernant les liens hypertextes vers des sites tiers.
                    <br>La création de liens vers ce site est autorisée sous réserve d'une autorisation préalable.
                </p><br>

                <h4>Conditions Générales d'Utilisation (CGU)</h4>
                <p>L'utilisation de ce site est soumise aux conditions générales d'utilisation décrites sur cette page.
                    <br>Zoo Arcadia décline toute responsabilité en cas de dommages résultant de l'utilisation de ce site.
                </p><br>

            </div>
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
                    <div id="footerHoraires">
                    </div>
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
                    <p>
                        <a href="#" id="mentionsLegalesLink">Respect de la vie privée et des données personnelles</a>
                    <p>
                    </p>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <script>
        async function loadFooterHoraires() {
            try {
                const response = await fetch('/horaire/read');
                const horaires = await response.json();
                let html = '<ul class="horaires-list">';
                horaires.forEach(horaire => {
                    html += `<li>${horaire.jour}: ${horaire.ouverture} - ${horaire.fermeture}</li>`;
                });
                html += '</ul>';
                document.getElementById('footerHoraires').innerHTML = html;
            } catch (error) {
                console.error('Erreur :', error);
            }
        }
        document.addEventListener('DOMContentLoaded', loadFooterHoraires);
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('mentionsLegalesModal');
            const link = document.getElementById('mentionsLegalesLink');
            const span = document.getElementsByClassName('close')[0];
            link.onclick = function() {
                modal.style.display = 'block';
            }
            span.onclick = function() {
                modal.style.display = 'none';
            }
            window.onclick = function(event) {
                if (event.target === modal) {
                    modal.style.display = 'none';
                }
            }
        });
    </script>

</body>

</html>
