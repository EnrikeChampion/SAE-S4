DROP TABLE IF EXISTS annotations;
DROP TABLE IF EXISTS messages;
DROP TABLE IF EXISTS users;

CREATE TABLE users (
    user_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL,
    created_at TIMESTAMP,
    last_online TIMESTAMP,
    is_online BOOLEAN,
    reset_token VARCHAR(255) DEFAULT NULL,
    reset_token_expiry TIMESTAMP DEFAULT NOW()
);

CREATE TABLE messages (
    message_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    sender_id INT NOT NULL,
    receiver_id INT NOT NULL,
    content TEXT NOT NULL,
    created_at TIMESTAMP,
    FOREIGN KEY (sender_id) REFERENCES users(user_id),
    FOREIGN KEY (receiver_id) REFERENCES users(user_id)
);

CREATE TABLE annotations (
    annotation_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    annotator_id INT NOT NULL,
    message_id INT NOT NULL,
    emotion ENUM('joie','colère','tristesse','surprise','dégoût','peur') NOT NULL,
    annotated_at TIMESTAMP,
    FOREIGN KEY (annotator_id) REFERENCES users(user_id),
    FOREIGN KEY (message_id) REFERENCES messages(message_id)
);

INSERT INTO users (username, password_hash, email, created_at, last_online, is_online)
VALUES ('Ruben Dubord', '$2y$10$eYG2LINe6j4ckZk0pCae3OPXBPODOYsbeCPes94/G7bwi.oYQLGWm', 'vousaurezpasmonmail@gmail.com', NOW(), NOW(), TRUE),
('Enrike Champion', '$2y$10$eYG2LINe6j4ckZk0pCae3OPXBPODOYsbeCPes94/G7bwi.oYQLGWm', 'lemaildeenrike@gmail.com', NOW(), NOW(), TRUE),
('Ivan Veljovic Bulatovic', '$2y$10$eYG2LINe6j4ckZk0pCae3OPXBPODOYsbeCPes94/G7bwi.oYQLGWm', 'unmailbcptroplong@gmail.com', NOW(), NOW(), TRUE),
('Ryan Agin', '$2y$10$eYG2LINe6j4ckZk0pCae3OPXBPODOYsbeCPes94/G7bwi.oYQLGWm', 'legoat@gmail.com', NOW(), NOW(), TRUE),
('Yanis Naït-Makhlouf', '$2y$10$eYG2LINe6j4ckZk0pCae3OPXBPODOYsbeCPes94/G7bwi.oYQLGWm', 'pistachegrill@gmail.com', NOW(), NOW(), TRUE),
('Syphax Benchalal', '$2y$10$eYG2LINe6j4ckZk0pCae3OPXBPODOYsbeCPes94/G7bwi.oYQLGWm', 'lesyphax@gmail.com', NOW(), NOW(), FALSE)
;
