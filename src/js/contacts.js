let logout = document.getElementById('logout');

logout.addEventListener("click", function (event) {

    const confirmed = confirm("Êtes-vous sûr de vouloir vous déconnecter ?");
        if (!confirmed) {
            event.preventDefault(); // Annule la redirection si l'utilisateur annule
        }
});
