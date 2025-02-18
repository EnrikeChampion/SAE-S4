<?php
require_once 'vendor/autoload.php';

use websocket\Server;

$server = new Server();
$server->run();
