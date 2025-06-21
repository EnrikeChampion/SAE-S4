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

    // Changer le nom
    if (!empty($_POST['username'])) {
        $new_username = trim($_POST['username']);
        $m->update_username($user_id, $new_username);
        $_SESSION['username'] = $new_username;
    }

    // Changer l'image
    if (!empty($_FILES['profile_picture']['name'])) {
        $file = $_FILES['profile_picture'];
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array($ext, $allowed)) {
            $filename = uniqid('profile_', true) . '.' . $ext;
            $upload_path = 'uploads/' . $filename;

            if (move_uploaded_file($file['tmp_name'], $upload_path)) {
                $m->update_user_picture($user_id, $filename);
                $_SESSION['profile_picture'] = $filename;
            }
        }
    }

    header('Location: ?controller=chat&action=settings');
    exit;
}


}
?>