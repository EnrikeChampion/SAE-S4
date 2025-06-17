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
                <button data-emotion="joie">😀</button>
                <button data-emotion="colère">😡</button>
                <button data-emotion="tristesse">😢</button>
            </div>
            <button id="send-button">Envoyer</button>
        </div>
    </div>
    <script>
        const recipientId = <?php echo $_GET['id'];?>;
        const uid = <?php echo $_GET['uid'];?>;
    </script>
    <script src="src/js/chat.js">
    </script>
</body>

</html>