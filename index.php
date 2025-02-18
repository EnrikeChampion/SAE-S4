<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Annotator Quest</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: url('bg-01.jpg') no-repeat center center fixed;
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: #fff;
            text-align: center;
        }

        .container {
            background: rgba(0, 0, 0, 0.6);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
        }

        .logo {
            width: 300px;
            height: 200px;
            margin-bottom: 30px;
        }

        h1 {
            font-size: 3em;
            margin: 20px 0 120px;
            font-family: 'Roboto', sans-serif;
        }

        .buttons {
            display: flex;
            gap: 20px;
            justify-content: center;
        }

        .buttons a {
            text-decoration: none;
            color: #fff;
            background: #007bff;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 1em;
            transition: background 0.3s;
        }

        .buttons a:hover {
            background: #0056b3;
        }
    </style>
</head>

<body>
<div class="container">
    <img src="logo.png" alt="Annotator Quest Logo" class="logo">
    <h1>Bienvenue sur Annotator Quest</h1>
    <p>💬 Connectez-vous et commencez à chatter avec style ! Que vous soyez ici pour échanger des idées, partager un secret ou juste dire "Salut !", vous êtes au bon endroit. 🚀</p>
    <p>👋 Nouveau ? Inscrivez-vous pour rejoindre la conversation. Déjà inscrit ? Connectez-vous et reprenez là où vous vous êtes arrêtés !</p>
    <div class="buttons">
    <a href="src/register.php"> Inscription</a>
        <a href="src/login.php"> Connexion</a>
    </div>
</div>

</body>

</html>