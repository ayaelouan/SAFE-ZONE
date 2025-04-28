<?php
// 🔧 Paramètres de connexion
$host = 'localhost';
$dbname = 'safezone_db';
$username = 'root';
$password = '';
$charset = 'utf8mb4';

// 🔌 Configuration du DSN (Data Source Name)
$dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";

// ⚙️ Options PDO
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Afficher les erreurs PDO
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];

try {
    // 🧠 Création de l'objet PDO global
    $pdo = new PDO($dsn, $username, $password, $options);
} catch (PDOException $e) {
    // ❌ Affichage de l'erreur si la connexion échoue
    die("Erreur de connexion à la base de données: " . $e->getMessage());
}
?>
