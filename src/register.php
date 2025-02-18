<?php



session_start(); 
require_once 'connexion.php';

    // Vérification si le formulaire d'inscription a été soumis
    if (isset($_POST['submit_registration'])) {
        
        // Récupération et validation des données du formulaire
        $prenom = $_POST['prenom'];
        $nom = $_POST['nom'];
		
        $email = $_POST['email'];
        $password = $_POST['password'];
		$hash = password_hash($password, PASSWORD_BCRYPT); // Utilisation de sha1 pour le hashage du mot de passe
        

        // Vérification si tous les champs obligatoires sont remplis
        if (empty($email) || empty($password)) {
            echo "Veuillez remplir tous les champs obligatoires.";
        } 
		else {
            $stmt = $bdd->prepare("SELECT * FROM users WHERE email = ?");
            $stmt->execute([$email]);
            $existing_user = $stmt->fetch();

           // Vérifier si un utilisateur avec cet email existe déjà
if ($existing_user) {
    echo "Cet utilisateur existe déjà.";
} else {
    // Insertion du nouvel utilisateur
    $requete = $bdd->prepare("INSERT INTO users (prenom, nom,  email, password) VALUES (?, ?, ?, ?)");
    $requete->execute([$prenom, $nom, $email, $hash]);

    // Redirection vers la page de connexion après l'inscription
    header("Location: login.php");
    exit();
}

	}
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Login V4</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/iconic/css/material-design-iconic-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
<!--===============================================================================================-->
</head>
<body>
	
	<div class="limiter">
		<div class="container-login100" style="background-image: url('images/bg-01.jpg');">
			<div class="wrap-login100 p-l-55 p-r-55 p-t-65 p-b-54">
				<form class="login100-form validate-form" method="POST">
					<span class="login100-form-title p-b-49">
						Inscription
					</span>
                    <div class="wrap-input100 validate-input m-b-23" data-validate = "Username is reauired">
						<span class="label-input100">Prénom</span>
						<input class="input100" type="text" name="prenom" placeholder="Entrez votre prénom">
						<span class="focus-input100" data-symbol="&#xf206;"></span>
					</div>
                    <div class="wrap-input100 validate-input m-b-23" data-validate = "Username is reauired">
						<span class="label-input100">Nom</span>
						<input class="input100" type="mail" name="nom" placeholder="Entrez votre nom">
						<span class="focus-input100" data-symbol="&#xf206;"></span>
					</div>
					<div class="wrap-input100 validate-input m-b-23" data-validate = "Username is reauired">
						<span class="label-input100">Email</span>
						<input class="input100" type="text" name="email" placeholder="Entrez votre login">
						<span class="focus-input100" data-symbol="&#xf206;"></span>
					</div>

					

					<div class="wrap-input100 validate-input" data-validate="Password is required">
						<span class="label-input100">Mot de passe</span>
						<input class="input100" type="password" name="password" placeholder="Entrez votre mot de passe">
						<span class="focus-input100" data-symbol="&#xf190;"></span>
					</div>

                    <div class="text-right p-t-8 p-b-31">
						
					</div>
					
					
					
					<div class="container-login100-form-btn">
						<div class="wrap-login100-form-btn">
							<div class="login100-form-bgbtn"></div>
							<button class="login100-form-btn"  name="submit_registration">
								Inscription
							</button>
						</div>
					</div>

					<div class="txt1 text-center p-t-54 p-b-20">
						<span color="black">
							  Vous avez déjà un compte ? <a href="login.php">Connectez-vous ici ! </a>
						</span>
					</div>

					<div class="flex-c-m">
						<a href="#" class="login100-social-item bg1">
							<i class="fa fa-facebook"></i>
						</a>

						<a href="#" class="login100-social-item bg2">
							<i class="fa fa-twitter"></i>
						</a>

						<a href="#" class="login100-social-item bg3">
							<i class="fa fa-google"></i>
						</a>
					</div>

					
				</form>
			</div>
		</div>
	</div>
	

	<div id="dropDownSelect1"></div>
	
<!--===============================================================================================-->
	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/bootstrap/js/popper.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/daterangepicker/moment.min.js"></script>
	<script src="vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
	<script src="vendor/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
	<script src="js/main.js"></script>

</body>
</html>