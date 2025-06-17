<?php

class Model
{
    private $db;
    private static $instance = null;

    private function __construct()
    {
        include 'credentials.php';
        $this->db = new PDO($dsn, $login, $password);
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public static function getModel()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function create_new_account(){
        // Récupération et validation des données du formulaire
            $username = $_POST['username'];
            $mail = $_POST['mail'];
            $password = $_POST['password'];
            $hash = password_hash($password, PASSWORD_BCRYPT); // Utilisation de bcrypt pour le hashage du mot de passe

            // Vérification si tous les champs obligatoires sont remplis
            if (empty($mail) || empty($password)) {
                $data = ["message" => "Veuillez remplir tous les champs obligatoires."];
                return $data;
            } else {
                $tmp = $this->db->prepare("SELECT * FROM users WHERE email = ?");
                $tmp->execute([$mail]);
                $existing_user = $tmp->fetch();

                // Vérifier si un utilisateur avec cet email existe déjà
                if ($existing_user) {
                    $data = ["message" => "Cet utilisateur existe déjà."];
                    return $data;
                }
            }
            // Insertion du nouvel utilisateur
            $request = $this->db->prepare("INSERT INTO users (username, email, password_hash, created_at, last_online, is_online) VALUES (?, ?, ?, NOW(), NOW(), ?)");
            $request->execute([$username, $mail, $hash, true]);
    }

public function login_user(){
    // Récupération des données du formulaire
    $mail = $_POST['mail'];
    $password = $_POST['password'];

    // Récupérer le hachage stocké pour cet email
    $tmp = $this->db->prepare("SELECT user_id, username, password_hash FROM users WHERE email = ?");
    $tmp->execute([$mail]);
    $user = $tmp->fetch(PDO::FETCH_ASSOC);

    // Vérifier si l'utilisateur existe
    if ($user) {
        // Vérifier le mot de passe avec password_verify()
        if (password_verify($password, $user['password_hash'])) {
            // Mot de passe correct : démarrer une session
            $_SESSION['mail'] = $mail;
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['username'] = $user['username'];

            // Mettre à jour le statut en ligne dans la base (optionnel)
            $update = $this->db->prepare("UPDATE users SET is_online = TRUE, last_online = NOW() WHERE user_id = ?");
            $update->execute([$user['user_id']]);

            // Retourner les infos utiles si besoin
            return [
                'user_id' => $user['user_id'],
                'username' => $user['username'],
                'mail' => $mail
            ];
        } else {
            return ["message" => "Mauvais identifiant ou mot de passe"];
        }
    } else {
        return ["message" => "Mauvais identifiant ou mot de passe"];
    }
}

    public function logout_user($user_id) {
        // Préparation de la requête pour mettre à jour le statut de connexion
        $request = $this->db->prepare("UPDATE users SET is_online = FALSE, last_online = NOW() WHERE user_id = ?");
        $request->execute([$user_id]);
    }


    public function get_contacts()
    {
        $tmp = "SELECT user_id,username, email FROM users";
        $request = $this->db->query($tmp);

        // Récupérer tous les résultats sous forme de tableau associatif
        $users = $request->fetchAll(PDO::FETCH_ASSOC);
        $contacts = '';
        foreach ($users as $user) {
            $contacts .= '<li class="contact-item"><div class="contact-info"><div class="contact-name">' . htmlspecialchars($user['username'])
                        . '<a href="?controller=chat&action=profile&user_id=' . strval($user['user_id'])
                        . '"> Voir son profil </a></div><div class="last-message"><a href="?controller=chat&action=chat&uid=' . strval($_SESSION['user_id'])
                        . '&id=' . strval($user['user_id']) . '" id="message"> Cliquer ici pour continuer la discussion...</a></div></div></li>';
        }
        $data = ["contacts" => $contacts];
        return $data;
    }

    public function get_user_profile($user_id)
    {
        if (isset($_GET['user_id'])) {
            $userId = intval($_GET['user_id']);
            $tmp = "SELECT user_id, username, email FROM users WHERE user_id = ?";
            $request = $this->db->prepare($tmp);
            $request->execute([$userId]);

            // Récupérer les données de l'utilisateur
            $user = $request->fetch(PDO::FETCH_ASSOC);

            // Vérifier si l'utilisateur existe
            if (!$user) {
                $data = ["message" => "Utilisateur non trouvé."];
                return $data;
            }
            // Retourner les données de l'utilisateur
            $data = [
                "username" => htmlspecialchars($user['username']),
                "mail" => htmlspecialchars($user['email'])
            ];
            return $data;
        } else {
            $data = ["message" => "ID utilisateur non spécifié."];
            return $data;
        }

    }
}
