<?php
$host = "localhost";
$user = "root";
$password = "";
$db = "safezone_db";

// Connexion avec PDO
try {
    $conn = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

// Variable pour stocker le message
$message = '';

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["rescueType"]) && isset($_POST["description"])) {
    $type = trim($_POST["rescueType"]);
    $desc = trim($_POST["description"]);
    $now = date("Y-m-d H:i:s");

    $sql = "INSERT INTO demandes (type_rescueur, description, date_envoi) VALUES (:type, :desc, :now)";

    try {
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':type' => $type,
            ':desc' => $desc,
            ':now' => $now
        ]);

        $message = "<div class='success-message'>
                      <strong>Demande enregistrée avec succès !</strong><br>
                      <strong>Type :</strong> " . htmlspecialchars($type) . "<br>
                      <strong>Description :</strong> " . nl2br(htmlspecialchars($desc)) . "
                    </div>";
    } catch (PDOException $e) {
        $message = "<div class='error-message'>
                      Erreur : " . htmlspecialchars($e->getMessage()) . "
                    </div>";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Safe Zone - Nouvelle Demande</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
  <style>
    /* BACKGROUND */
    body {
      margin: 0;
      font-family: 'Poppins', sans-serif;
      background: #121212;
      color: #fff;
      display: flex;
      min-height: 100vh;
      overflow-x: hidden;
    }

    @keyframes moveBackground {
      0% { background-position: 0% 0%; }
      100% { background-position: 100% 100%; }
    }

    /* SIDEBAR */
    .sidebar {
      width: 250px;
      height: 100vh;
      background: #1f1f1f;
      position: fixed;
      top: 0;
      left: 0;
      padding-top: 40px;
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
      font-size: 1.2em;
      transition: background-color 0.3s;
    }

    .sidebar a:hover {
      background-color: #333;
      color: #fff;
    }

    .background {
      position: fixed;
      top: 0; left: 0;
      width: 100%;
      height: 100%;
      background: url('nebula.jpg') no-repeat center center fixed;
      background-size: cover;
      animation: moveBackground 20s infinite linear;
      filter: blur(5px);
      z-index: -1;
    }

    .container {
      margin-left: 270px;
      width: calc(100% - 270px);
      padding: 40px;
      background: rgba(0, 0, 0, 0.5);
      border-radius: 20px;
      box-shadow: 0 0 20px rgba(69, 243, 255, 0.3);
      animation: fadeIn 1s;
      margin-top: 20px;
    }

    @keyframes fadeIn {
      0% { opacity: 0; }
      100% { opacity: 1; }
    }

    h1 {
      color: #45f3ff;
      text-shadow: 0 0 10px #45f3ff;
      text-align: center;
      margin-bottom: 30px;
    }

    form {
      display: flex;
      flex-direction: column;
      gap: 20px;
    }

    label {
      font-weight: bold;
    }

    select, textarea, input {
      padding: 12px;
      border: none;
      border-radius: 8px;
      background: #1f1f1f;
      color: #fff;
    }

    button {
      padding: 12px;
      background: #45f3ff;
      border: none;
      border-radius: 8px;
      font-size: 1.1em;
      font-weight: bold;
      cursor: pointer;
      transition: 0.3s;
    }

    button:hover {
      background: #ff2770;
      color: white;
    }

    .btn-link {
      margin-top: 30px;
      display: inline-block;
      padding: 12px 25px;
      background: #0080ff;
      color: white;
      border-radius: 10px;
      text-decoration: none;
      transition: 0.3s;
      text-align: center;
    }

    .btn-link:hover {
      background: #0059b3;
    }

    .map-container {
      margin-top: 40px;
      border-radius: 12px;
      overflow: hidden;
    }

    iframe {
      width: 100%;
      height: 300px;
      border: none;
    }

    .success-message {
      margin: 20px 0;
      background: #004466;
      padding: 15px;
      border-radius: 8px;
      box-shadow: 0 0 10px #45f3ff;
      text-align: center;
    }

    .error-message {
      margin: 20px 0;
      background: #660000;
      padding: 15px;
      border-radius: 8px;
      box-shadow: 0 0 10px #ff2770;
      text-align: center;
    }
  </style>
</head>
<body>

<div class="background"></div>

<div class="sidebar">
  <a href="index.php">🏡 Accueil</a>
  <a href="sos.php">Gestion des Alertes</a>
  <a href="sos_status.php">Statut des Alertes</a>
  <a href="profil.php">👤 Profil</a>
  <a href="logout.php">🔓 Se Déconnecter</a>
</div>

<div class="container">
  <h1>Safe Zone - Nouvelle Demande</h1>

  <?php
  // Afficher le message ici proprement
  if (!empty($message)) {
      echo $message;
  }
  ?>

  <form method="POST">
    <label for="rescueType">Type de Sauveteur :</label>
    <select name="rescueType" id="rescueType" required>
      <option value="">Sélectionner un type</option>
      <option value="Pompier">Pompier</option>
      <option value="Médecin">Médecin</option>
      <option value="Sauveteur Maritime">Sauveteur Maritime</option>
      <option value="Sécurité Civile">Sécurité Civile</option>
    </select>

    <label for="description">Description de la situation :</label>
    <textarea name="description" id="description" rows="4" required></textarea>

    <button type="submit">Envoyer</button>
  </form>

  <div style="text-align: center;">
    <a href="select-type.php" class="btn-link">Choisir une Alerte</a>
  </div>

  <div class="map-container">
    <iframe 
      src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3329.168531172692!2d-7.626!3d33.586!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xda7cdfb6df7efdf%3A0x1baf8573ef2eb8de!2sCasablanca%2C%20Morocco!5e0!3m2!1sfr!2sma!4v1619000000000!5m2!1sfr!2sma" 
      allowfullscreen=""
      loading="lazy">
    </iframe>
  </div>

</div>

</body>
</html>
