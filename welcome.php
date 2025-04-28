<?php
$nom = isset($_GET['nom']) ? htmlspecialchars($_GET['nom']) : 'Volontaire';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Bienvenue - SafeZone</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
  body {
    background: linear-gradient(to right, #1a1a1a, #ff007f); 
    font-family: 'Cairo', sans-serif;
    color: white;
    margin: 0;
    padding: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
  }

  .signup-box {
    background: rgba(255, 255, 255, 0.05);
    padding: 40px;
    border-radius: 20px;
    box-shadow: 0 0 30px #ff007f; 
    width: 400px;
    backdrop-filter: blur(8px);
  }

  h2 {
    text-align: center;
    margin-bottom: 20px;
    color: #ff007f;
    text-shadow: 0 0 20px #ff007f, 0 0 30px #ff66b2; 
  }

  label {
    display: block;
    margin-top: 15px;
    font-weight: bold;
    color: #ff66b2; 
  }

  input, select {
    width: 100%;
    padding: 10px;
    border: none;
    border-radius: 8px;
    margin-top: 5px;
    background: rgba(255,255,255,0.1); 
    color: white;
    border: 1px solid rgba(255, 255, 255, 0.2);
  }

  button {
    margin-top: 20px;
    width: 100%;
    padding: 12px;
    background: #ff007f; 
    border: none;
    border-radius: 10px;
    font-size: 16px;
    color: white;
    cursor: pointer;
    transition: 0.3s;
    box-shadow: 0 0 20px #ff007f; 
  }

  button:hover {
    background: #ff66b2; 
    box-shadow: 0 0 30px #ff66b2;
  }

  .error {
    color: #ff3366;
    text-align: center;
    margin-top: 10px;
    font-weight: bold;
  }
</style>

</head>
<body>

  <div class="welcome-box">
    <h1><i class="fas fa-heart"></i> Bienvenue, <?= $nom ?> !</h1>
    <p>Merci de rejoindre la communauté SafeZone 💪<br>Votre engagement peut sauver des vies ❤️</p>
    <form action="index.php">
      <button class="back-btn"><i class="fas fa-arrow-left"></i> Retour</button>
    </form>
  </div>

</body>
</html>
