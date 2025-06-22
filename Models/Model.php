<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

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
       if (empty($username) || empty($mail) || empty($password)) {
        return ["message" => "<script>
            document.addEventListener('DOMContentLoaded', function() {
                showError('Veuillez remplir tous les champs obligatoires.');
            });
        </script>"];
    }
        
        // Vérification de la validité de l'email
        if (!preg_match('/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/', $mail)) {
            return $data["message"] = "";
        }
        // Vérification de la longueur du mot de passe et s'il contient au moins une lettre majuscule et un caractère spécial
        if (!preg_match('/^(?=.*[A-Z])(?=.*[\W_]).{8,}$/', $password)) {
            return $data["message"] = "";
        }
        else {
            $tmp = $this->db->prepare("SELECT * FROM users WHERE email = ?");
            $tmp->execute([$mail]);
            $existing_user = $tmp->fetch();

            // Vérifier si un utilisateur avec cet email existe déjà
             if ($existing_user) {
        return ["message" => "<script>
            document.addEventListener('DOMContentLoaded', function() {
                showError('Cet utilisateur est déjà inscrit avec cet email.');
            });
        </script>"];
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
        session_destroy(); // Détruire la session pour éviter les problèmes de session après la déconnexion
        header("Location: ?controller=home&action=login"); // Rediriger vers la page de connexion
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
        public function update_username($user_id, $new_username) {
    $sql = "UPDATE users SET username = ? WHERE user_id = ?";
    $stmt = $this->db->prepare($sql);
    $stmt->execute([$new_username, $user_id]);
}

        public function update_user_picture($user_id, $filename) {
    $sql = "UPDATE users SET profile_picture = ? WHERE user_id = ?";
    $stmt = $this->db->prepare($sql);
    $stmt->execute([$filename, $user_id]);
}


    public function sendPasswordResetMail($recipientEmail) {
    $token = bin2hex(random_bytes(50)); // Génération d'un token aléatoire

    // Enregistrement du token dans la base de données
    $stmt = $this->db->prepare("UPDATE users SET reset_token = ?, reset_token_expiry = NOW() + INTERVAL 1 HOUR WHERE email = ?");
    $stmt->execute([$token, $recipientEmail]);
    $resetLink = "http://localhost/sae/?Controller=home&action=reset&token=" . urlencode($token);
    
    
    $mail = new PHPMailer(true);

    $sql = "SELECT email FROM users WHERE email = ?";
    $stmt = $this->db->prepare($sql);
    $stmt->execute([$recipientEmail]);

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (isset($user['email'])) {
        // Configuration SMTP Gmail
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'assistance2annotiverse@gmail.com';
        $mail->Password   = 'ifbo qcud inof mdju';
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        // Expéditeur / destinataire
        $mail->setFrom('assistance2annotiverse@gmail.com', 'Support Annotiverse');
        $mail->addAddress($user['email']);

        // Contenu du mail
        $mail->isHTML(true);
        $mail->Subject = 'Réinitialisation de votre mot de passe';
        $mail->Body    = "
            <h3>Réinitialisation de mot de passe</h3>
            <p>Bonjour,</p>
            <p>Pour réinitialiser votre mot de passe, cliquez sur le lien ci-dessous :</p>
            <p><a href='$resetLink'>$resetLink</a></p>
            <p>Si vous n'avez pas demandé de réinitialisation, ignorez simplement ce message.</p>
        ";
        $mail->AltBody = "Pour réinitialiser votre mot de passe, copiez ce lien dans votre navigateur : $resetLink";

        $mail->send();
        
        $data = ["message" => "Email de réinitialisation envoyé avec succès."];
        return $data;
    } else {
        $data = ["message" => "Aucun utilisateur trouvé avec cet email.", "error" => true];
        return $data;
    }
}        

    public function checkToken($token) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE reset_token = ? AND reset_token_expiry > NOW()");
        $stmt->execute([$token]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $data = [
                'user_id' => $row['user_id']
            ];
            return $data; 
        } else {
            $data = [
                'message' => 'Le lien de réinitialisation est invalide ou a expiré.'
            ];
            return $data;
        }
    }

    public function resetPassword($new_password, $token) {
        
        // Vérification de la longueur du mot de passe et s'il contient au moins une lettre majuscule et un caractère spécial
        if (!preg_match('/^(?=.*[A-Z])(?=.*[\W_]).{8,}$/', $new_password)) {
            $data = ["message" => "Le mot de passe doit contenir au moins 8 caractères, une majuscule et un caractère spécial."];
            return $data;
        }

        $hash = password_hash($new_password, PASSWORD_BCRYPT); // Utilisation de bcrypt pour le hashage du mot de passe

         // Mise à jour du mot de passe dans la base de données
        $stmt = $this->db->prepare("UPDATE users SET password_hash = ?, reset_token = NULL, reset_token_expiry = NULL WHERE reset_token = ?");
        $stmt->execute([$hash, $token]);

        // Vérification si la mise à jour a réussi
        if ($stmt->rowCount() > 0) {
            $data = ["message" => "Mot de passe réinitialisé avec succès.", "success" => true];
            return $data;
        } else {
            $data = ["message" => "Échec de la réinitialisation du mot de passe."];
            return $data;
        }
    }
}
    public function update_user_password($user_id, $new_password) {
        $hash = password_hash($new_password, PASSWORD_BCRYPT); // Cryptage du mot de passe avec bcrypt
        $sql = "UPDATE users SET password_hash = ? WHERE user_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$hash, $user_id]);
    }

    public function delete_user($user_id) {
        // Supprimer l'utilisateur de la base de données
        $sql = "DELETE FROM users WHERE user_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$user_id]);


        $this->logout_user($user_id); // Déconnexion de l'utilisateur après la suppression
    }
}
