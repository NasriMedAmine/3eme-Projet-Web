<?php

namespace App\AppBundle\Servers;
use App\Entity\ChatMessage;
use App\Entity\Interditmot;
use App\Entity\Tournament;
use App\Entity\User as UserEntity;
use App\Entity\Winner;
use App\Repository\InterditmotRepository;
use Doctrine\ORM\EntityManager;
use http\Client\Curl\User;
use phpDocumentor\Reflection\Type;
use phpDocumentor\Reflection\Types\Boolean;
use Ratchet\ConnectionInterface;
use Ratchet\MessageComponentInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use function PHPUnit\Framework\equalTo;

class Chat implements MessageComponentInterface
{
    //private InterditmotRepository $interditmotRepository;
    private EntityManager $entityManager;
    private $users = [];
    private $clients;
    protected $container;

    public function __construct(ContainerInterface $container)
    {

        $this->clients = new \SplObjectStorage();
        $this->container = $container;
    }

    public function onOpen(ConnectionInterface $conn)

    {
        $this->clients->attach($conn);
        $this->users["UserId"] = [$conn->resourceId];
        echo sprintf('Connection #%d has Connected \n', $conn->resourceId);
        echo ''."\n";
        //foreach ($this->users as $user){
         //   echo $user;
           // echo ''."\n";
        //}

        echo ''."\n";

    }

    public function onClose(ConnectionInterface $closedConnection)
    {
        $this->clients->detach($closedConnection);
        echo sprintf('Connection #%d has disconnected\n', $closedConnection->resourceId);
    }

    public function onError(ConnectionInterface $conn, \Exception $e)
    {
        $conn->send('An error has occurred: '.$e->getMessage());
        $conn->close();
    }

