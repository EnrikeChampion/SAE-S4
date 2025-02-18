<?php
// Démarrer la session
session_start();
require_once 'connexion.php';

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['email']) || !isset($_SESSION['id'])) {
    // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté

    header("Location: login.php");
    exit(); // Arrêter l'exécution du script
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Page d'accueil - Application d'Annotation</title>

    <style>
      /* Général */
body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #e9eff6;
    color: #333;
    background: #f0f0f0 url('../images/imh.webp') no-repeat center center !important;
}

/* En-tête */
header {
    background-color: #075E54;
    color: white;
    padding: 20px;
    text-align: center;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

header a {
    color: #fff;
    text-decoration: none;
    font-weight: bold;
    margin-left: 10px;
}

header a:hover {
    text-decoration: underline;
}

/* Contenu principal */
main {
    padding: 20px;
    max-width: 800px;
    margin: 20px auto;
}

/* Section contacts */
.contacts {
    background-color: white;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    overflow: hidden;
}

.search-bar {
    padding: 15px;
    background-color: #f8f9fa;
    border-bottom: 1px solid #ddd;
}

.search-bar input {
    width: 100%;
    padding: 12px;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 16px;
}

.contact-list {
    list-style-type: none;
    margin: 0;
    padding: 0;
}

.contact-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 15px;
    border-bottom: 1px solid #f0f2f5;
    transition: background-color 0.2s ease-in-out;
}

.contact-item:hover {
    background-color: #f7f9fc;
}

.contact-info {
    flex-grow: 1;
}

.contact-name {
    font-weight: bold;
    margin-bottom: 5px;
    color: #075E54;
}

.contact-name a {
    color: #128C7E;
    text-decoration: none;
    margin-left: 5px;
}

.contact-name a:hover {
    text-decoration: underline;
}

.last-message a {
    color: #007BFF;
    text-decoration: none;
}

.last-message a:hover {
    text-decoration: underline;
}

.timestamp {
    font-size: 0.85em;
    color: gray;
}

    </style>
</head>

<body>
    <header>
        <h1>Messagerie Instantanée</h1>
        <p>Bienvenue,  <?php echo htmlspecialchars($_SESSION['prenom']); ?> 😍 !</p>
        <a href="logout.php">Déconnexion</a> <!-- Lien pour se déconnecter -->
    </header>
    <main>
        <div class="contacts">
            
            <div class="search-bar">
                <input type="text" placeholder="Rechercher un contact..." name="recherche">
            </div>
            <ul class="contact-list">
                <?php $sql = "SELECT user_id,prenom, email FROM users";
                $requete = $bdd->query($sql);

                // Récupérer tous les résultats sous forme de tableau associatif
                $user = $requete->fetchAll(PDO::FETCH_ASSOC); ?>
                <?php foreach ($user as $usere): ?>
                    <li class="contact-item">
                        <div class="contact-info">
                            <div class="contact-name"><?php echo htmlspecialchars($usere['prenom']); ?> <a href="profil/profil.php?user_id=<?php echo $usere['user_id']; ?>"> Voir son profil </a></div>
                            <div class="last-message"><a href="message.php?uid=<?php echo $_SESSION['id']; ?>&id=<?php echo $usere['user_id'] ?>" id="message"> Cliquer ici pour continuer la discussion...</a></div>

                        </div>
                    </li>
                <?php endforeach;
                ?>
            </ul>
        </div>
    </main>
</body>

</html>