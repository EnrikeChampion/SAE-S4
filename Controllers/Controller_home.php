<?php

require_once 'Controller.php';

class Controller_home extends Controller {
    public function action_default() {
        if (isset($_SESSION['mail'] ) && isset($_SESSION['id'])) {
            // Si l'utilisateur est déjà connecté, rediriger vers la page de chat
            header('Location: ?controller=chat');
        }
        $this->render("homepage", []);
    }

    public function action_register() {
        if (isset($_SESSION['mail'] ) && isset($_SESSION['id'])) {
            // Si l'utilisateur est déjà connecté, rediriger vers la page de chat
            header('Location: ?controller=chat');
        }
        if (isset($_POST['submit_registration'])) {
            $m = Model::getModel();
            $data = $m->create_new_account();
            if (isset($data['message'])) {
                $this->render("register", $data);
            } else {
                header('Location: ?controller=home&action=login'); // Redirection vers la page de connexion après l'inscription réussie
            }
        } else {
            $this->render("register", []);
        }
    }

    public function action_login() {
        if (isset($_SESSION['mail'] ) && isset($_SESSION['id'])) {
            // Si l'utilisateur est déjà connecté, rediriger vers la page de chat
            header('Location: ?controller=chat');
        }
        if (isset($_POST['submit_login'])) {
            $m = Model::getModel();
            $data = $m->login_user();
            if (isset($data['message'])) {
                $this->render("login", $data);
            } else {
                header('Location: ?controller=account'); // Redirection vers la page de chat après une connexion réussie
            }
        } else {
            $this->render("login", []);
        }
    }
}
?>