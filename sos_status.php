<?php
session_start();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>📊 Statut des Alertes</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
  <style>
    body {
      margin: 0;
      font-family: 'Poppins', sans-serif;
      background: #121212;
      color: #fff;
      display: flex;
      min-height: 100vh;
      overflow: hidden;
    }

    /* Background animation */
    .background {
      position: fixed;
      top: 0; left: 0;
      width: 100%;
      height: 100%;
      background: url('nebula.jpg') no-repeat center center fixed;
      background-size: cover;
      animation: moveBackground 20s infinite linear;
      filter: blur(15px);
      z-index: -1;
    }

    @keyframes moveBackground {
      0% { background-position: 0% 0%; }
      100% { background-position: 100% 100%; }
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

    .container {
      margin-left: 270px;
      width: calc(100% - 270px);
      padding: 40px;
      background: rgba(0, 0, 0, 0.8);
      border-radius: 20px;
      box-shadow: 0 0 20px rgba(69, 243, 255, 0.3);
      text-align: center;
      animation: fadeIn 1s;
    }

    @keyframes fadeIn {
      0% { opacity: 0; }
      100% { opacity: 1; }
    }

    h1 {
      color: #45f3ff;
      text-shadow: 0 0 10px #45f3ff;
      margin-bottom: 30px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      backdrop-filter: blur(10px);
      background-color: rgba(34, 34, 34, 0.8);
      border-radius: 12px;
      overflow: hidden;
    }

    th, td {
      padding: 15px;
      border: 1px solid #444;
      font-size: 1em;
    }

    th {
      background-color: #333;
      color: #45f3ff;
    }

    td {
      color: white;
    }

    .no-data {
      color: #aaa;
      font-style: italic;
    }

    .back-btn {
      margin: 40px 0 30px 0;
      background: #45f3ff;
      color: #000;
      padding: 12px 25px;
      border-radius: 10px;
      text-decoration: none;
      font-weight: bold;
      box-shadow: 0 0 10px #45f3ff;
      transition: 0.3s;
    }

    .back-btn:hover {
      background: #ff2770;
      color: #fff;
    }
  </style>
</head>
<body>

  <div class="background"></div>

  <!-- Sidebar -->
  <div class="sidebar">
    <a href="index.php">🏡Accueil</a>
    <a href="sos.php">Gestion des Alertes</a>
    <a href="sos_status.php">Statut des Alertes</a>
    <a href="profil.php"> 👤Profil</a>
    <a href="logout.php">🔓Se Déconnecter</a>
  </div>

  <div class="container">

    <h1>📊 Statut des alertes</h1>

    <?php if (!empty($_SESSION['alertes'])): ?>
      <table>
        <thead>
          <tr>
            <th>Type</th>
            <th>Localisation</th>
            <th>Message</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($_SESSION['alertes'] as $alert): ?>
            <tr>
              <td><?= htmlspecialchars($alert['type']) ?></td>
              <td><?= htmlspecialchars($alert['location']) ?></td>
              <td><?= htmlspecialchars($alert['message']) ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    <?php else: ?>
      <p class="no-data">Aucune alerte enregistrée.</p>
    <?php endif; ?>

    <a href="index.php" class="back-btn">⬅️ Retour à l'accueil</a>

  </div>

</body>
</html>
