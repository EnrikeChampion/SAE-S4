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
            $firstname = $_POST['first_name'];
            $lastname = $_POST['last_name'];
            $mail = $_POST['mail'];
            $password = $_POST['password'];
            $hash = password_hash($password, PASSWORD_BCRYPT); // Utilisation de sha1 pour le hashage du mot de passe

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
            $request = $this->db->prepare("INSERT INTO users (prenom, nom,  email, password) VALUES (?, ?, ?, ?)");
            $request->execute([$firstname, $lastname, $mail, $hash]);
    }

    public function login_user(){
        // Récupération des données du formulaire
        $mail = $_POST['mail'];
        $password = $_POST['password'];

        // Récupérer le hachage stocké pour cet email
        $tmp = $this->db->prepare("SELECT user_id, prenom, password FROM users WHERE email = ?");
        $tmp->execute([$mail]);
        $user = $tmp->fetch(PDO::FETCH_ASSOC);

        // Vérifier si l'utilisateur existe
        if ($user) {
            // Vérifier le mot de passe avec password_verify()
            if (password_verify($password, $user['password'])) {
                // Mot de passe correct : démarrer une session
                $_SESSION['mail'] = $mail;
                $_SESSION['id'] = $user['user_id'];
                $_SESSION['first_name'] = $user['prenom'];
            } else {
                // Mot de passe incorrect
                $data = ["message" => "Mauvais identifiant ou mot de passe"];
                return $data;
            }
        } else {
            // Utilisateur non trouvé
            $data = ["message" => "Mauvais identifiant ou mot de passe"];
            return $data;
        }
    }

    public function get_contacts()
    {
        $tmp = "SELECT user_id,prenom, email FROM users";
        $request = $this->db->query($tmp);

        // Récupérer tous les résultats sous forme de tableau associatif
        $users = $request->fetchAll(PDO::FETCH_ASSOC);
        $contacts = '';
        foreach ($users as $user) {
            $contacts .= '<li class="contact-item"><div class="contact-info"><div class="contact-name">' . htmlspecialchars($user['prenom'])
                        . '<a href="?controller=chat&action=profile&user_id=' . strval($user['user_id'])
                        . '"> Voir son profil </a></div><div class="last-message"><a href="?controller=chat&action=chat&uid=' . strval($_SESSION['id'])
                        . '&id=' . strval($user['user_id']) . '" id="message"> Cliquer ici pour continuer la discussion...</a></div></div></li>';
        }
        $data = ["contacts" => $contacts];
        return $data;
    }

    public function get_user_profile($user_id)
    {
        if (isset($_GET['user_id'])) {
            $userId = intval($_GET['user_id']);
            $tmp = "SELECT user_id, prenom, nom, email FROM users WHERE user_id = ?";
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
                "first_name" => htmlspecialchars($user['prenom']),
                "last_name" => htmlspecialchars($user['nom']),
                "mail" => htmlspecialchars($user['email'])
            ];
            return $data;
        } else {
            $data = ["message" => "ID utilisateur non spécifié."];
            return $data;
        }

    }
}
