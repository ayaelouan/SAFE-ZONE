<!DOCTYPE html>
<html lang="fr" dir="ltr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Welcome to SafeZone</title>
  <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
* {
  box-sizing: border-box;
  margin: 0;
  padding: 0;
}

body {
  font-family: 'Cairo', sans-serif;
  background: radial-gradient(circle at top left, #0a001a, #1a001a, #000010);
  color: #ffffff;
  overflow-x: hidden;
}

.container {
  max-width: 1200px;
  margin: auto;
  padding: 60px 30px;
}

.welcome {
  text-align: center;
  padding: 100px 40px;
  border-radius: 30px;
  background: linear-gradient(135deg, #1c0033, #33001a);
  box-shadow: 0 0 70px rgba(255, 0, 128, 0.7);
  animation: fadeIn 1.5s ease-in-out;
  backdrop-filter: blur(8px);
}

.welcome h1 {
  font-size: 64px;
  color: #00d9ff;
  text-shadow: 0 0 40px #00d9ff, 0 0 80px #ff0080;
  margin-bottom: 30px;
  letter-spacing: 3px;
}

.welcome p {
  font-size: 24px;
  color: #f5f5f5;
  line-height: 2;
  max-width: 1000px;
  margin: 0 auto;
  text-shadow: 0 0 10px #7700ff66;
}

.counter {
  font-size: 30px;
  color: #ff4ec4;
  text-shadow: 0 0 15px #ff4ec4, 0 0 30px #00eaff;
  text-align: center;
  margin: 50px 0 80px;
}

.services {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
  gap: 40px;
}

.card {
  background: linear-gradient(145deg, rgba(255,255,255,0.03), rgba(255,255,255,0.08));
  border: 1px solid rgba(255, 255, 255, 0.15);
  border-radius: 30px;
  padding: 40px 30px;
  text-align: center;
  box-shadow: 0 0 40px rgba(255, 0, 128, 0.25);
  transition: transform 0.4s ease, box-shadow 0.4s ease;
  backdrop-filter: blur(10px);
}

.card:hover {
  transform: scale(1.1) rotateZ(1deg);
  box-shadow: 0 0 80px #ff0066, 0 0 30px #00eaff;
}

.card i {
  font-size: 56px;
  margin-bottom: 25px;
  color: #00d9ff;
  animation: floatIcon 3s infinite ease-in-out;
  text-shadow: 0 0 20px #00d9ff;
}

.card h3 {
  font-size: 26px;
  margin-bottom: 14px;
  color: #ff3399;
  letter-spacing: 1.5px;
  text-shadow: 0 0 15px #ff3399;
}

.card p {
  font-size: 18px;
  color: #e0e0e0;
  line-height: 1.7;
}

.cta {
  text-align: center;
  margin-top: 90px;
}

.cta h2 {
  font-size: 38px;
  color: #ff003c;
  margin-bottom: 30px;
  text-shadow: 0 0 25px #ff003c, 0 0 10px #00eaff;
  letter-spacing: 2px;
}

.cta button {
  background: linear-gradient(135deg, #00eaff, #ff0077);
  color: white;
  border: none;
  padding: 18px 40px;
  font-size: 22px;
  border-radius: 60px;
  box-shadow: 0 0 30px #00eaff;
  cursor: pointer;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.cta button:hover {
  transform: scale(1.05);
  background: linear-gradient(135deg, #ff0077, #00eaff);
  box-shadow: 0 0 60px #ff0077;
}

footer {
  text-align: center;
  padding: 40px;
  font-size: 16px;
  color: #aaa;
  margin-top: 80px;
  border-top: 1px solid rgba(255,255,255,0.1);
  text-shadow: 0 0 10px #5500aa55;
}

@keyframes fadeIn {
  from { opacity: 0; transform: translateY(-30px); }
  to { opacity: 1; transform: translateY(0); }
}

@keyframes floatIcon {
  0% { transform: translateY(0); }
  50% { transform: translateY(-12px); }
  100% { transform: translateY(0); }
}

</style>
</head>
<body>

  <div class="container">
    <div class="welcome">
      <h1>Bienvenue sur SafeZone</h1>
      <p>Une plateforme intelligente qui vous connecte aux secours les plus proches selon votre besoin, votre position et votre urgence.</p>
    </div>

    <div class="counter">
      <?php
        $nombreSecours = 5823;
        echo "📈 Interventions réalisées : <strong>$nombreSecours</strong>";
      ?>
    </div>

    <div class="services">
      <div class="card"><i class="fas fa-user-md"></i><h3>Interventions médicales</h3><p>Accès rapide à un professionnel en cas de besoin vital.</p></div>
      <div class="card"><i class="fas fa-shield-alt"></i><h3>Sécurité</h3><p>Appel aux forces de l'ordre proches en cas de menace.</p></div>
      <div class="card"><i class="fas fa-child"></i><h3>Alerte disparition</h3><p>Mobilisation citoyenne locale lors d'une disparition.</p></div>
      <div class="card"><i class="fas fa-fire-extinguisher"></i><h3>Catastrophes naturelles</h3><p>Coordination des secours lors d'incidents majeurs.</p></div>
      <div class="card"><i class="fas fa-brain"></i><h3>Support psychologique</h3><p>Soutien adapté dans les moments de crise mentale.</p></div>
      <div class="card"><i class="fas fa-user-graduate"></i><h3>Formation & prévention</h3><p>Ateliers de premiers secours et prévention.</p></div>
      <div class="card"><i class="fas fa-hands-helping"></i><h3>Solidarité</h3><p>Assistance continue pour les personnes fragiles.</p></div>
      <div class="card"><i class="fas fa-map-marked-alt"></i><h3>Carte interactive</h3><p>Visualisation des incidents en direct.</p></div>
      <div class="card"><i class="fas fa-bolt"></i><h3>Système d’alerte</h3><p>Notifications multi-sensorielles en cas d'urgence.</p></div>
      <!-- NOUVELLES CARTES -->
      <div class="card"><i class="fas fa-language"></i><h3>Assistance multilingue</h3><p>Des intervenants capables de parler plusieurs langues.</p></div>
      <div class="card"><i class="fas fa-car-crash"></i><h3>Accidents de la route</h3><p>Aide immédiate en cas de collision ou urgence routière.</p></div>
      <div class="card"><i class="fas fa-dog"></i><h3>Urgence animale</h3><p>Secours pour animaux blessés ou en danger.</p></div>
    </div>

    <div class="cta">
      <h2>Envie de devenir volontaire ?</h2>
      <button onclick="window.location.href='volunteer_signup.php'">Je m'inscris maintenant</button>
    </div>

    <footer>
      © 2025 SafeZone | Ensemble, on sauve des vies.
    </footer>
  </div>

</body>
</html>
