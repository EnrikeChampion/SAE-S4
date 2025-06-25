<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Utilisateur</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="src/css/profile.css?v=<?php echo time(); ?>">
</head>
<body>
<div class="profile-bg">
    <div class="profile-container">
        <div class="profile-sidebar">
            <img src="https://img.icons8.com/bubbles/100/000000/user.png" class="profile-avatar" alt="User-Profile-Image">
            <h2 class="profile-name"><?=$username?></h2>
            <div class="profile-info-title">Informations</div>
            <a href="?controller=chat" class="profile-back-btn">
                <i class="fas fa-arrow-left"></i> Retour au chat
            </a>
        </div>
        <div class="profile-content">
            <div class="profile-row">
                <div class="profile-label">Prénom</div>
                <div class="profile-value"><?=$username?></div>
            </div>
            <div class="profile-row">
                <div class="profile-label">Email</div>
                <div class="profile-value"><?=$mail?></div>
            </div>
        </div>
    </div>
</div>
</body>
</html>