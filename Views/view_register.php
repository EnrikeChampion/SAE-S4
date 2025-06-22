<!DOCTYPE html>
<html lang="en">
<head>
	<script>
function showError(message) {
    const container = document.createElement('div');
    container.textContent = message;
    container.style.position = 'fixed';
    container.style.top = '20px';
    container.style.left = '50%';
    container.style.transform = 'translateX(-50%)';
    container.style.backgroundColor = '#ff4444';
    container.style.color = 'white';
    container.style.padding = '12px 24px';
    container.style.borderRadius = '8px';
    container.style.fontWeight = 'bold';
    container.style.boxShadow = '0 4px 8px rgba(0, 0, 0, 0.2)';
    container.style.zIndex = '9999';

    document.body.appendChild(container);

    setTimeout(() => {
        container.remove();
    }, 3500);
}
</script>

	<title>Register</title>
	<style>
        #Exist {
            color: #ff0000;
            opacity: 0;
            font-weight: bold;
            margin-bottom: 20px;
        }
        .error-popup {
            background-color: #ff4d4f;
            color: white;
            padding: 12px 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            position: absolute;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            font-weight: bold;
            z-index: 1000;
            display: flex;
            align-items: center;
            gap: 10px;
            animation: slideDown 0.3s ease-in-out;
        }

        @keyframes slideDown {
            from { opacity: 0; transform: translateX(-50%) translateY(-10px); }
            to { opacity: 1; transform: translateX(-50%) translateY(0); }
        }

        .hidden {
            display: none;
        }
    </style>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="src/images/icons/favicon.ico"/>
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
    <div id="error-popup" class="error-popup hidden">
        <i class="fa fa-exclamation-circle"></i> <span id="error-message">Erreur ici</span>
    </div>
	<div class="limiter">
		<div class="container-login100" style="background-image: url('src/images/Dark.jpg');">
			<div class="wrap-login100 p-l-55 p-r-55 p-t-65 p-b-54">
				<form class="login100-form validate-form" method="POST">
					<span class="login100-form-title p-b-49">
						Inscription
					</span>
					<p id="Exist" class="error-message">
    					Ce nom d'utilisateur existe déjà
					</p>
					<div class="wrap-input100 validate-input m-b-23" data-validate = "Username is required">
						<span class="label-input100">Nom d'utilisateur</span>
						<input class="input100" type="text" name="username" placeholder="Entrez votre nom d'utilisateur">
						<span class="focus-input100" data-symbol="&#xf206;"></span>
					</div>
					<div class="wrap-input100 validate-input m-b-23" data-validate = "Nom d'utilisateur requis">
						<span class="label-input100">Email</span>
						<input class="input100" type="mail" name="mail" placeholder="Entrez votre nom d'utilisateur">
						<span class="focus-input100" data-symbol="&#xf206;"></span>
					</div>

					<div class="wrap-input100 validate-input" data-validate="Mot de passe requis">
						<span class="label-input100">Mot de passe</span>
						<input class="input100" type="password" name="password" placeholder="Entrez votre mot de passe">
						<span class="focus-input100" data-symbol="&#xf190;"></span>
					</div>

                    <div class="text-right p-t-8 p-b-31"></div>
					<div class="form-group">
						<div class="consent">
    						 <input type="checkbox" id="consent-checkbox" required>
    							<label for="consent-checkbox">
        							 J'ai lu et j'accepte les <a href="?controller=chat&action=conditions" target="_blank">conditions d'utilisation</a>.
						</div>
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
							  Vous avez déjà un compte ? <a href="?Controller=home&action=login">Connectez-vous ici ! </a>
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
	<script src="js/main.js"></script>
	
	<script>
    function showError(message) {
        const popup = document.getElementById('error-popup');
        const msg = document.getElementById('error-message');
        msg.innerText = message;
        popup.classList.remove('hidden');

        setTimeout(() => {
            popup.classList.add('hidden');
        }, 4000);
    }

    document.querySelector('form').addEventListener('submit', function(e) {
        const email = document.querySelector('input[name="mail"]').value;
        const password = document.querySelector('input[name="password"]').value;

        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        const passwordRegex = /^(?=.*[A-Z])(?=.*[\W_]).{8,}$/; 

        if (!emailRegex.test(email)) {
            e.preventDefault();
            showError("Email invalide !");
            return;
        }

        if (!passwordRegex.test(password)) {
            e.preventDefault();
            showError("Le mot de passe doit contenir au moins 8 caractères, une majuscule et un caractère spécial.");
            return;
        }
    });
	
</script>
		<script>
function showError(message) {
    const container = document.createElement('div');
    container.textContent = message;
    container.style.position = 'fixed';
    container.style.top = '20px';
    container.style.left = '50%';
    container.style.transform = 'translateX(-50%)';
    container.style.backgroundColor = '#ff4444';
    container.style.color = 'white';
    container.style.padding = '12px 24px';
    container.style.borderRadius = '8px';
    container.style.fontWeight = 'bold';
    container.style.boxShadow = '0 4px 8px rgba(0, 0, 0, 0.2)';
    container.style.zIndex = '9999';
    container.style.transition = 'opacity 0.5s ease';

    document.body.appendChild(container);

    setTimeout(() => {
        container.style.opacity = 0;
        setTimeout(() => container.remove(), 500);
    }, 3500);
}
</script>

</body>
</html>


