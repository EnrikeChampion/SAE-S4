# SAE

---

## Lancement

 -   Pour lancer le serveur sur Windows:
   -   Utiliser XAMPP (Port Apache : 80, 443; Port MySQL : 3307)
   -   Executer la commande `php ./start.php`

## Structure

- Les fichiers sont en standard psr-4
   - La biliothèque Ratchet l'utilise donc on c'est plus simple voir obliger de l'utiliser
   - Les classes qui respectes le standard sont autoload
   - Si tu met d'autres classes `composer dump-autoload` avec `-o` pour optimiser et évidemment il faut avec composer.
