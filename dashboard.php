<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$username = $_SESSION['username'];
$email = $_SESSION['email'];
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Tableau de bord</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://use.fontawesome.com/releases/v6.5.1/css/all.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,700&display=swap" rel="stylesheet">
  <style>
    body {
      margin: 0;
      padding: 0;
      font-family: 'Poppins', sans-serif;
      background: radial-gradient(circle at top left, #1a1a1a, #000000);
      color: #fff;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      overflow: hidden;
    }

    .background {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: url('nebula.jpg') no-repeat center center fixed;
      background-size: cover;
      animation: nebula 30s linear infinite;
      filter: blur(8px);
      z-index: -1;
    }

    @keyframes nebula {
      0% { background-position: 0 0; }
      100% { background-position: 100% 100%; }
    }

    .dashboard-container {
      background: #111;
      border-radius: 20px;
      padding: 40px;
      box-shadow: 0 0 30px #ff2770aa;
      max-width: 500px;
      width: 100%;
      text-align: center;
      position: relative;
      overflow: hidden;
    }

    .dashboard-container::before {
      content: "";
      position: absolute;
      top: -50%;
      left: -50%;
      width: 200%;
      height: 200%;
      background: conic-gradient(from 0deg, #ff2770, transparent, #45f3ff, transparent, #ff2770);
      animation: rotate 6s linear infinite;
      z-index: 0;
      filter: blur(40px);
    }

    @keyframes rotate {
      0% { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
    }

    .form-content {
      position: relative;
      z-index: 1;
    }

    h2 {
      color: #45f3ff;
      margin-bottom: 20px;
      position: relative;
      z-index: 1;
    }

    .user-info {
      font-size: 1em;
      color: #ccc;
      margin-bottom: 30px;
      position: relative;
      z-index: 1;
    }

    .btn {
      display: inline-block;
      background-color: #45f3ff;
      color: #111;
      padding: 10px 25px;
      border: none;
      border-radius: 25px;
      cursor: pointer;
      font-size: 1em;
      margin: 10px 5px;
      transition: 0.3s ease-in-out;
      text-decoration: none;
    }

    .btn:hover {
      background-color: #1ad3d3;
      box-shadow: 0 0 15px #45f3ff, 0 0 30px #45f3ffaa;
    }

    .logout-btn {
      background-color: #ff2770;
      color: #fff;
    }

    .logout-btn:hover {
      background-color: #ff1a56;
      box-shadow: 0 0 15px #ff2770, 0 0 40px #ff2770aa;
    }
  </style>
</head>
<body>

<div class="background"></div>
<div class="dashboard-container">
  <h2>Bienvenue, <?php echo htmlspecialchars($username); ?> !</h2>
  <div class="user-info">
    <p>Tu es connecté avec : <strong><?php echo htmlspecialchars($email); ?></strong></p>
  </div>

  <div class="form-content">
    <a href="profil.php" class="btn"><i class="fas fa-user"></i> Voir Profil</a>
    <form action="index.php" method="POST" style="display:inline;">
      <button class="btn index-btn" type="submit"><i class="fas fa-sign-out-alt"></i> Commencer</button>
    </form>
  </div>
</div>

</body>
</html>
