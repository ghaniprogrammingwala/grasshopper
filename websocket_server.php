<?php
require 'vendor/autoload.php';

use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class CallServer implements MessageComponentInterface {
    protected $clients;
    protected $userConnections = [];

    public function __construct() {
        $this->clients = new \SplObjectStorage;
    }

    public function onOpen(ConnectionInterface $conn) {
        $this->clients->attach($conn);
        echo "New connection! ({$conn->resourceId})\n";
    }

    public function onMessage(ConnectionInterface $from, $msg) {
        $data = json_decode($msg);

        switch($data->type) {
            case 'register':
                $this->userConnections[$data->user_number] = $from;
                echo "User {$data->user_number} registered\n";
                break;

            case 'test_call':
                $this->handleCall($data);
                break;
        }
    }

    private function handleCall($data) {
        // Notify caller
        if(isset($this->userConnections[$data->from_number])) {
            $this->userConnections[$data->from_number]->send(json_encode([
                'type' => 'call_forwarded',
                'to_number' => $data->to_number
            ]));
        }

        // Notify receiver
        if(isset($this->userConnections[$data->to_number])) {
            $this->userConnections[$data->to_number]->send(json_encode([
                'type' => 'incoming_call',
                'from_number' => $data->from_number
            ]));
        }

        // Simulate call end after 5 seconds
        sleep(5);
        $this->sendCallEndNotification($data->from_number, $data->to_number);
    }

    private function sendCallEndNotification($from, $to) {
        // Notify both parties that call has ended
        if(isset($this->userConnections[$from])) {
            $this->userConnections[$from]->send(json_encode([
                'type' => 'call_ended',
                'number' => $to
            ]));
        }
        if(isset($this->userConnections[$to])) {
            $this->userConnections[$to]->send(json_encode([
                'type' => 'call_ended',
                'number' => $from
            ]));
        }
    }

    public function onClose(ConnectionInterface $conn) {
        $this->clients->detach($conn);
        // Remove from user connections
        foreach($this->userConnections as $number => $connection) {
            if($connection === $conn) {
                unset($this->userConnections[$number]);
                break;
            }
        }
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "Error: {$e->getMessage()}\n";
        $conn->close();
    }
}

// Create WebSocket server
$server = IoServer::factory(
    new HttpServer(
        new WsServer(
            new CallServer()
        )
    ),
    8080
);

echo "WebSocket server started on port 8080\n";
$server->run(); 
