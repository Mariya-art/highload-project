<?php

namespace App\Components;

use Exception;
use Ratchet\ConnectionInterface;
use Ratchet\MessageComponentInterface;
use Ratchet\MessageInterface;
use SplObjectStorage;

class Chat implements MessageComponentInterface
{
    protected SplObjectStorage $clients;

    public function __construct()
    {
        $this->clients = new SplObjectStorage();
    }

    function onOpen(ConnectionInterface $conn)
    {
        $this->clients->attach($conn);
        echo "New connection ($conn->resourceId)\n";
    }

    function onClose(ConnectionInterface $conn)
    {
        $this->clients->detach($conn);
        echo "Close connection ($conn->resourceId)\n";
    }

    function onError(ConnectionInterface $conn, Exception $e)
    {
        echo "An error has occured: {$e->getMessage()}\n";
    }

    function onMessage(ConnectionInterface $from, $msg)
    {
        $clientCount = $this->clients->count();
        echo sprintf(
            'Connection %d sending message "%s" to %d other connection%s', 
            $from->resourceId,
            $msg,
            $clientCount,
            $clientCount === 1 ? '' : 's'
        );

        /**@var ConnectionInterface $client */
        foreach ($this->clients as $client) {
            if($from !== $client) {
                $client->send($msg);
            }
        }
    }
}