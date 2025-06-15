const messageArea = document.getElementById('message-area');
const messageInput = document.getElementById('message-input');
const sendButton = document.getElementById('send-button');
const emotionButtons = document.getElementById('emotion-buttons').querySelectorAll('button');
let selectedEmotion = null;

// Vérifier si la page a reçu l'ID du destinataire via POST

// Récupérer l'ID du destinataire depuis une variable POST (présumée envoyée du backend)
const recipientId = $_POST['id'];
const uid = $_POST['uid'];

// Afficher l'ID du destinataire sur la page 
if (recipientId) {
    initiateWebSocket(uid, recipientId); // Initier la connexion WebSocket avec l'ID du destinataire
}

emotionButtons.forEach(button => {
    button.addEventListener('click', () => {
        selectedEmotion = button.dataset.emotion;
    });
});

sendButton.addEventListener('click', () => {
    sendMessage();
});

function displayMessage(message, sender, emotion) {
    const messageDiv = document.createElement('div');
    messageDiv.classList.add('message');
    messageDiv.classList.add(sender);
    messageDiv.textContent = message + " (" + emotion + ")";
    messageArea.appendChild(messageDiv);
    messageArea.scrollTop = messageArea.scrollHeight;
}

var conn;

// Fonction pour initier la connexion WebSocket avec l'ID du destinataire
function initiateWebSocket(uid, recipientId) {
    conn = new WebSocket('ws://localhost:8081/chat?userId=' + uid + '&dest=' + recipientId); // Ouvrir la connexion WebSocket avec l'ID utilisateur

    conn.onopen = function(e) {
        console.log("Connexion WebSocket établie !");
    };

    conn.onmessage = function(e) {
        console.log("Message reçu : " + e.data);
        const data = JSON.parse(e.data);
        displayMessage(data.message, 'other', data.emotion);
    };

    conn.onerror = function(e) {
        console.error("Erreur WebSocket :", e);
    };

    conn.onclose = function(e) {
        console.log("Connexion WebSocket fermée.");
    };
}

// Fonction pour envoyer un message au destinataire
function sendMessage(recipientId) {
    const message = document.getElementById("message-input").value; // Récupérer le message saisi
    // Si le message n'est pas vide
    if (message.trim() !== "" && selectedEmotion != null) {
        const messageData = {
            dest: recipientId,
            message: message,
            emotion: selectedEmotion
        };
        // Envoyer le message via la connexion WebSocket
        conn.send(JSON.stringify(messageData));

        // Afficher le message dans l'interface utilisateur
        displayMessage(message, uid, selectedEmotion);

        // Optionnellement, vider le champ après l'envoi du message
        document.getElementById("message-input").value = '';
        selectedEmotion = null;
    }
}