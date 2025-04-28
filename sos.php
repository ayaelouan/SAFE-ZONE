<?php
session_start();

if (!isset($_SESSION['alertes'])) {
    $_SESSION['alertes'] = [];
}

$typeChoisi = $_GET['type'] ?? null;
$alertToEdit = $_GET['edit'] ?? null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];
    $id = $_POST['id'] ?? uniqid();

    if ($action === 'ajouter') {
        $_SESSION['alertes'][$id] = [
            'type' => $_POST['type'],
            'location' => $_POST['location'],
            'message' => $_POST['message']
        ];
    } elseif ($action === 'modifier') {
        $_SESSION['alertes'][$id] = [
            'type' => $_POST['type'],
            'location' => $_POST['location'],
            'message' => $_POST['message']
        ];
    } elseif ($action === 'supprimer') {
        unset($_SESSION['alertes'][$id]);
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Gestion des Alertes</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
  <style>
    * {
      box-sizing: border-box;
    }

    body {
      font-family: 'Poppins', sans-serif;
      background: #121212;
      color: #fff;
      margin: 0;
      padding: 40px 20px;
      background-image: url('nebula.jpg');
      background-size: cover;
      background-attachment: fixed;
    }

    .container {
      max-width: 1000px;
      margin: 0 auto;
      backdrop-filter: blur(10px);
      background: rgba(0, 0, 0, 0.6);
      padding: 30px;
      border-radius: 20px;
      box-shadow: 0 0 30px rgba(69, 243, 255, 0.4);
    }

    h1 {
      text-align: center;
      color: #45f3ff;
      text-shadow: 0 0 15px #45f3ff;
      margin-bottom: 40px;
    }

    form {
      display: flex;
      flex-direction: column;
      gap: 20px;
    }

    label {
      font-size: 1.1em;
      color: #ccc;
    }

    input, textarea {
      padding: 12px;
      border-radius: 10px;
      border: none;
      background: #1e1e1e;
      color: #fff;
      font-size: 1em;
    }

    input:focus, textarea:focus {
      outline: 2px solid #45f3ff;
    }

    button {
      padding: 12px 20px;
      background: #45f3ff;
      color: black;
      font-weight: bold;
      border: none;
      border-radius: 10px;
      cursor: pointer;
      transition: all 0.3s;
    }

    button:hover {
      background: #ff2770;
      transform: scale(1.05);
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 40px;
      background: rgba(0, 0, 0, 0.4);
      backdrop-filter: blur(5px);
      border-radius: 15px;
      overflow: hidden;
    }

    th, td {
      padding: 15px;
      text-align: center;
      border-bottom: 1px solid #333;
    }

    th {
      background-color: #222;
      color: #45f3ff;
    }

    td {
      background-color: rgba(34, 34, 34, 0.8);
    }

    .action-buttons {
      display: flex;
      gap: 10px;
      justify-content: center;
    }

    .edit-btn, .delete-btn {
      padding: 8px 12px;
      border: none;
      border-radius: 8px;
      font-weight: bold;
    }

    .edit-btn {
      background: #45f3ff;
      color: #000;
    }

    .edit-btn:hover {
      background: #33cc99;
    }

    .delete-btn {
      background: #ff2770;
      color: #fff;
    }

    .delete-btn:hover {
      background: #e60046;
    }

    @media screen and (max-width: 768px) {
      form, table {
        font-size: 0.9em;
      }
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
    <div class="backgound"></div>
    <div class="sidebar">
    <a href="index.php">🏡Accueil</a>
    <a href="sos.php">Gestion des Alertes</a>
    <a href="sos_status.php">Statut des Alertes</a>
    <a href="profil.php"> 👤Profil</a>
    <a href="logout.php">🔓Se Déconnecter</a>
  </div>
<div class="container">
  <h1>📢 Gestion des alertes</h1>

  <?php if ($alertToEdit && isset($_SESSION['alertes'][$alertToEdit])): 
    $alert = $_SESSION['alertes'][$alertToEdit]; ?>
    <form method="POST">
      <input type="hidden" name="action" value="modifier">
      <input type="hidden" name="id" value="<?= $alertToEdit ?>">

      <label>Type d'alerte</label>
      <input type="text" name="type" value="<?= htmlspecialchars($alert['type']) ?>" readonly>

      <label>Localisation</label>
      <input type="text" name="location" value="<?= htmlspecialchars($alert['location']) ?>" required>

      <label>Message</label>
      <textarea name="message" required><?= htmlspecialchars($alert['message']) ?></textarea>

      <button type="submit">✅ Modifier l'alerte</button>
    </form>
  <?php else: ?>
    <form method="POST">
      <input type="hidden" name="action" value="ajouter">
      <input type="hidden" name="type" value="<?= htmlspecialchars($typeChoisi) ?>">

      <label>Type d'alerte</label>
      <input type="text" value="<?= htmlspecialchars($typeChoisi) ?>" readonly>

      <label>Localisation</label>
      <input type="text" name="location" id="location" required>

      <label>Message</label>
      <textarea name="message" required></textarea>

      <button type="submit">✅ Ajouter une alerte</button>
    </form>

    <script>
      if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
          const coords = `Lat: ${position.coords.latitude.toFixed(5)}, Long: ${position.coords.longitude.toFixed(5)}`;
          document.getElementById("location").value = coords;
        });
      }
    </script>
  <?php endif; ?>

  <?php if (!empty($_SESSION['alertes'])): ?>
    <table>
      <thead>
        <tr>
          <th>Type</th>
          <th>Localisation</th>
          <th>Message</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($_SESSION['alertes'] as $id => $alert): ?>
          <tr>
            <td><?= htmlspecialchars($alert['type']) ?></td>
            <td><?= htmlspecialchars($alert['location']) ?></td>
            <td><?= htmlspecialchars($alert['message']) ?></td>
            <td class="action-buttons">
              <a href="?edit=<?= $id ?>"><button type="button" class="edit-btn">✏️</button></a>
              <form method="POST" onsubmit="return confirm('Supprimer cette alerte ?')">
                <input type="hidden" name="action" value="supprimer">
                <input type="hidden" name="id" value="<?= $id ?>">
                <button type="submit" class="delete-btn">🗑️</button>
              </form>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php endif; ?>
</div>

</body>
</html>