    public function onMessage(ConnectionInterface $from, $message)
    {
        echo 'tao jeni message men aaned Browser'."\n";
        //$totalClients = count($this->clients) - 1;
//        $messageDecoder = (array)json_decode($message);
//        echo vsprintf(
//            'Connection #%1$d sending message "%2$s" to %3$d other connection%4$s'."\n", [
//            $from->resourceId,
//            $messageDecoder,
//            $totalClients,
//            $totalClients === 1 ? '' : 's'
//        ]);
        echo gettype($message);
        echo $message;
        $messageDecoder = json_decode($message);


        echo 'tao bech ndokhol nchouf esem Function'."\n";
        echo gettype($messageDecoder);
        echo ''."\n";
        //echo $messageDecoder->Function;
        //echo $messageDecoder->Function;
        //echo $messageDecoder->{"Function"};

        $action = $messageDecoder->Function ?? 'unknown';
        switch ($action){
            case 'Chat' :
                echo "saye feket eli Function heya Chat \n";
                echo $messageDecoder->Message;
                echo ''."\n";


                echo $messageDecoder->From;
                echo ''."\n";
                //$from->send("haathet tao saye");

                if($this->ValideMot($messageDecoder->Message) == true){
                    echo "ValideMot() rajeetli true \n";
                    foreach ($this->clients as $client) {
                        if ($from == $client) {
                            $messageJSON = array(
                                "Function" => "ChatFromServeurMe",
                                "message" => $messageDecoder->{"Message"},
                                "From" => $messageDecoder->{"From"}
                            );
                            $this->AddMessage($messageDecoder->{"Message"},$messageDecoder->{"From"});
                            $from->send(sprintf(json_encode($messageJSON)));

                        }
                        else{
                            $messageJSON = array(
                                "Function" => "ChatFromServeur",
                                "message" => $messageDecoder->{"Message"},
                                "From" => $messageDecoder->{"From"}
                            );
                            $this->AddMessage($messageDecoder->{"Message"},$messageDecoder->{"From"});
                            $client->send(sprintf(json_encode($messageJSON)));
                        }


                        echo "saye baathet l Browser message \n";
                    }

                }
                else{
                    echo "ValideMot() rajeetli false \n";
                    $messageJSON = array(
                        "Function" => "InvalideMessage",
                    );
                    $from->send(sprintf(json_encode($messageJSON)));


                }



                break;


            case 'Play' :
                foreach ($this->clients as $client) {
                    if ($from == $client) {
                        $em = $this->container->get('doctrine')->getManager();

                        $user = $em
                            ->getRepository(UserEntity::class)
                            ->find($messageDecoder->{"id"});;

                        $messageJSON = array(
                            "Function" => "PlayMe",
                            "NamePlayer" => $user->getPseudo(),
                            "From" => $messageDecoder->{"Tournament"}
                        );
                        $from->send(sprintf(json_encode($messageJSON)));
                    }
                    else{
                        $em = $this->container->get('doctrine')->getManager();

                        $user = $em
                            ->getRepository(UserEntity::class)
                            ->find($messageDecoder->{"id"});;

                        $messageJSON = array(
                            "Function" => "PlayNotMe",
                            "NamePlayer" => $user->getPseudo(),
                            "From" => $messageDecoder->{"Tournament"}
                        );
                        $client->send(sprintf(json_encode($messageJSON)));
                        echo "saye baathet l Browser message \n";

                    }
                }





                break;


            case 'WinnerPlayer' :
                echo 'tao besh nabaath l client Winner'."\n";

                foreach ($this->clients as $client) {
                    $messageJSON = array(
                        "Function" => "WinnerPlayer",
                        "WinnerName" => $messageDecoder->{"WinnerName"}
                    );
                    $client->send(sprintf(json_encode($messageJSON)));




                }

                echo 'tao besh ndakhel f BD winner'."\n";
                $this->saveWinner($messageDecoder->{"Tournament"} , $messageDecoder->{"WinnerName"});
                echo 'saye f BD winner'."\n";
                break;

            default:
                echo sprintf('Action "%s" is not supported yet!', $action);
                break;
        }

//        if(strcmp($messageDecoder->{'Function'},"Chat") == 0){
//            echo 'tao dkhalet l function Chat'."\n";
//            foreach ($this->clients as $client) {
//                if ($from !== $client) {
//                    $messageJSON = array(
//                        "Function" => "ChatFromServeur",
//                        "message" => $messageDecoder->{"Message"},
//                        "From" => $messageDecoder->{"From"}
//                    );
//                    $this->clients->attach($from);
//                    $from->send(sprintf(json_encode($messageJSON)));
//                }
//            }



        echo 'kamalt OnMessage()'."\n";
    }





    public function ValideMot(string $mot):bool
    {
        $em = $this->container->get('doctrine')->getManager();

        $listmot = $em
            ->getRepository(Interditmot::class)
            ->findAll();

        foreach ($listmot as $list){
            echo $list->getMot();
            echo "\n";
            if(strcmp($list->getMot(),$mot) == 0){
                return false;
            }

        }
        return true;
    }

        //echo $messageDecoder;
//        if(strcmp($messageDecoder["Function"], "Chat") == 0){




//        echo vsprintf(
//            'id User = "%1$s"   || w name Tournament = "%2$s"'."\n", [
//                $messageDecoder["idUser"],
//                $messageDecoder["Tournament"]
//        ]);
    private function AddMessage(string $nom, string $id)
    {
        $chatMessage = new ChatMessage();
        $chatMessage->setIdUser(intval($id));
        $chatMessage->setMessage($nom);

        $em = $this->container->get('doctrine')->getManager();
        $em->persist($chatMessage);
        $em->flush();

    }

    private function saveWinner(string $param, string $param1)
    {

        $winner = new Winner();
        $winner->setNameTournament($param);
        $winner->setNameWinner($param1);

        $em1 = $this->container->get('doctrine')->getManager();
        $em1->persist($winner);
        $em1->flush();
    }


}




