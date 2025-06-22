<?php

require_once 'Controller.php';

class Controller_home extends Controller {
    public function action_default() {
        if (isset($_SESSION['mail'] ) && isset($_SESSION['user_id'])) {
            // Si l'utilisateur est déjà connecté, rediriger vers la page de chat
            header('Location: ?controller=chat');
        }
        $this->render("homepage", []);
    }

    public function action_register() {
        if (isset($_SESSION['mail'] ) && isset($_SESSION['user_id'])) {
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
        if (isset($_SESSION['mail'] ) && isset($_SESSION['user_id'])) {
            // Si l'utilisateur est déjà connecté, rediriger vers la page de chat
            header('Location: ?controller=chat');
        }
        if (isset($_POST['submit_login'])) {
            $m = Model::getModel();
            $data = $m->login_user();
            if (isset($data['message'])) {
                $this->render("login", $data);
            } else {
                header('Location: ?controller=chat'); // Redirection vers la page de chat après une connexion réussie
            }
        } else {
            $this->render("login", []);
        }
    }

    public function action_forgot_password() {
        if (isset($_POST['submit_mail'])) {
            $m = Model::getModel();
            $data = $m->sendPasswordResetMail($_POST['mail']);
            if (isset($data['error'])) {
                $this->render("register", $data);
            } else {
                $this->render("login", $data);
            }
        } else {
            $this->render("forgot_password", []);
        }
    }

    public function action_reset() {
        if (isset($_GET['token'])) {
            $m = Model::getModel();
            // Vérification du token de réinitialisation
            $tok = $m->checkToken($_GET['token']);
            if (isset($tok['message'])) {
                $this->render("register", $tok);
            }
            
            if (isset($_POST['submit_reset'])) {
                $password = $_POST['password'] ?? '';
                if (empty($password)) {
                    $this->render("reset_password", ['message' => 'Le mot de passe ne peut pas être vide.']);
                } else {
                    $reset = $m->resetPassword($password, $_GET['token']);
                    if (isset($reset['success'])) {
                        header('Location: ?controller=home&action=login');
                    }
                    $this->render("reset_password", $reset);
                }
            }

            $this->render("reset_password", []);
        }

        $this->render("homepage", []);
    }
}
?>