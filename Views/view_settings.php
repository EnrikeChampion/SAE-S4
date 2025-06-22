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
                <input type="text" name="username" value="<?= htmlspecialchars($_SESSION['username']) ?>">
            </label>

            <label>Changer le mot de passe :
                <input type="text" name="password" value="">
            </label>

            <label>Confirmer le nouveau mot de passe :
                <input type="text" name="password-confirm" value="">
            </label>

            <input type="submit" value="Enregistrer les modifications">

            <input type="submit" name="delete-account" value="Supprimer le compte" id="delete-account" onclick="return confirm('Êtes-vous sûr de vouloir supprimer votre compte ? Cette action est irréversible.');">

        </form>

        <a href="?controller=chat">← Retour</a>
    </div>
    <script>

    function showError(message) {
        const container = document.createElement('div');
        container.textContent = message;
        container.style.position = 'fixed';
        container.style.top = '20px';
        container.style.left = '50%';
        container.style.transform = 'translateX(-50%)';
        container.style.backgroundColor = '#ff4444';
        container.style.color = 'white';
        container.style.padding = '12px 24px';
        container.style.borderRadius = '8px';
        container.style.fontWeight = 'bold';
        container.style.boxShadow = '0 4px 8px rgba(0, 0, 0, 0.2)';
        container.style.zIndex = '9999';
        container.style.transition = 'opacity 0.5s ease';

        document.body.appendChild(container);

        setTimeout(() => {
            container.style.opacity = 0;
            setTimeout(() => container.remove(), 500);
        }, 3500);
    }
document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('form');
    const inputUsername = form.querySelector('input[name="username"]');
    const inputPassword = form.querySelector('input[name="password"]');
    const inputPasswordConfirm = form.querySelector('input[name="password-confirm"]');
    const oldUsername = "<?= htmlspecialchars($_SESSION['username']) ?>";

    form.addEventListener('submit', function (e) {
        const newUsername = inputUsername.value.trim();

        if (newUsername && newUsername !== oldUsername) {
            const confirmChange = confirm(
                `⚠️ Vous allez changer votre nom d'utilisateur de "${oldUsername}" à "${newUsername}".\nSouhaitez-vous continuer ?`
            );
            if (!confirmChange) {
                e.preventDefault();
                return;
            }
        }

        // Vérification du mot de passe si un nouveau est saisi
        const password = inputPassword.value;
        if (password.length > 0) {
            const passwordRegex = /^(?=.*[A-Z])(?=.*[\W_]).{8,}$/;
            if (!passwordRegex.test(password)) {
                e.preventDefault();
                showError("Le mot de passe doit contenir au moins 8 caractères, une majuscule et un caractère spécial.");
                return;
            }
            if (password !== inputPasswordConfirm.value) {
                e.preventDefault();
                showError("Les mots de passe ne correspondent pas.");
                return;
            }
        }
    });
});
</script>

</body>
</html>
