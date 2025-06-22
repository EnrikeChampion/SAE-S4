const messageArea = document.getElementById('message-area');
const messageInput = document.getElementById('message-input');
const sendButton = document.getElementById('send-button');

let conn;

// Pour identifier l'utilisateur local (expéditeur)
const myUid = typeof uid !== "undefined" ? uid : null;

// Init WebSocket
if (typeof recipientId !== "undefined" && typeof uid !== "undefined") {
    initiateWebSocket(uid, recipientId);
}

sendButton.addEventListener('click', () => {
    sendMessage();
});

// Fonction pour afficher une ligne de message, bien verticale
function displayMessage(message, sender, emotion) {
    const rowDiv = document.createElement('div');
    rowDiv.className = 'message-row ' + (sender === myUid ? 'mine' : 'other');

    const messageDiv = document.createElement('div');
    messageDiv.className = 'message ' + (sender === myUid ? 'mine' : 'other');

    // Message texte
    messageDiv.textContent = message;

    // Ajout de l'émotion pour l'expéditeur
    if (sender === myUid && emotion) {
        const emotionSpan = document.createElement('span');
        emotionSpan.className = 'emotion-emoji';
        emotionSpan.textContent = " " + getEmotionEmoji(emotion);
        messageDiv.appendChild(emotionSpan);
    }

    rowDiv.appendChild(messageDiv);
    messageArea.appendChild(rowDiv);
    messageArea.scrollTop = messageArea.scrollHeight;
}

// Associe une émotion à un emoji
function getEmotionEmoji(emotion) {
    switch (emotion) {
        case "joie": return "😀";
        case "colere": return "😡";
        case "tristesse": return "😢";
        case "surprise": return "😲";
        case "dégoût": return "🤢";
        case "peur": return "😱";
        default: return "";
    }
}

// Fonction pour initier la connexion WebSocket avec l'ID du destinataire
function initiateWebSocket(uid, recipientId) {
    conn = new WebSocket('ws://localhost:8081/chat?userId=' + uid + '&dest=' + recipientId);

    conn.onopen = function(e) {
        console.log("Connexion WebSocket établie !");
    };

    conn.onmessage = function(e) {
        try {
            const data = JSON.parse(e.data);
            // sender (expéditeur réel du message)
            displayMessage(data.message, 'other', data.emotion);
        } catch (err) {
            console.error("Erreur lors de l'analyse du message :", err);
        }
    };

    conn.onerror = function(e) {
        console.error("Erreur WebSocket :", e);
    };

    conn.onclose = function(e) {
        console.log("Connexion WebSocket fermée.");
    };
}

// Fonction pour envoyer un message au destinataire
function sendMessage() {
    const message = messageInput.value;
    let selectedEmotion = document.querySelector('input[name="emotion"]:checked');
    if (message.trim() !== "" && selectedEmotion != null) {
        const messageData = {
            dest: recipientId,
            message: message,
            emotion: selectedEmotion.value
        };
        // Envoyer le message via WebSocket
        conn.send(JSON.stringify(messageData));
        // Afficher dans l'UI côté expéditeur (toujours vertical, à droite)
        displayMessage(message, myUid, selectedEmotion.value);
        messageInput.value = '';
        selectedEmotion.checked = false;
    }
}
