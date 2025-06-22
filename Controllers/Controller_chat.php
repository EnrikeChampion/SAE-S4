<?php

require_once 'Controller.php';

class Controller_chat extends Controller {
    public function action_default() {
        // Vérifier si l'utilisateur est connecté
        if (!isset($_SESSION['mail']) || !isset($_SESSION['user_id'])) {
            // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
            header("Location: ?controller=home&action=login");
        } else {
            $m = Model::getModel();
            // Récupérer les contacts de l'utilisateur
            $data = $m->get_contacts();
            // Si l'utilisateur est connecté, afficher la page d'accueil
            $this->render("contacts", $data);
        }
    }

    public function action_logout() {

    if (isset($_SESSION['user_id'])) {
        // Mettre à jour le statut de l'utilisateur à OFFLINE dans la base
        $m = Model::getModel();
        $m->logout_user($_SESSION['user_id']);
    }

        // Réinitialiser les variables de session
        $_SESSION = [];
        session_unset();

        // Détruire la session pour déconnecter l'utilisateur
        session_destroy();

        // Rediriger vers la page de connexion
        header("Location: ?controller=home");
    }
    
    public function action_conditions() {
        $this->render("conditions", []);
    }

    public function action_profile() {
        $m = Model::getModel();
        $data = $m->get_user_profile($_GET['user_id'] ?? null);
        if (isset($data['message'])) {
            // Si un message d'erreur est retourné, afficher la page de profil avec le message
            $this->render("error", $data);
        } else {
            // Sinon, afficher la page de profil avec les données de l'utilisateur
            $this->render("profile", $data);
        }
    }

public function action_save_settings() {
    if (!isset($_SESSION['user_id'])) {
        header('Location: ?controller=home&action=login');
        exit;
    }

    $m = Model::getModel();
    $user_id = $_SESSION['user_id'];

    // Suppression du compte
    if (isset($_POST['delete-account'])) {
        $m->delete_user($user_id);
        // Les lignes suivantes ne seront pas exécutées car delete_user fait déjà un session_destroy() et une redirection
        exit;
    }

    // Changer le nom
    if (!empty($_POST['username'])) {
        $new_username = trim($_POST['username']);
        $m->update_username($user_id, $new_username);
        $_SESSION['username'] = $new_username;
    }

    // Changer le mot de passe
    if (!empty($_POST['password'])) {
        $new_password = $_POST['password'];
        $password_confirm = $_POST['password-confirm'] ?? '';
        if (
            preg_match('/^(?=.*[A-Z])(?=.*[\W_]).{8,}$/', $new_password) &&
            $new_password === $password_confirm
        ) {
            $m->update_user_password($user_id, $new_password);
        }
    }

    header('Location: ?controller=chat&action=settings');
    exit;
}

    public function action_chat() {
        $this->render("chat", []);

}
}
?>