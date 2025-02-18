<?php

namespace websocket;

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class Chat implements MessageComponentInterface
{
    protected $clients;

    public function __construct()
    {
        $this->clients = new \SplObjectStorage;
    }

    public function onOpen(ConnectionInterface $conn)
    {
        $queryString = $conn->httpRequest->getUri()->getQuery();
        parse_str($queryString, $queryParams);
        $this->clients->attach($conn, [
            'userId' => $queryParams['userId'],
            'dest' => $queryParams['dest']
        ]);
        echo "New connection from user: {$queryParams['userId']} to {$queryParams['dest']}\n";
    }

    public function onMessage(ConnectionInterface $from, $msg)
    {
        $message = json_decode($msg, true);
        echo "Message : {$message['message']}\n";

        // Get the sender's data
        $senderData = $this->clients[$from];
        $senderUserId = $senderData['userId'];

        // Find the recipient based on the sender's 'dest'
        foreach ($this->clients as $client) {
            if ($client !== $from && $this->clients[$client]['userId'] === $senderData['dest'] && $this->clients[$client]['dest'] === $senderUserId) {
                $recipientData = $this->clients[$client];
                $recipientDest = $recipientData['dest'];

                if ($recipientDest === $senderUserId) {
                    $client->send(json_encode([
                        'message' => $message['message'],
                        'emotion' => $message['emotion'],
                        'sender' => $senderUserId
                    ]));
                    break;
                }
            }
        }
    }
    public function onClose(ConnectionInterface $conn)
    {
        $this->clients->detach($conn);
        echo "Connexion fermée\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e)
    {
        echo "Erreur : {$e->getMessage()}\n";
        $conn->close();
    }
}
