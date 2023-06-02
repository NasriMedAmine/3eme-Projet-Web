<?php

namespace App\Controller;

use App\Entity\Interditmot;
use App\Entity\InTournament;
use App\Entity\NameGame;
use App\Entity\ResTournament;
use App\Entity\Tournament;
use App\Repository\ArticleRepository;
use App\Entity\User;
use App\Form\UserType;
use App\Repository\InTournamentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class MainController extends AbstractController
{




    /**
     * @Route("/main", name="main")

     */
    public function login(AuthenticationUtils $authenticationUtils,Request $request,EntityManagerInterface $entityManager): Response
    {
//        if($request->isXmlHttpRequest()) {
//            $idMagasin = $request->request->get('id');
//
//            return new Response("cbon ajax khdem");
//        }
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();





        $email = $request->request->get('_username');
        $printer = new ConsoleOutput();
        $printer->writeln('---------------------------------------');
        $printer->writeln('---------------------------------------');
        $printer->writeln('---------------------------------------');
        $printer->writeln('---------------------------------------');
        $printer->writeln('---------------------------------------');
        $printer->writeln("bech nchouf f request fama wale ");

        $printer->writeln('---------------------------------------');
        $printer->writeln('---------------------------------------');
        $printer->writeln('---------------------------------------');
        $printer->writeln('---------------------------------------');
        $printer->writeln('---------------------------------------');

        $users1 = $entityManager
            ->getRepository(User::class)
            ->findAll();
        $printer->writeln('---------------------------------------');
        $printer->writeln('---------------------------------------');

        foreach ($users1 as $compteur1) {
            if($compteur1->getPassword() ==$request->request->get('_password')  && $compteur1->getPseudo() ==$request->request->get('_username') )
            {
                $printer->writeln('---------------------------------------');
                $printer->writeln('---------------------------------------');
                $printer->writeln('psuedo shih w mot de passe shih');
                //$printer->writeln($users1[$compteur1]->getPassword());

                $resTournaments = $entityManager
                    ->getRepository(ResTournament::class)
                    ->findAll();


                foreach ($resTournaments as $compteur2){
                    if($compteur2->getPseudo() == $compteur1->getPseudo()){

                        $printer->writeln('---------------------------------------');
                        $printer->writeln('---------------------------------------');
                        $printer->writeln('hedha ta-o Responsable Tournoi');
                        return $this->render('main/index_RespNormal.html.twig', [
                            'user' => $compteur1,
                            'resTournament' =>$compteur2,
                        ]);

                    }
                }
                return $this->render('main/index_userNormal.html.twig', [
                    'user' => $compteur1,
                ]);


            }

        }





        return $this->render('main/index.html.twig', ['last_username' => $lastUsername, 'error' => $error ,'email' =>$email]);
    }

    /**
     * @Route("/show", name="show")

     */

    public function show(Request $request,EntityManagerInterface $entityManager):Response
    {
        $tournaments = $entityManager
            ->getRepository(Tournament::class)
            ->findAll();

        return $this->render('main/tournament.html.twig',[
            'tournaments'=>$tournaments
        ]);
    }

    /**
     * @Route("/OnClick", name="OnClick")

     */

    public function OnClick(Request $request,EntityManagerInterface $entityManager):Response
    {
        $name = $request->query->get('id');
        $em = $this->container->get('doctrine')->getManager();
        $rep = $em->getRepository(Tournament::class);


        $query = $rep->createQueryBuilder('a')
            ->where('a.tournamentName LIKE :key')
            ->setParameter('key' , '%'.$name.'%')->getQuery();

        //return $query->getResult();
//        $printer2 = new ConsoleOutput();
//        $printer2->writeln($name);
//        $printer2->writeln('---------------------------------------');
//        foreach ($query->getResult() as $client) {
//            $printer = new ConsoleOutput();
//            $printer->writeln('---------------------------------------');
//            $printer->writeln('---------------------------------------');
//            $printer->writeln('---------------------------------------');
//            $printer->writeln($name);
//            $pos = strpos($client->getTournamentName(), $name);
//            if($pos == false){
//                $printer->writeln('false');
//
//            }
//            else{
//                $printer->writeln('non false');
//
//            }
//
//        }

        return $this->render('main/Onclick.html.twig',[
            "lists"=> $query->getResult(),
            "nameNow" => $name
        ]);

//
//        $query = $rep->createQueryBuilder('a')
//            ->where( $rep->expr()->like('a.tournamentName', $rep->expr()->literal('%' . $name . '%')) )
//            ->getQuery()
//            ->getResult();

    }

    /**
     * @Route("/RoomMennuIndex", name="RoomMennuIndex")

     */
    public function RoomMennuIndex(Request $request,EntityManagerInterface $entityManager):Response
    {


        return $this->render('main/ChatMennu.html.twig');
    }



    /**
     * @Route("/addShow", name="addShow")

     */

    public function addShow(Request $request,EntityManagerInterface $entityManager):Response
    {
        $tournaments = $entityManager
            ->getRepository(Tournament::class)
            ->findAll();

        if($request->isXmlHttpRequest()) {
            $idUser = $request->query->get('idUser');
            $nomTournament = $request->query->get('nameTournament');
            $codeTournament = $request->query->get('codeTournament');
            $printer = new ConsoleOutput();
            $printer->writeln('---------------------------------------');
            $printer->writeln('---------------------------------------');
            $printer->writeln('---------------------------------------');
            $printer->writeln('---------------------------------------');
            $printer->writeln('brwoser aamal request ajax pour ajouter tournament to user');
            $printer->writeln($idUser);
            $printer->writeln($nomTournament);
            $printer->writeln($codeTournament);
            $printer->writeln('---------------------------------------');
            $printer->writeln('---------------------------------------');
            foreach ($tournaments as $compteur1 => $value) {
                if($tournaments[$compteur1]->getTournamentName() == $nomTournament && $tournaments[$compteur1]->getCode() == $codeTournament ){
                    $printer->writeln('---------------------------------------');
                    $printer->writeln('---------------------------------------');
                    $printer->writeln('nom w code mtaa tournament valide ');
                    $printer->writeln('---------------------------------------');
                    $printer->writeln($tournaments[$compteur1]->getTournamentName());
                    $printer->writeln($tournaments[$compteur1]->getCode());
//
//
                    $inTournament = new InTournament();
                    $inTournament->setIdUser($idUser);
                    $inTournament->setIdTournament($tournaments[$compteur1]->getIdTournament());
//                    $repInTournament = new InTournamentRepository();
//                    $repInTournament->add($inTournament);

                    $entityManager->persist($inTournament);
                    $entityManager->flush();
                    $printer->writeln('---------------------------------------');
                    $printer->writeln('cbon user w tournament tzedou f inTournament BD');
                    return $this->render('main/GoRoom.html.twig');
                    //return new Response("c bon f BD inTournament");

                }


            }


            $printer->writeln('---------------------------------------');
            $printer->writeln('---------------------------------------');
            $printer->writeln('nom w code mtaa tournament invalide ');
            $printer->writeln('---------------------------------------');

            return new Response("cbon ajax khdem w hedha message men aaned serveur");
        }

        return $this->render('main/tournament.html.twig',[
            'tournaments'=>$tournaments
        ]);
    }



    /**
     * @Route("/room", name="room")

     */

    public function room(Request $request,EntityManagerInterface $entityManager):Response{


        return $this->render('main/Room.html.twig');





    }

    /**
     * @Route("/email", name="email")

     */

    public function email(\Swift_Mailer $mailer, Request $request,EntityManagerInterface $entityManager):Response
    {
        $name = $request->query->get('nameWinner');

        $MyUserList = $entityManager
            ->getRepository(User::class)
            ->findBy(['pseudo' =>$name]);

        foreach ($MyUserList as $compteur1 => $value) {

            $message=(new \Swift_Message('Winner'))
                ->setFrom('Victorious.HighFive@gmail.com')
                ->setTo("mejriachrefff@gmail.com")
                ->setBody(
                    "<p>Bonjour </p></p>vous avez gagné'</p>'",
                    'text/html');
            $mailer->send($message);

        }




        return $this->render('main/Room.html.twig');





    }

//    public function main()
//    {
//
//        return $this->render('main/index.html.twig');
//    }
    /**
     * @Route("/organiser", name="organiser")

     */

    public function organiser(Request $request,EntityManagerInterface $entityManager):Response
    {

        return $this->render('main/organiser.html.twig');
    }





    /**
     * @Route("/SendEmailValide", name="SendEmailValide")

     */

    public function SendEmailValide(Request $request,EntityManagerInterface $entityManager):Response
    {

        
    }



    
    /**
     * @Route("/SendEmail", name="SendEmail")

     */

    public function SendEmail(Request $request,EntityManagerInterface $entityManager):Response
    {

        
    }






    /**
     * @Route("/addTournament", name="addTournament")

     */

    public function addTournament(Request $request,EntityManagerInterface $entityManager):Response
    {
        $games = $entityManager
            ->getRepository(NameGame::class)
            ->findAll();

        return $this->render('main/addTournament.html.twig',[
            'games' => $games
        ]);
    }


    /**
     * @Route("/addTournamentNew", name="addTournamentNew")

     */

    public function addTournamentNew(Request $request,EntityManagerInterface $entityManager):Response
    {
        $id = $request->query->get('id');
        $nom = $request->query->get('nameTournament');
        $game = $request->query->get('game');
        $type = $request->query->get('type');
        $code = $request->query->get('codeTournament');

        $nomObject = $entityManager
            ->getRepository(User::class)
            ->find($id);

        $tournament = new Tournament();
        $tournament->setCode($code);
        $tournament->setNameGame($game);
        $tournament->setType($type);
        $tournament->setTournamentName($nom);
        $tournament->setManagers($nomObject->getPseudo());

        $printer =new ConsoleOutput();
        $printer->writeln('---------------------------------------');
        $printer->writeln('---------------------------------------');
        $printer->writeln('---------------------------------------');
        $printer->writeln($nomObject->getPseudo());
        $entityManager->persist($tournament);
        $entityManager->flush();
        return new Response("saye f BD");







    }



    /**
     * @Route("/WatchIndex", name="WatchIndex")

     */

    public function WatchIndex(Request $request,EntityManagerInterface $entityManager):Response
    {




        return $this->render('main/WatchIndex.html.twig');
    }


    /**
     * @Route("/CheckTournament", name="CheckTournament")

     */

    public function CheckTournament(Request $request,EntityManagerInterface $entityManager):Response
    {
        $id = $request->query->get('id');

        $nomObject = $entityManager
            ->getRepository(User::class)
            ->find($id);



        $MyTournamentList = $entityManager
            ->getRepository(Tournament::class)
            ->findBy(['managers' =>$nomObject->getPseudo() ]);





        $printer =new ConsoleOutput();
        $printer->writeln('---------------------------------------');
        $printer->writeln('---------------------------------------');
        $printer->writeln('---------------------------------------');
        $printer->writeln('---------------------------------------');
        $printer->writeln('---------------------------------------');
        $printer->writeln('---------------------------------------');
        $printer->writeln('---------------------------------------');
        $printer->writeln($id);
        $printer->writeln('tao aamalt check my Tournaments');

        foreach ($MyTournamentList as $compteur1 => $value) {
            $printer->writeln('---------------------------------------');
            $printer->writeln($MyTournamentList[$compteur1]->getTournamentName());
            $printer->writeln($MyTournamentList[$compteur1]->getIdTournament());


        }





        return $this->render('main/MyTournament.html.twig',[
            'MyTournaments'=>$MyTournamentList
        ]);
    }


    /**
     * @Route("/CheckTournamentValide", name="CheckTournamentValide")

     */

    public function CheckTournamentValide(Request $request,EntityManagerInterface $entityManager):Response
    {
        $nameTournament = $request->query->get('nameTournament');

        return $this->render('main/GoRoom2.html.twig',[
            'nameTournament' => $nameTournament
        ]);






    }

    /**
     * @Route("/roomResp", name="roomResp")

     */

    public function roomResp(Request $request,EntityManagerInterface $entityManager):Response
    {
        $nameTournament = $request->query->get('nameTournament');

        return $this->render('main/RoomResp.html.twig',[
            'nameTournament' => $nameTournament
        ]);






    }

    /**
     * @Route("/BracetIndex", name="BracetIndex")

     */

    public function BracetIndex(Request $request,EntityManagerInterface $entityManager):Response
    {
        $nameTournament = $request->query->get('nameTournament');


//        $MyTournamentList = $entityManager
//            ->getRepository(Tournament::class)
//            ->findOneBy(['managers' =>$nameTournament ]);

        $printer =new ConsoleOutput();
        $printer->writeln('---------------------------------------');
        $printer->writeln('---------------------------------------');
        $printer->writeln($nameTournament);






        return $this->render('main/Bracet.html.twig');
    }







    /**
     * @Route("/BracetIndexPlayer", name="BracetIndexPlayer")

     */

    public function BracetIndexPlayer(Request $request,EntityManagerInterface $entityManager):Response
    {
        $nameTournament = $request->query->get('nameTournament');


//        $MyTournamentList = $entityManager
//            ->getRepository(Tournament::class)
//            ->findOneBy(['managers' =>$nameTournament ]);

        $printer =new ConsoleOutput();
        $printer->writeln('---------------------------------------');
        $printer->writeln('---------------------------------------');
        $printer->writeln($nameTournament);






        return $this->render('main/BracetPlayer.html.twig');
    }

}