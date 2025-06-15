<?php

abstract class Controller {
    public function __construct() {
        if (isset($_GET['action']) && method_exists($this, "action_" . $_GET['action'])) {
            $action = "action_" . $_GET['action'];
            $this->$action();
        } else {
            $this->action_default();
        }
    }

    abstract public function action_default();

    protected function render($vue, $data = []) {
        extract($data);

        $file_name = "Views/view_" . $vue . '.php';
        if (file_exists($file_name)) {
            include $file_name;
        } else {
            $this->action_error("La vue n'existe pas !");
        }
        exit;
    }

    protected function action_error($message = '') {
        $file_name = "Views/view_message.php";
        if (file_exists($file_name)) {
            $data = ['title' => "Erreur", 'message' => $message ?: "Une erreur est survenue."];
            $this->render("message", $data);
        } else {
            echo $message ?: "Une erreur est survenue.";
        }
        exit;
    }
}