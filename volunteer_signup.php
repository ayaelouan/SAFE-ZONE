<?php
// Connexion sécurisée à la base de données
try {
    $pdo = new PDO('mysql:host=localhost;dbname=safezone_db;charset=utf8', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

// Traitement du formulaire
$message = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Nettoyage des entrées
    $nom = trim($_POST['nom']);
    $email = trim($_POST['email']);
    $type = $_POST['type'];
    $ville = trim($_POST['ville']);

    if (!empty($nom) && !empty($email) && !empty($type) && !empty($ville)) {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            // Vérifie si l'email existe déjà
            $check = $pdo->prepare("SELECT id FROM volunteers WHERE email = ?");
            $check->execute([$email]);

            if ($check->rowCount() === 0) {
                // Insère les données
                $stmt = $pdo->prepare("INSERT INTO volunteers (nom, email, type, ville) VALUES (?, ?, ?, ?)");
                $stmt->execute([$nom, $email, $type, $ville]);

                // Redirection vers la page de bienvenue
                header("Location: welcome.php?nom=" . urlencode($nom));
                exit;
            } else {
                $message = "<p class='error'>❌ Cet email est déjà utilisé.</p>";
            }
        } else {
            $message = "<p class='error'>❌ Email invalide.</p>";
        }
    } else {
        $message = "<p class='error'>⚠️ Tous les champs sont obligatoires.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Inscription Volontaire - SafeZone</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
  body {
    background: linear-gradient(to right, #0d1b2a, #42002b); /* plus de rose foncé */
    font-family: 'Cairo', sans-serif;
    color: white;
    margin: 0;
    padding: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    animation: backgroundFlow 10s ease infinite alternate;
  }

  .signup-box {
    background: rgba(255, 255, 255, 0.06);
    padding: 45px;
    border-radius: 25px;
    box-shadow: 0 0 50px #ff3399, 0 0 10px #00cfff;
    width: 420px;
    backdrop-filter: blur(12px);
    border: 1px solid rgba(255,255,255,0.15);
    animation: fadeIn 1.5s ease-in-out;
  }

  h2 {
    text-align: center;
    margin-bottom: 25px;
    color: #ff66cc;
    font-size: 30px;
    text-shadow: 0 0 15px #ff66cc, 0 0 20px #00d9ff;
  }

  label {
    display: block;
    margin-top: 18px;
    font-weight: bold;
    color: #ffaad4;
    text-shadow: 0 0 5px #ffaad4;
  }

  input, select {
    width: 100%;
    padding: 12px;
    border: none;
    border-radius: 10px;
    margin-top: 6px;
    background: rgba(255, 255, 255, 0.1);
    color: white;
    font-size: 15px;
    transition: 0.3s ease;
  }

  input:focus, select:focus {
    outline: none;
    background: rgba(255, 255, 255, 0.15);
    box-shadow: 0 0 10px #ff66cc;
  }

  button {
    margin-top: 25px;
    width: 100%;
    padding: 14px;
    background: linear-gradient(135deg, #ff66cc, #00d9ff);
    border: none;
    border-radius: 12px;
    font-size: 18px;
    font-weight: bold;
    color: white;
    cursor: pointer;
    transition: 0.4s ease;
    box-shadow: 0 0 25px #ff66cc;
  }

  button:hover {
    background: linear-gradient(135deg, #00d9ff, #ff66cc);
    box-shadow: 0 0 40px #ff66cc;
    transform: scale(1.05);
  }

  .error {
    color: #ff3333;
    text-align: center;
    margin-top: 12px;
    font-weight: bold;
    text-shadow: 0 0 10px #ff3333;
  }

  @keyframes fadeIn {
    from { opacity: 0; transform: translateY(-30px); }
    to { opacity: 1; transform: translateY(0); }
  }

  @keyframes backgroundFlow {
    0% { background-position: 0% 50%; }
    100% { background-position: 100% 50%; }
  }
</style>

</head>
<body>
  <div class="signup-box">
    <h2><i class="fas fa-user-plus"></i> Devenir Volontaire</h2>
    <?= $message ?>
    <form method="POST">
      <label>Nom complet</label>
      <input type="text" name="nom" required>

      <label>Email</label>
      <input type="email" name="email" required>

      <label>Type de volontariat</label>
      <select name="type" required>
        <option value="Médecin">Médecin</option>
        <option value="Psychologue">Psychologue</option>
        <option value="Agent de sécurité">Agent de sécurité</option>
        <option value="Secouriste">Secouriste</option>
        <option value="Bénévole">Bénévole</option>
      </select>

      <label>Ville</label>
      <input type="text" name="ville" required>

      <button type="submit"><i class="fas fa-check-circle"></i> S'inscrire</button>
    </form>
  </div>
</body>
</html>
