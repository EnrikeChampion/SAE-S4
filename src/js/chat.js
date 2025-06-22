const messageArea = document.getElementById('message-area');
const messageInput = document.getElementById('message-input');
const sendButton = document.getElementById('send-button');

let conn;
const myUid = typeof uid !== "undefined" ? uid : null;

// Init WebSocket si les ids sont définis
if (typeof recipientId !== "undefined" && typeof uid !== "undefined") {
    initiateWebSocket(uid, recipientId);
}

sendButton.addEventListener('click', () => {
    sendMessage();
});

function displayMessage(message, sender, emotion, id = null) {
    const rowDiv = document.createElement('div');
    rowDiv.className = 'message-row ' + (sender === myUid ? 'mine' : 'other');

    const messageDiv = document.createElement('div');
    messageDiv.className = 'message ' + (sender === myUid ? 'mine' : 'other');

    // Affichage texte + émotion pour l'expéditeur
    messageDiv.textContent = message;
    if (sender === myUid && emotion) {
        const emotionSpan = document.createElement('span');
        emotionSpan.className = 'emotion-emoji';
        emotionSpan.textContent = " " + getEmotionEmoji(emotion);
        messageDiv.appendChild(emotionSpan);
    }

    // Bouton suppression pour l'utilisateur local uniquement
    if (sender === myUid) {
        const deleteBtn = document.createElement('button');
        deleteBtn.textContent = '🗑️';
        deleteBtn.title = 'Supprimer ce message';
        deleteBtn.className = 'delete-message-btn';
        deleteBtn.onclick = function() {
            if (confirm("Supprimer ce message ?")) {
                rowDiv.remove();
                // Ici tu peux envoyer un message au serveur pour supprimer côté back si besoin
            }
        };
        messageDiv.appendChild(deleteBtn);
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

function initiateWebSocket(uid, recipientId) {
    conn = new WebSocket('ws://localhost:8081/chat?userId=' + uid + '&dest=' + recipientId);
    conn.onopen = function(e) {
        console.log("Connexion WebSocket établie !");
    };
    conn.onmessage = function(e) {
        try {
            const data = JSON.parse(e.data);
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

function sendMessage() {
    const message = messageInput.value;
    let selectedEmotion = document.querySelector('input[name="emotion"]:checked');
    if (message.trim() !== "" && selectedEmotion != null) {
        const messageData = {
            dest: recipientId,
            message: message,
            emotion: selectedEmotion.value
        };
        conn.send(JSON.stringify(messageData));
        displayMessage(message, myUid, selectedEmotion.value);
        messageInput.value = '';
        selectedEmotion.checked = false;
    }
}
