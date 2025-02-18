# SAE

---

## lancement

 -   lance server ws sur windows: `php ./start.php` sur linux jsp

## Structure

- les fichiers sont en standard psr-4
   - la biliothèque  Ratchet l'utilise donc on c'est plus simple voir obliger de l'utiliser
    - les classes qui respectes le standard sont autoload
     - si tu met d'autres classes `composer dump-autoload` avec `-o` pour optimiser et évidemment il faut avec composer.
