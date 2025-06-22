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
            <fieldset>
                <legend>Choose your emotion</legend>
                <input type="radio" id="joie" name="emotion" value="joie" />
                <label for="joie">😀</label>
                <input type="radio" id="colere" name="emotion" value="colere" />
                <label for="colere">😡</label>
                <input type="radio" id="tristesse" name="emotion" value="tristesse" />
                <label for="tristesse">😢</label>
                <input type="radio" id="surprise" name="emotion" value="surprise" />
                <label for="surprise">😲</label>
                <input type="radio" id="dégoût" name="emotion" value="dégoût" />
                <label for="dégoût">🤢</label>
                <input type="radio" id="peur" name="emotion" value="peur" />
                <label for="peur">😱</label>
            </fieldset>
            <button id="send-button">Envoyer</button>
        </div>
    </div>
    <script>
        const recipientId = <?php echo $_GET['id'];?>;
        const uid = <?php echo $_GET['uid'];?>;
    </script>
    <script src="src/js/chat.js"></script>
</body>

</html>
