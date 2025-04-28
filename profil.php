<?php

session_start();

$profileData = [
    'full_name' => 'Ahmed Benali',
    'email' => 'ahmed.benali@example.com',
    'phone' => '+212 6 12 34 56 78',
    'specialty' => 'Médecine d\'urgence',
    'location' => 'Casablanca, Maroc',
    'status' => 'Disponible',
    'certifications' => 'PSE1, PSE2, AFGSU',
    'member_since' => '15 Mars 2022',
    'interventions' => 24,
    'rating' => 8.9,
    'radius' => '3km'
];


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($_POST as $key => $value) {
        if (array_key_exists($key, $profileData)) {
            $profileData[$key] = htmlspecialchars(trim($value));
        }
    }
    
 
    $_SESSION['profile_data'] = $profileData;
 
    header('Location: '.$_SERVER['PHP_SELF']);
    exit;
}


if (isset($_SESSION['profile_data'])) {
    $profileData = array_merge($profileData, $_SESSION['profile_data']);
}

function displayField($fieldName, $label, $value, $isEditable = false) {
    if ($isEditable) {
        return '<div class="info-item">
            <div class="info-label">'.$label.'</div>
            <input type="text" name="'.$fieldName.'" value="'.$value.'" class="info-value" style="width: 100%; padding: 8px 12px; border: 1px solid #ddd; border-radius: 5px;">
        </div>';
    } else {
        $style = ($fieldName === 'status') ? 'style="color: var(--accent-red); font-weight: bold;"' : '';
        return '<div class="info-item">
            <div class="info-label">'.$label.'</div>
            <div class="info-value" '.$style.'>'.$value.'</div>
        </div>';
    }
}


