<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenue sur Arcadia</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/Assets/css/index.css">
</head>

<body>
    <main class="container mt-4">
        <h1>Bienvenue au Zoo d'Arcadia</h1><br>
        <p>Arcadia est un zoo situé en France, près de la forêt de Brocéliande, en Bretagne, depuis 1960. Ce lieu enchanteur abrite une grande variété d'animaux, soigneusement répartis par habitat : la savane, la jungle et les marais. La philosophie d'Arcadia repose sur le respect et la protection de ses pensionnaires. Chaque jour, une équipe de vétérinaires dévoués se rend sur place pour effectuer des contrôles minutieux sur chaque animal avant l’ouverture du zoo.</p>
        <br>
        <div class="section">
            <h2>Habitats</h2>
            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        <img src="Assets/images/savane.jpg" class="card-img-top" alt="La savane">
                        <h5 class="card-title">
                            <a href="/habitats/afficherAnimaux/1">La savane</a>
                        </h5>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <img src="Assets/images/jungle.jpg" class="card-img-top" alt="La Jungle">
                        <h5 class="card-title">
                            <a href="/habitats/afficherAnimaux/2">La jungle</a>
                        </h5>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <img src="Assets/images/marais.jpg" class="card-img-top" alt="Le Marais">
                        <h5 class="card-title">
                            <a href="/habitats/afficherAnimaux/3">Le marais</a>
                        </h5>
                    </div>
                </div>
            </div>
        </div>

        <div class="section">
            <h2>Services</h2>
            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        <img src="Assets/images/restaurant.jpg" class="card-img-top" alt="La restauration">
                        <h5 class="card-title">
                            <a href="/services/lire/1">Restauration</a>
                        </h5>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <img src="Assets/images/guide.jpg" class="card-img-top" alt="Visite guidée">
                        <h5 class="card-title">
                            <a href="/services/lire/2">Visites guidées</a>
                        </h5>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <img src="Assets/images/visitetrain.jpg" class="card-img-top" alt="Safari-Train">
                        <h5 class="card-title">
                            <a href="/services/lire/3">Safari-Train</a>
                        </h5>
                    </div>
                </div>
            </div>
        </div>

        <section id="avis" class="mt-5">
            <h2>Avis</h2>
            <div class="row">
                <?php if (isset($avisValidés) && !empty($avisValidés)): ?>
                    <?php foreach ($avisValidés as $avis): ?>
                        <div class="col-md-4 mb-3">
                            <div class="avis-item">
                                <p><strong><?= htmlspecialchars($avis['pseudo']) ?></strong><br>
                                    <?= htmlspecialchars($avis['commentaire']) ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>Aucun avis validé pour le moment.</p>
                <?php endif; ?>
            </div>


            <div class="center-container">
                <a href="#" id="laisserAvis">Donner mon avis</a>
                <div id="formulaireAvis" style="display: none;">
                    <form action="/main/ajouter" method="POST" class="forme-column">
                        <label for="pseudo">Votre nom:</label>
                        <input type="text" id="pseudo" name="pseudo" required>

                        <label for="commentaire">Votre avis:</label>
                        <textarea id="commentaire" name="commentaire" required></textarea>

                        <button type="submit">Envoyer</button>
                    </form>
                </div>
            </div>
        </section>

        <script>
            document.getElementById('laisserAvis').addEventListener('click', function(event) {
                event.preventDefault();
                var formulaire = document.getElementById('formulaireAvis');
                formulaire.style.display = formulaire.style.display === 'none' ? 'block' : 'none';
            });
        </script>
    </main>
    <footer></footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>