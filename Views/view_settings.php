<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Paramètres</title>
    <link rel="stylesheet" href="src/css/settings.css">
    <link rel="stylesheet" href="src/css/contacts.css"> <!-- pour les polices Poppins -->
</head>
<body>
    <div class="settings-container">
        <h1>⚙️ Paramètres du profil</h1>

        <img src="uploads/<?= htmlspecialchars($_SESSION['profile_picture'] ?? 'default.png') ?>" alt="">

        <form method="POST" action="?controller=chat&action=save_settings" enctype="multipart/form-data">
            <label>Nom d'utilisateur :
                <input type="text" name="username" value="<?= htmlspecialchars($_SESSION['username']) ?>" required>
            </label>

            <label>Changer de photo :
                <input type="file" name="profile_picture" accept="image/*">
            </label>

            <input type="submit" value="Enregistrer les modifications">
        </form>

        <a href="?controller=chat">← Retour</a>
    </div>
    <script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('form');
    const inputUsername = form.querySelector('input[name="username"]');
    const oldUsername = "<?= htmlspecialchars($_SESSION['username']) ?>";

    form.addEventListener('submit', function (e) {
        const newUsername = inputUsername.value.trim();

        if (newUsername && newUsername !== oldUsername) {
            const confirmChange = confirm(
                `⚠️ Vous allez changer votre nom d'utilisateur de "${oldUsername}" à "${newUsername}".\nSouhaitez-vous continuer ?`
            );
            if (!confirmChange) {
                e.preventDefault(); // stop l'envoi du formulaire
            }
        }
    });
});
</script>

</body>
</html>
