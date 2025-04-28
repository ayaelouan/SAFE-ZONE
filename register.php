<?php
 
    $username_err = $email_err = $password_err = $phone_err = $signup_err = $signup_success = "";
    $username = $email = $password = $phone = "";


try {
    $conn = new PDO("mysql:host=localhost;dbname=safezone_db", "root", "");

    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}   catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);
    $phone = trim($_POST["phone"]);

    if (empty($username)) {
        $username_err = "Veuillez entrer un nom d'utilisateur.";
    }
    if (empty($email)) {
        $email_err = "Veuillez entrer un email.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $email_err = "L'email n'est pas valide.";
    }
    if (empty($password)) {
        $password_err = "Veuillez entrer un mot de passe.";
    }
    if (empty($phone)) {
        $phone_err = "Veuillez entrer un numéro de téléphone.";
    } elseif (!preg_match("/^[0-9]{10}$/", $phone)) {
        $phone_err = "Le numéro de téléphone doit comporter 10 chiffres.";
    }
    if (empty($username_err) && empty($email_err) && empty($password_err) && empty($phone_err)) {
        $sql = "SELECT id FROM users WHERE email = :email";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);

        try {
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                $signup_err = "Un compte avec cet email existe déjà.";
            } else {
                $password_hash = password_hash($password, PASSWORD_DEFAULT);
                $sql = "INSERT INTO users (username, email, password, phone) VALUES (:username, :email, :password, :phone)";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':username', $username, PDO::PARAM_STR);
                $stmt->bindParam(':email', $email, PDO::PARAM_STR);
                $stmt->bindParam(':password', $password_hash, PDO::PARAM_STR);
                $stmt->bindParam(':phone', $phone, PDO::PARAM_STR);
                try {
                    $stmt->execute();
                    $signup_success = "Inscription réussie ! Vous pouvez maintenant vous connecter.";
                } catch (PDOException $e) {
                    $signup_err = "Une erreur est survenue lors de l'insertion dans la base de données : " . $e->getMessage();
                }
            }
        } catch (PDOException $e) {
            $signup_err = "Erreur lors de la vérification de l'email: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Inscription</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://use.fontawesome.com/releases/v6.5.1/css/all.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,500,600,700,800,900&display=swap" rel="stylesheet">
  <style>
    /* Styles de base */
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
      z-index: 2;
    }

    h2 {
      text-align: center;
      margin-bottom: 20px;
      color: #45f3ff;
    }

    input[type="text"],
    input[type="email"],
    input[type="password"],
    input[type="submit"],
    input[type="tel"] {
      width: 100%;
      padding: 12px 20px;
      margin-bottom: 15px;
      border: none;
      border-radius: 25px;
      font-size: 1em;
      box-sizing: border-box;
    }

    input[type="text"],
    input[type="email"],
    input[type="password"],
    input[type="tel"] {
      background: #222;
      color: #fff;
      border: 2px solid #555;
      transition: 0.3s;
    }

    input[type="text"]:focus,
    input[type="email"]:focus,
    input[type="password"]:focus,
    input[type="tel"]:focus {
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

    small,
    .error {
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
  </style>
</head>
<body>
  <div class="background"></div>
  <div class="container">
    <div class="form-content">
      <h2>Inscription</h2>

      <!-- Affichage des messages d'erreur et de succès -->
      <?php if (!empty($signup_err)) echo "<div class='error'>$signup_err</div>"; ?>
      <?php if (!empty($signup_success)) echo "<div class='success-msg'>$signup_success</div>"; ?>

      <!-- Formulaire d'inscription -->
      <form action="register.php" method="post">
          <label for="username">Nom d'utilisateur</label>
          <input type="text" id="username" name="username" value="<?= htmlspecialchars($username); ?>" required>
          <div class="error"><?= $username_err; ?></div>

          <label for="email">Email</label>
          <input type="email" id="email" name="email" value="<?= htmlspecialchars($email); ?>" required>
          <div class="error"><?= $email_err; ?></div>

          <label for="password">Mot de passe</label>
          <input type="password" id="password" name="password" required>
          <div class="error"><?= $password_err; ?></div>

          <label for="phone">Numéro de téléphone</label>
          <input type="tel" id="phone" name="phone" value="<?= htmlspecialchars($phone); ?>" required>
          <div class="error"><?= $phone_err; ?></div>

          <input type="submit" value="S'inscrire">
      </form>

      <div class="group">
        <a href="login.php">Déjà inscrit ? Connectez-vous ici.</a>
      </div>
    </div>
  </div>
</body>
</html>














