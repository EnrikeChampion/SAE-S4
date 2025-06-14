<!DOCTYPE html>
<html>

<head>
    <title>Chat Annoté</title>
    <link rel="stylesheet" href="src/css/chat.css">
</head>

<body>
    <div id="chat-container">
        <div id="message-area"></div>
        <div id="input-area">
            <textarea id="message-input" placeholder="Écrivez votre message..."></textarea>
            <div id="emotion-buttons">
                <button data-emotion="joie">Joie</button>
                <button data-emotion="colère">Colère</button>
                <button data-emotion="tristesse">Tristesse</button>
            </div>
            <button id="send-button">Envoyer</button>
        </div>
    </div>
    <script src="src/js/chat.js"></script>
</body>

</html>