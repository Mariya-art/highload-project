<?php

require __DIR__.'/../vendor/autoload.php';

use App\Components\ClothesMessage;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Exception\AMQPProtocolChannelException;
use PhpAmqpLib\Message\AMQPMessage;

$connection = new AMQPStreamConnection(
    'localhost', 5672, 'highload', 'Y4arhQi3zFvBV5NBdaYmp4RUOmdvL568Xix8loAqoc900bEG5A'
);

try {
    $channel = $connection->channel();
    $channel->queue_declare('Clothes', false, false, false);
    
    $message = new AMQPMessage(json_encode(new ClothesMessage('T-shirt', 1)));
    $channel->basic_publish($message, '', 'Clothes');
    
    $channel->close();
    $connection->close();
}catch (AMQPProtocolChannelException $exception) {
    echo $exception->getMessage();
}