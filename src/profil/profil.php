<?php
session_start();

// Connexion à la base de données
require_once '../connexion.php';

if (isset($_GET['user_id'])) {
    $userId = intval($_GET['user_id']);

    $sql = "SELECT user_id, prenom, nom, email FROM users WHERE user_id = ?";
    $stmt = $bdd->prepare($sql);
    $stmt->execute([$userId]);

    // Récupérer les données de l'utilisateur
    $users = $stmt->fetch(PDO::FETCH_ASSOC);

    // Vérifier si l'utilisateur existe
    if (!$users) {
        echo "Utilisateur non trouvé.";
        exit();
    }
} else {
    echo "ID utilisateur non spécifié.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Utilisateur</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }

        .page-content {
            padding: 20px;
        }

        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .bg-c-lite-green {
            background: linear-gradient(135deg, #128C7E, #25D366);
        }

        .user-profile {
            padding: 20px;
            text-align: center;
            color: white;
        }

        .user-profile img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            border: 3px solid white;
        }

        .user-profile h6 {
            margin-top: 10px;
            font-size: 1.2rem;
            font-weight: 600;
        }

        .card-block {
            padding: 20px;
        }

        .card-block .row {
            margin-bottom: 15px;
        }

        .card-block p {
            margin: 0;
            font-weight: 600;
            color: #333;
        }

        .card-block h6 {
            margin: 0;
            font-size: 1rem;
            color: #666;
        }

        .social-link {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-top: 20px;
        }

        .social-link a {
            color: #128C7E;
            font-size: 1.5rem;
            transition: color 0.3s ease;
        }

        .social-link a:hover {
            color: #25D366;
        }
        /* From Uiverse.io by satyamchaudharydev */ 
button {
    --primary-color:rgb(147, 147, 158);
    --secondary-color: #fff;
    --hover-color: #111;
    --arrow-width: 10px;
    --arrow-stroke: 2px;
    box-sizing: border-box;
    border: 0;
    border-radius: 20px;
    color: var(--secondary-color);
    padding: 1em 1.8em;
    background: var(--primary-color);
    display: flex;
    transition: 0.2s background;
    align-items: center;
    gap: 0.6em;
    font-weight: bold;
  }
  
  button .arrow-wrapper {
    display: flex;
    justify-content: center;
    align-items: center;
  }
  
  button .arrow {
    margin-top: 1px;
    width: var(--arrow-width);
    background: var(--primary-color);
    height: var(--arrow-stroke);
    position: relative;
    transition: 0.2s;
  }
  
  button .arrow::before {
    content: "";
    box-sizing: border-box;
    position: absolute;
    border: solid var(--secondary-color);
    border-width: 0 var(--arrow-stroke) var(--arrow-stroke) 0;
    display: inline-block;
    top: -3px;
    right: 3px;
    transition: 0.2s;
    padding: 3px;
    transform: rotate(126deg);
  }
  
  button:hover {
    background-color: var(--hover-color);
  }
  
  button:hover .arrow {
    background: var(--secondary-color);
  }
  
  button:hover .arrow:before {
    left: 0;
  }
  #retour{ text-decoration: none;}
    </style>
</head>
<body>
<div class="page-content page-container" id="page-content">
    <div class="padding">
        <div class="row container d-flex justify-content-center">
            <div class="col-xl-6 col-md-12">
                <div class="card user-card-full">
                    <div class="row m-l-0 m-r-0">
                        <div class="col-sm-4 bg-c-lite-green user-profile" >
                   
<button >
    <a href="../chat.php"class="bg-c-lite-green" id="retour">Retour au chat</a>
    <div class="arrow-wrapper">
        <div class="arrow"></div>

    </div>
</button>
                            <div class="card-block text-center text-white">
                                <div class="m-b-25">
                                    <img src="https://img.icons8.com/bubbles/100/000000/user.png" class="img-radius" alt="User-Profile-Image">
                                </div>
                                <h6 class="f-w-600"> Informations</h6>
                            </div>
                        </div>
                        <div class="col-sm-8">
                            <div class="card-block">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <p class="m-b-10 f-w-600">Prénom</p>
                                        <h6 class="text-muted f-w-400"><?php echo htmlspecialchars($users['prenom']); ?></h6>
                                    </div>
                                    <div class="col-sm-6">
                                        <p class="m-b-10 f-w-600">Nom</p>
                                        <h6 class="text-muted f-w-400"><?php echo htmlspecialchars($users['nom']); ?></h6>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <p class="m-b-10 f-w-600">Email</p>
                                        <h6 class="text-muted f-w-400"><?php echo htmlspecialchars($users['email']); ?></h6>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>