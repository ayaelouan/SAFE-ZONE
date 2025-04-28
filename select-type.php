<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Sélection du type d'alerte</title>
  <style>
    body {
      margin: 0;
      padding: 0;
      font-family: 'Segoe UI', sans-serif;
      background: radial-gradient(circle at top left, #1a1a1a, #000000);
      color: #fff;
      overflow: hidden;
    }

    .background {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: url('nebula.jpg') no-repeat center center fixed;
      background-size: cover;
      animation: nebula 30s linear infinite;
      filter: blur(10px);
      z-index: -1;
    }

    @keyframes nebula {
      0% { background-position: 0 0; }
      100% { background-position: 100% 100%; }
    }

    h1 {
      text-align: center;
      margin: 40px 0 20px;
      font-size: 2em;
      color: #45f3ff;
      text-shadow: 0 0 15px #45f3ff99;
    }

    .alerts {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
      gap: 30px;
      max-width: 1000px;
      margin: auto;
      padding: 20px;
    }

    .alert-type {
      background: #111;
      border-radius: 20px;
      overflow: hidden;
      box-shadow: 0 0 10px #ff277055;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .alert-type:hover {
      transform: translateY(-5px);
      box-shadow: 0 0 20px #45f3ff, 0 0 40px #ff2770aa;
    }

    .alert-type form {
      display: flex;
      flex-direction: column;
      height: 100%;
    }

    .alert-type img {
      width: 100%;
      height: 140px;
      object-fit: cover;
      border-bottom: 2px solid #333;
    }

    .alert-type p {
      margin: 0;
      padding: 12px;
      font-weight: bold;
      color: #ff2770;
      text-align: center;
      font-size: 1.1em;
      flex-grow: 1;
    }

    .alert-type button {
      background: #45f3ff;
      color: #000;
      border: none;
      border-radius: 0 0 20px 20px;
      padding: 10px;
      font-weight: bold;
      cursor: pointer;
      transition: 0.3s;
    }

    .alert-type button:hover {
      background: #ff2770;
      color: #fff;
    }

    /* Sidebar styles */
    .sidebar {
      width: 250px;
      height: 100vh;
      background: #1f1f1f;
      position: fixed;
      top: 0;
      left: 0;
      padding-top: 40px;
      color: #fff;
      box-shadow: 2px 0px 15px rgba(0, 0, 0, 0.5);
      display: flex;
      flex-direction: column;
      align-items: center;
      transform: translateX(-250px);
      animation: slideIn 0.5s forwards;
    }

    @keyframes slideIn {
      0% { transform: translateX(-250px); }
      100% { transform: translateX(0); }
    }

    .sidebar a {
      color: #45f3ff;
      text-decoration: none;
      padding: 15px;
      width: 100%;
      text-align: center;
      transition: background-color 0.3s;
      font-size: 1.2em;
    }

    .sidebar a:hover {
      background-color: #333;
      color: #fff;
    }
  </style>
</head>
<body>

<!-- Ajout de l'élément audio pour le son de clic -->
<audio id="click-sound" src="alert-sound.mp3" preload="auto"></audio>

<div class="background"></div>
<div class="sidebar">
    <a href="index.php">🏡Accueil</a>
    <a href="sos.php">Gestion des Alertes</a>
    <a href="sos_status.php">Statut des Alertes</a>
    <a href="profil.php"> 👤Profil</a>
    <a href="logout.php">🔓Se Déconnecter</a>
  </div>

<h1>📢 Sélectionnez le type d'alerte</h1>

<div class="alerts">
  <?php
    $alertes = [
      ["Accident", "car-crash.webp", "🚗"],
      ["Maladie", "health.jpeg", "🩺"],
      ["Menace", "threat.svg", "⚠️"],
      ["Feu", "fire.webp", "🔥"],
      ["Attaque animale", "attaque animale.jpg", "🐕‍🦺"],
      ["Inondation", "innodation.webp", "🌊"],
      ["Séisme", "siésme.jpg", "🌍"],
      ["Perdu", "disparition.jpg", "🧍"],
      ["Autre", "other.png", "❓"]
    ];

    foreach ($alertes as $a) {
      echo '<div class="alert-type">
              <form onsubmit="return envoyerAlerte(this);" method="GET">
                <input type="hidden" name="type" value="'.htmlspecialchars($a[0]).'">
                <input type="hidden" name="lat">
                <input type="hidden" name="lon">
                <img src="icons/'.htmlspecialchars($a[1]).'" alt="'.htmlspecialchars($a[0]).'">
                <p>'.$a[2].' '.htmlspecialchars($a[0]).'</p>
                <button type="submit" onclick="playClickSound()">Sélectionner</button>
              </form>
            </div>';
    }
  ?>
</div>

<script>
  // Fonction pour jouer le son de clic
  function playClickSound() {
    var clickSound = document.getElementById("click-sound");
    clickSound.play();
  }

  function envoyerAlerte(form) {
    if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(function(position) {
        form.lat.value = position.coords.latitude;
        form.lon.value = position.coords.longitude;
        form.action = "sos.php";
        form.submit();
      }, function(error) {
        alert("Géolocalisation refusée ou indisponible.");
        form.action = "sos.php";
        form.submit();
      });
    } else {
      alert("La géolocalisation n'est pas supportée.");
      form.action = "sos.php";
      form.submit();
    }
    return false;
  }
</script>

</body>
</html>
