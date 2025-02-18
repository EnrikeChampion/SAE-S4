<?php
try {
  // Connexion à la base de données
  $bdd = new PDO('mysql:host=localhost;dbname=sae', 'root', '');
  $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
  // Gestion des erreurs de connexion à la base de données
  die("Erreur de connexion : " . $e->getMessage());
}
