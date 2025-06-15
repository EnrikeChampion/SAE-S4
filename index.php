<?php
session_start(); // Démarrage de la session

// Inclusion du modèle
require_once "Models/Model.php";

// Inclusion du modèle

require_once "Controllers/Controller.php";


// Liste des contrôleurs
$controllers = ["home", "chat"];

// Nom du contrôleur par défaut
$controller_default = "home";

// Vérification si le paramètre "controller" existe dans l'URL et correspond à un contrôleur de la liste
if (isset($_GET['controller']) && in_array($_GET['controller'], $controllers)) {
    $controller_name = $_GET['controller'];
} else {
    $controller_name = $controller_default; // Si non spécifié, on utilise le contrôleur par défaut
}

// Détermination du nom de la classe du contrôleur
$class_name = 'Controller_' . $controller_name;

// Détermination du chemin du fichier contenant la définition du contrôleur
$file_name = 'Controllers/' . $class_name . '.php';

// Si le fichier du contrôleur existe et est lisible
if (is_readable($file_name)) {
    require_once $file_name;
    
    // Vérification si la classe du contrôleur existe avant de l'instancier
    if (class_exists($class_name)) {
        $controller = new $class_name();
    } else {
        // Gestion de l'erreur si la classe n'est pas définie
        header("HTTP/1.0 500 Internal Server Error");
        die("Erreur : La classe '$class_name' n'existe pas dans le fichier '$file_name'.");
    }
} else {
    // Gestion de l'erreur si le fichier du contrôleur est introuvable
    header("HTTP/1.0 404 Not Found");
    die("Erreur 404 : Le fichier du contrôleur '$file_name' est introuvable.");
}