$editMode = isset($_GET['edit']) && $_GET['edit'] === 'true';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Utilisateur - Emergency Response</title>
    <style>
        :root {
            --primary-blue: #1a73e8;
            --dark-blue: #0d47a1;
            --light-blue: #e8f0fe;
            --accent-red: #e53935;
            --dark-red: #b71c1c;
            --text-dark: #202124;
            --text-light: #f8f9fa;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background: linear-gradient(135deg, var(--light-blue), #ffffff);
            min-height: 100vh;
            color: var(--text-dark);
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        
        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 0;
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
        }
        
        .logo {
            font-size: 24px;
            font-weight: bold;
            color: var(--primary-blue);
        }
        
        .logo span {
            color: var(--accent-red);
        }
        
        nav ul {
            display: flex;
            list-style: none;
        }
        
        nav ul li {
            margin-left: 20px;
        }
        
        nav ul li a {
            text-decoration: none;
            color: var(--text-dark);
            font-weight: 500;
            transition: color 0.3s;
        }
        
        nav ul li a:hover {
            color: var(--primary-blue);
        }
        
        .profile-container {
            display: flex;
            gap: 30px;
            animation: fadeIn 0.8s ease-out;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .profile-sidebar {
            width: 300px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            padding: 25px;
            position: relative;
            overflow: hidden;
        }
        
        .profile-sidebar::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 8px;
            background: linear-gradient(90deg, var(--primary-blue), var(--accent-red));
        }
        
        .profile-picture {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid var(--light-blue);
            display: block;
            margin: 0 auto 20px;
            transition: transform 0.3s;
        }
        
        .profile-picture:hover {
            transform: scale(1.05);
        }
        
        .profile-name {
            text-align: center;
            font-size: 22px;
            margin-bottom: 5px;
            color: var(--primary-blue);
        }
        
        .profile-role {
            text-align: center;
            color: var(--accent-red);
            font-weight: 600;
            margin-bottom: 20px;
            font-size: 16px;
        }
        
        .profile-stats {
            display: flex;
            justify-content: space-around;
            margin: 25px 0;
        }
        
        .stat-item {
            text-align: center;
        }
        
        .stat-number {
            font-size: 24px;
            font-weight: bold;
            color: var(--primary-blue);
        }
        
        .stat-label {
            font-size: 12px;
            color: #666;
        }
        
        .profile-menu {
            list-style: none;
            margin-top: 30px;
        }
        
        .profile-menu li {
            margin-bottom: 15px;
        }
        
        .profile-menu a {
            display: flex;
            align-items: center;
            text-decoration: none;
            color: var(--text-dark);
            padding: 10px;
            border-radius: 5px;
            transition: all 0.3s;
        }
        
        .profile-menu a:hover, .profile-menu a.active {
            background-color: var(--light-blue);
            color: var(--primary-blue);
        }
        
        .profile-menu i {
            margin-right: 10px;
            font-size: 18px;
        }
        
        .profile-content {
            flex: 1;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            padding: 30px;
            animation: slideIn 0.8s ease-out;
        }
        
        @keyframes slideIn {
            from { opacity: 0; transform: translateX(20px); }
            to { opacity: 1; transform: translateX(0); }
        }
        
        .section-title {
            font-size: 22px;
            margin-bottom: 20px;
            color: var(--primary-blue);
            position: relative;
            padding-bottom: 10px;
        }
        
        .section-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 50px;
            height: 3px;
            background: linear-gradient(90deg, var(--primary-blue), var(--accent-red));
        }
        
        .profile-info {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }
        
        .info-item {
            margin-bottom: 15px;
        }
        
        .info-label {
            font-size: 14px;
            color: #666;
            margin-bottom: 5px;
        }
        
        .info-value {
            font-size: 16px;
            font-weight: 500;
            padding: 8px 12px;
            background-color: var(--light-blue);
            border-radius: 5px;
            border-left: 3px solid var(--primary-blue);
        }
        
        .emergency-card {
            background: linear-gradient(135deg, var(--dark-blue), var(--primary-blue));
            color: white;
            padding: 20px;
            border-radius: 10px;
            margin-top: 30px;
            position: relative;
            overflow: hidden;
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0% { box-shadow: 0 0 0 0 rgba(230, 57, 53, 0.4); }
            70% { box-shadow: 0 0 0 15px rgba(230, 57, 53, 0); }
            100% { box-shadow: 0 0 0 0 rgba(230, 57, 53, 0); }
        }
        
        .emergency-card h3 {
            margin-bottom: 15px;
            font-size: 20px;
        }
        
        .emergency-card p {
            margin-bottom: 20px;
            opacity: 0.9;
        }
        
        .btn {
            display: inline-block;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s;
            border: none;
            cursor: pointer;
        }
        
        .btn-primary {
            background-color: var(--primary-blue);
            color: white;
        }
        
        .btn-primary:hover {
            background-color: var(--dark-blue);
            transform: translateY(-2px);
        }
        
        .btn-danger {
            background-color: var(--accent-red);
            color: white;
        }
        
        .btn-danger:hover {
            background-color: var(--dark-red);
            transform: translateY(-2px);
        }
        
        .btn-outline {
            background-color: transparent;
            border: 1px solid var(--primary-blue);
            color: var(--primary-blue);
        }
        
        .btn-outline:hover {
            background-color: var(--light-blue);
        }
        
        .edit-btn {
            position: absolute;
            top: 20px;
            right: 20px;
            background-color: var(--light-blue);
            color: var(--primary-blue);
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .edit-btn:hover {
            background-color: var(--primary-blue);
            color: white;
            transform: rotate(15deg);
        }
        
        footer {
            text-align: center;
            margin-top: 50px;
            padding: 20px 0;
            color: #666;
            font-size: 14px;
        }
        
        @media (max-width: 768px) {
            .profile-container {
                flex-direction: column;
            }
            
            .profile-sidebar {
                width: 100%;
            }
            
            .profile-info {
                grid-template-columns: 1fr;
            }
        }
        
       
        .form-actions {
            margin-top: 20px;
            display: flex;
            gap: 10px;
            justify-content: flex-end;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="container">
        <header>
            <div class="logo">Emergency<span>Response</span></div>
            <nav>
                <ul>
                    <li><a href="index.php"><i class="fas fa-home"></i> Accueil</a></li>
                    <li><a href="select-type.php"><i class="fas fa-bell"></i> Alertes</a></li>
                  
                    
                    <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Déconnexion</a></li>
                </ul>
            </nav>
        </header>
        
        <div class="profile-container">
            <div class="profile-sidebar">
                <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Profile Picture" class="profile-picture">
                <h2 class="profile-name"><?php echo htmlspecialchars($profileData['full_name']); ?></h2>
                <p class="profile-role">Médecin - Urgentiste</p>
                
                <div class="profile-stats">
                    <div class="stat-item">
                        <div class="stat-number"><?php echo htmlspecialchars($profileData['interventions']); ?></div>
                        <div class="stat-label">Interventions</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number"><?php echo htmlspecialchars($profileData['rating']); ?></div>
                        <div class="stat-label">Évaluation</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number"><?php echo htmlspecialchars($profileData['radius']); ?></div>
                        <div class="stat-label">Rayon</div>
                    </div>
                </div>
                
                <ul class="profile-menu">
                    <li><a href="#" class="active"><i class="fas fa-user"></i> Mon Profil</a></li>
                    <li><a href="<?php echo $editMode ? '?' : '?edit=true'; ?>">
                        <i class="fas fa-<?php echo $editMode ? 'times' : 'pencil-alt'; ?>"></i> 
                        <?php echo $editMode ? 'Annuler' : 'Modifier Profil'; ?>
                    </a></li>
                </ul>
            </div>
            
            <div class="profile-content">
                <form method="POST" action="">
                    <h2 class="section-title">Informations Personnelles</h2>
                    
                    <div class="profile-info">
                        <?php 
                        echo displayField('full_name', 'Nom Complet', $profileData['full_name'], $editMode);
                        echo displayField('email', 'Email', $profileData['email'], $editMode);
                        echo displayField('phone', 'Téléphone', $profileData['phone'], $editMode);
                        echo displayField('specialty', 'Spécialité', $profileData['specialty'], $editMode);
                        echo displayField('location', 'Localisation', $profileData['location'], $editMode);
                        
                       
                        if (!$editMode) {
                            echo displayField('status', 'Statut', $profileData['status']);
                        } else {
                            echo '<div class="info-item">
                                <div class="info-label">Statut</div>
                                <select name="status" class="info-value" style="width: 100%; padding: 8px 12px; border: 1px solid #ddd; border-radius: 5px;">
                                    <option value="Disponible" '.($profileData['status'] === 'Disponible' ? 'selected' : '').'>Disponible</option>
                                    <option value="Occupé" '.($profileData['status'] === 'Occupé' ? 'selected' : '').'>Occupé</option>
                                </select>
                            </div>';
                        }
                        
                        echo displayField('certifications', 'Certifications', $profileData['certifications'], $editMode);
                        echo displayField('member_since', 'Membre depuis', $profileData['member_since']);
                        ?>
                    </div>
                    
                    <?php if ($editMode): ?>
                    <div class="form-actions">
                        <button type="button" class="btn btn-outline" onclick="window.location.href='?'">Annuler</button>
                        <button type="submit" class="btn btn-primary">Enregistrer</button>
                    </div>
                    <?php endif; ?>
                </form>
                
                <div class="emergency-card">
                    <h3><i class="fas fa-bell"></i> Mode Urgence</h3>
                    <p>Activez ce mode pour être notifié immédiatement des situations critiques dans votre zone.</p>
                    <div class="btn-group">
                        <a href="select-type.pjp" class="btn btn-danger" id="emergencyBtn"><i class="fas fa-bolt"></i> Activer Urgence</a>
                       
                    </div>
                </div>
                
                    </body>
                    </html>