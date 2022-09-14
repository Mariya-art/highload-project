<?php

require __DIR__.'/../vendor/autoload.php';

use App\Components\Chat;
use Ratchet\Server\IoServer;

$server = IoServer::factory(
    new Chat(),
    8181
);

$server->run();