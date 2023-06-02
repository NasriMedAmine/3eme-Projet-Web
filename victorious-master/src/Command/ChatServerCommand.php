<?php

namespace App\Command;

use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Ratchet\Server\IoServer;
use App\AppBundle\Servers\Chat;

class ChatServerCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('AmineNasri:app:chat-server')
            ->setDescription('Start chat server');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $server = IoServer::factory(
            new HttpServer(new WsServer(new Chat($this->getContainer()))),
            8080,
            '127.0.0.1'
        );

    //    $server = IoServer::factory(
    //        new HttpServer(new WsServer(new Chat($this->getContainer()))),
    //        8080,
    //        '192.168.1.35'
    //    );
        $server->run();
    }
} 