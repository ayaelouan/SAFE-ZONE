<?php
session_start();

$login_err = "";
$email = "";
$email_err = "";
$password_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $pdo = new PDO("mysql:host=localhost;dbname=safezone_db;charset=utf8", "root", "", [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);

        $email = trim($_POST["email"]);
        $password = trim($_POST["password"]);

        if (empty($email)) {
            $email_err = "Veuillez entrer un email.";
        }

        if (empty($password)) {
            $password_err = "Veuillez entrer un mot de passe.";
        }

        if (empty($email_err) && empty($password_err)) {
            $sql = "SELECT * FROM users WHERE email = :email";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(":email", $email, PDO::PARAM_STR);
            $stmt->execute();

            if ($stmt->rowCount() == 1) {
                $user = $stmt->fetch(PDO::FETCH_ASSOC);
                if (password_verify($password, $user["password"])) {
                    $_SESSION["user_id"] = $user["id"];
                    $_SESSION["username"] = $user["username"];
                    $_SESSION["email"] = $user["email"];
                    header("location: dashboard.php");
                    exit;
                } else {
                    $login_err = "Mot de passe incorrect.";
                }
            } else {
                $login_err = "Aucun compte trouvé avec cet email.";
            }
        }
    } catch (PDOException $e) {
        die("Erreur de connexion : " . $e->getMessage());
    }
}
?>


<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Connexion</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://use.fontawesome.com/releases/v6.5.1/css/all.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,500,600,700,800,900&display=swap" rel="stylesheet">
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
      <h2>Connexion</h2>

      <?php if (!empty($login_err)) echo "<div class='error'>$login_err</div>"; ?>

      <form action="login.php" method="post">
          <label for="email">Email</label>
          <input type="email" id="email" name="email" value="<?= htmlspecialchars($email); ?>">
          <div class="error"><?= $email_err; ?></div>

          <label for="password">Mot de passe</label>
          <input type="password" id="password" name="password">
          <div class="error"><?= $password_err; ?></div>

          <input type="submit" value="Se connecter">
      </form>

      <div class="group">
        <a href="reset_password.php">Mot de passe oublié ?</a>
      </div>
      <div class="group mt-3">
        <a href="register.php"><i class="fas fa-user-plus"></i> Créer un compte</a>
      </div>
    </div>
  </div>
</body>
</html>
