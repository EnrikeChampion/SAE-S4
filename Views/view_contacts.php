<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Page d'accueil - Application d'Annotation</title>
    <link rel="stylesheet" href="src/css/contacts.css">
</head>
<script>
document.addEventListener("DOMContentLoaded", function () {
    const input = document.querySelector('input[name="recherche"]');
    const contacts = document.querySelectorAll('.contact-item');

    input.addEventListener("input", function () {
        const search = input.value.toLowerCase();

        contacts.forEach(function (item) {
            const name = item.textContent.toLowerCase();
            if (name.includes(search)) {
                item.style.display = "";
            } else {
                item.style.display = "none";
            }
        });
    });
});
</script>

<body>
    <img src="src/images/Logoo.png" alt="Annotator Quest Logo" class="logo">
    <header>
        <h1>Messagerie Instantanée</h1>
        <p>Bienvenue,  <?php echo htmlspecialchars($_SESSION['username']); ?> 😍 !</p>
        <a href="?controller=chat&action=conditions" id="terms-button">🧾Conditions d'utilisation</a>
        <a href="?controller=chat&action=settings" class="btn btn-secondary">⚙️Paramètres</a>
        <a href="?controller=chat&action=logout" id="logout">🔓Déconnexion</a> <!-- Lien pour se déconnecter -->
        
    </header>
    <main>
        <script src="src\js\contacts.js"></script>
        <div class="contacts">
            
            <div class="search-bar">
                <input type="text" placeholder="Rechercher un contact..." name="recherche">
            </div>
            <ul class="contact-list">
                <?php echo $data['contacts']; ?>
                <!-- La liste des contacts sera insérée ici -->
                <?php if (empty($data['contacts'])): ?>
                    <li class="contact-item">Aucun contact trouvé.</li>
                <?php endif; ?>
            </ul>
            <ul class="contact-list" id="contact-list">

        </div>
    </main>
    
</body>

</html>