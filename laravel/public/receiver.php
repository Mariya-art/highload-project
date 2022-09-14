<?php

require __DIR__.'/../vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Exception\AMQPProtocolChannelException;
use PhpAmqpLib\Message\AMQPMessage;

$connection = new AMQPStreamConnection(
    'localhost', 5672, 'highload', 'Y4arhQi3zFvBV5NBdaYmp4RUOmdvL568Xix8loAqoc900bEG5A'
);

try {
    $channel = $connection->channel();
    $channel->queue_declare('Clothes', false, false, false);
    
    $message = new AMQPMessage('T-shirt', 1);
    $channel->basic_publish($message);
    
    echo " [*] Waiting for messages. To exit press CTRL+C\n";

    $callback = function($message) {
        echo ' [x] Received ', $message->body, '\n';
    };

    $channel->basic_consume('Clothes', '', false, true, false, false, $callback);

    while ($channel->is_open()) {
        $channel->wait();
    }
}catch (AMQPProtocolChannelException $exception) {
    echo $exception->getMessage();
}