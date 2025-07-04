<!DOCTYPE html>
<html lang="en">

<head>
	<title>Login V4</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!--===============================================================================================-->
	<link rel="icon" type="image/png" href="src/images/icons/favicon.ico" />
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="src/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="src/fonts/iconic/css/material-design-iconic-font.min.css">
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
	<link rel="stylesheet" type="text/css" href="src/css/util.css">
	<link rel="stylesheet" type="text/css" href="src/css/main.css">
	<!--===============================================================================================-->
</head>

<body>
	<?php echo isset($message) ? $message : ''; ?>
	<div class="limiter">
		<div class="container-login100" >
			<div class="wrap-login100 p-l-55 p-r-55 p-t-65 p-b-54">
				<form class="login100-form validate-form" method="POST">
					<span class="login100-form-title p-b-49">
						Connexion
					</span>

					<div class="wrap-input100 validate-input m-b-23" data-validate="Adresse e-mail requise">
						<span class="label-input100">Email</span>
						<input class="input100" type="mail" name="mail" placeholder="Entrez votre adresse e-mail">
						<span class="focus-input100" data-symbol="&#xf206;"></span>
					</div>

					<div class="wrap-input100 validate-input" data-validate="Mot de passe requis">
						<span class="label-input100">Mot de passe</span>
						<input class="input100" type="password" name="password" placeholder="Entrez votre mot de passe">
						<span class="focus-input100" data-symbol="&#xf190;"></span>
					</div>

					<div class="text-right p-t-8 p-b-31">
						<a href="?Controller=home&action=forgot_password">
							Mot de passe oublié?
						</a>
					</div>
					<div class="form-group">
						<label>
							<input type="checkbox" name="accept_conditions" required>
							J'accepte les <a href="?controller=chat&action=conditions" target="_blank">conditions d'utilisation</a>
						</label>
					

					<div class="container-login100-form-btn">
						<div class="wrap-login100-form-btn">
							<div class="login100-form-bgbtn"></div>
							<button class="login100-form-btn" name="submit_login">
								Connexion
							</button>
						</div>
					</div>
					</div>
					<div class="txt1 text-center p-t-54 p-b-20">
						<span color="black">
							Vous n'avez pas encore de compte ? <a href="?controller=home&action=register">Inscrivez-vous ici pour commencer ! </a>
						</span>
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
	<script src="src/js/main.js"></script>

	<script>
    const checkbox = document.getElementById('consent-checkbox');
    const registerBtn = document.getElementById('register-btn');
    const loginBtn = document.getElementById('login-btn');

    checkbox.addEventListener('change', function () {
        if (this.checked) {
            registerBtn.classList.remove('btn-disabled');
            loginBtn.classList.remove('btn-disabled');
        } else {
            registerBtn.classList.add('btn-disabled');
            loginBtn.classList.add('btn-disabled');
        }
    });
</script>



</body>

</html>