<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SafeZone - Urgences en temps réel</title>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@600&family=Poppins:wght@300;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <canvas id="stars"></canvas>

    <header class="header">
        <div class="logo-area">
            <img src="sos.jpg" alt="Logo" class="logo-img">
            <h1 class="logo-text">SafeZone</h1>
        </div>
        <nav>
            <ul class="nav-links">
                <li><a href="index.php">Accueil</a></li>
                <li><a href="index1.php">Nos Services</a></li>
                <li><a href="#about">À propos</a></li>
                <li><a href="#contact">Contact</a></li>
            </ul>
        </nav>
        <button class="btn-alert" onclick="window.location.href='index2.php'">🚨 Help Me Now</button>
    </header>

    <section class="hero">
        <h2>Votre sécurité est notre priorité</h2>
        <p>Recevez ou envoyez des alertes instantanément. SafeZone connecte les personnes en détresse aux secours les plus proches.</p>
        <div>
            <a href="login.php" class="btn-primary">Se connecter</a>
            <a href="register.php" class="btn-secondary">Créer un compte</a>
        </div>
    </section>

    <section class="services" id="services">
        <h3>Nos Services</h3>
        <div class="service-list">
            <div class="service">
                <i class="fas fa-map-marker-alt"></i>
                <h4>Alertes géolocalisées</h4>
                <p>Envoyez une alerte avec votre position exacte pour une intervention rapide.</p>
            </div>
            <div class="service">
                <i class="fas fa-shield-alt"></i>
                <h4>Protection en temps réel</h4>
                <p>Nos équipes assurent une réponse rapide pour protéger les personnes en danger.</p>
            </div>
            <div class="service">
                <i class="fas fa-users"></i>
                <h4>Connexion 24/7</h4>
                <p>Disponible à toute heure pour répondre à toutes les urgences.</p>
            </div>
        </div>
    </section>

    <section class="about" id="about">
        <img src="SS.jpg" alt="" srcset="">
        <h3>Qui sommes-nous ?</h3>
        <p>SafeZone est une plateforme humanitaire intelligente conçue pour sauver des vies.
Elle permet de connecter immédiatement toute personne en situation d'urgence (malaise, agression, disparition...) avec les secours les plus proches, disponibles et qualifiés, comme un médecin, un policier, ou un volontaire formé.

Grâce à un système de géolocalisation en temps réel, SafeZone identifie la position exacte de l’utilisateur et analyse le type de situation (urgence médicale, danger, personne disparue...) afin d’envoyer une alerte aux secours les plus pertinents dans les environs.

La plateforme fonctionne 24h/24 et 7j/7, et peut être utilisée aussi bien en ville qu’en zones rurales.
Elle vise à réduire le temps d'intervention des secours, optimiser l'organisation des aides de proximité, et renforcer la solidarité citoyenne à travers la technologie.

SafeZone est également dotée d’un système de matching intelligent, qui choisit le meilleur intervenant en fonction de :

sa proximité géographique

sa spécialité

sa disponibilité immédiate

et la gravité de la situation

En quelques clics, un appel à l’aide peut être lancé, traité et secouru. SafeZone, c’est une zone de sécurité intelligente et humaine, à la portée de tous.</p>
    </section>

    <footer class="footer" id="contact">
        <p>Contactez-nous à : <a href="mailto:support@safezone.com">support@safezone.com</a></p>
        <div class="social-icons">
            <a href="https://facebook.com/safezone" target="_blank"><i class="fab fa-facebook"></i></a>
            <a href="https://twitter.com/safezone" target="_blank"><i class="fab fa-twitter"></i></a>
            <a href="https://instagram.com/safezone" target="_blank"><i class="fab fa-instagram"></i></a>
        </div>
        <p>&copy; 2025 SafeZone. Tous droits réservés.</p>
    </footer>

    <script>
        const canvas = document.getElementById('stars');
        const ctx = canvas.getContext('2d');
        canvas.width = window.innerWidth;
        canvas.height = window.innerHeight;
        let stars = [];
        for (let i = 0; i < 100; i++) {
            stars.push({x: Math.random() * canvas.width, y: Math.random() * canvas.height, r: Math.random() * 1.5, d: Math.random() * 0.5});
        }

        function drawStars() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            ctx.fillStyle = 'white';
            for (let i = 0; i < stars.length; i++) {
                let s = stars[i];
                ctx.beginPath();
                ctx.arc(s.x, s.y, s.r, 0, Math.PI * 2, false);
                ctx.fill();
            }
        }

        function updateStars() {
            for (let i = 0; i < stars.length; i++) {
                let s = stars[i];
                s.x += (Math.random() - 0.5) * 0.3;
                s.y += (Math.random() - 0.5) * 0.3;
            }
        }

        function animate() {
            drawStars();
            updateStars();
            requestAnimationFrame(animate);
        }
        animate();
    </script>
</body>

</html>
