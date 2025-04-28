<?php
require_once 'config.php';

$email = $new_password = $confirm_password = '';
$email_err = $new_password_err = $confirm_password_err = $reset_success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (empty(trim($_POST['email']))) {
        $email_err = "Veuillez entrer votre adresse email.";
    } else {
        $email = trim($_POST['email']);
    }

    if (empty(trim($_POST['new_password']))) {
        $new_password_err = "Veuillez entrer un nouveau mot de passe.";
    } elseif (strlen(trim($_POST['new_password'])) < 6) {
        $new_password_err = "Minimum 6 caractères.";
    } else {
        $new_password = trim($_POST['new_password']);
    }

    if (empty(trim($_POST['confirm_password']))) {
        $confirm_password_err = "Veuillez confirmer le mot de passe.";
    } else {
        $confirm_password = trim($_POST['confirm_password']);
        if ($new_password !== $confirm_password) {
            $confirm_password_err = "Les mots de passe ne correspondent pas.";
        }
    }

    if (empty($email_err) && empty($new_password_err) && empty($confirm_password_err)) {
        $sql = "UPDATE users SET password = :password WHERE email = :email";
        if ($stmt = $pdo->prepare($sql)) {
            $stmt->bindParam(":password", $param_password, PDO::PARAM_STR);
            $stmt->bindParam(":email", $param_email, PDO::PARAM_STR);
            $param_password = password_hash($new_password, PASSWORD_DEFAULT);
            $param_email = $email;

            if ($stmt->execute()) {
                $reset_success = "✅ Mot de passe mis à jour avec succès !";
            } else {
                $reset_success = "❌ Erreur de mise à jour.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Réinitialiser mot de passe</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://use.fontawesome.com/releases/v6.5.1/css/all.css" rel="stylesheet">
  <style>
    body {
      margin: 0;
      padding: 0;
      font-family: 'Segoe UI', sans-serif;
      background: radial-gradient(circle at top left, #1a1a1a, #000000);
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      overflow: hidden;
      color: #fff;
    }
    @keyframes nebula {
      0% { background-position: 0 0; }
      100% { background-position: 100% 100%; }
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

    .container {
      background: #111;
      border-radius: 20px;
      padding: 40px;
      box-shadow: 0 0 30px #ff2770aa;
      max-width: 400px;
      width: 100%;
      position: relative;
      overflow: hidden;
    }

    .container::before {
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
      text-align: center;
      margin-bottom: 20px;
      color: #45f3ff;
    }

    input[type="email"],
    input[type="password"],
    input[type="submit"] {
      width: 100%;
      padding: 12px 20px;
      margin-bottom: 15px;
      border: none;
      border-radius: 25px;
      font-size: 1em;
      box-sizing: border-box;
    }

    input[type="email"],
    input[type="password"] {
      background: #222;
      color: #fff;
      border: 2px solid #555;
      transition: 0.3s;
    }

    input[type="email"]:focus,
    input[type="password"]:focus {
      border-color: #45f3ff;
      outline: none;
    }

    input[type="submit"] {
      background: #45f3ff;
      color: #000;
      font-weight: bold;
      cursor: pointer;
      transition: 0.3s;
    }

    input[type="submit"]:hover {
      box-shadow: 0 0 15px #45f3ff, 0 0 40px #45f3ffaa;
    }

    small {
      color: #ff2770;
      font-size: 0.8em;
    }

    .success-msg {
      text-align: center;
      color: #45f3ff;
      margin-bottom: 15px;
      font-weight: bold;
    }

    .group {
      text-align: center;
      margin-top: 10px;
    }

    .group a {
      color: #888;
      text-decoration: none;
    }

    .group a:hover {
      color: #fff;
    }
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }

    @keyframes glow {
      0% { box-shadow: 0 0 10px #ff1a1a; }
      50% { box-shadow: 0 0 30px #ff4d4d; }
      100% { box-shadow: 0 0 10px #ff1a1a; }
    }
  </style>
</head>
<body>

<body>

<div class="background"></div> <!-- Le fond animé ajouté ici -->

<div class="container">
  <div class="form-content">
    <h2><i class="fas fa-unlock-alt"></i> Réinitialiser</h2>

    <?php if ($reset_success): ?>
      <p class="success-msg"><?= $reset_success ?></p>
    <?php endif; ?>

    <form method="post">
      <input type="email" name="email" placeholder="Adresse email" value="<?= htmlspecialchars($email) ?>">
      <?php if ($email_err): ?><small><?= $email_err ?></small><?php endif; ?>

      <input type="password" name="new_password" placeholder="Nouveau mot de passe">
      <?php if ($new_password_err): ?><small><?= $new_password_err ?></small><?php endif; ?>

      <input type="password" name="confirm_password" placeholder="Confirmer le mot de passe">
      <?php if ($confirm_password_err): ?><small><?= $confirm_password_err ?></small><?php endif; ?>

      <input type="submit" value="Réinitialiser">
    </form>

    <div class="group">
      <a href="login.php"><i class="fas fa-arrow-left"></i> Retour à la connexion</a>
    </div>
  </div>
</div>

</body>

</body>
</html>
