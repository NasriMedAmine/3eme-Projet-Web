<?php

namespace App\Controller;

use App\Entity\Demande;
use App\Entity\NameGame;
use App\Entity\InTournahment;
use App\Entity\Tournament;
use App\Entity\ResTournament;
use App\Entity\Games;
use App\Entity\News;
use App\Entity\Player;
use App\Entity\Publicite;
use App\Entity\PubLike;
use App\Entity\Reclamation;
use App\Form\ReclamationType;
use App\Form\ResetPassType;
use App\Repository\ArticleRepository;
use App\Repository\PlayerRepository;
use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="main")

     */
    public function main(EntityManagerInterface $entityManager): Response
    {   $printer = new ConsoleOutput();

        $news = $entityManager
        ->getRepository(News::class)
        ->findAll();

    $games = $entityManager
        ->getRepository(Games::class)
        ->findAll();

        $publicites = $entityManager

        ->getRepository(Publicite::class)
        ->findAll();

        
        
        if( !$this->getUser() ){

            return $this->render('main/index.html.twig',[
                'publicites' => $publicites,
                'news' => $news,
                'games'=>$games,
    
            ]);

        }
          
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        // returns your User object, or null if the user is not authenticated
        // use inline documentation to tell your editor your exact User class
        /** @var \App\Entity\User $user */
        $user = $this->getUser();

        $printer->writeln('---------------------------------------');
        $printer->writeln('---------------------------------------');
        $printer->writeln('---------------------------------------');

        $printer->writeln('---------------------------------------');
        $printer->writeln('---------------------------------------');
        $resTournaments = $entityManager
                ->getRepository(ResTournament::class)
                ->findAll();
        $printer->writeln('---------------------------------------');
        foreach ($resTournaments as $compteur2){
            $printer->writeln('---------------------------------------');
            if($compteur2->getIdUser() == $user->getId()){
                $printer->writeln('---------------------------------------');

                $printer->writeln('---------------------------------------');
                $printer->writeln('---------------------------------------');
                $printer->writeln('hedha ta-o Responsable Tournoi');
               return $this->render('main/index.html.twig',[
                    'publicites' => $publicites,
                    'news' => $news,
                    'user' => $user,
                    'games'=>$games,
                    'resTournament' =>$compteur2,
                ]);
            }

        }

        $printer->writeln('---------------------------------------');
        $printer->writeln('---------------------------------------');
        $printer->writeln('---------------------------------------');
        $printer->writeln('---------------------------------------');
        

        $userlist = $entityManager
                ->getRepository(User::class)
                ->findAll();
        
        foreach ($userlist as $compteur2){
            if($compteur2->getId() == $user->getId()){
                
                $userForName = $compteur2;

            }            

        }

        $printer->writeln('---------------------------------------');$printer->writeln('---------------------------------------');$printer->writeln('---------------------------------------');$printer->writeln('---------------------------------------');$printer->writeln('---------------------------------------');
        $printer->writeln('alooooooooooooooooooooooooooooo');
        $printer->writeln($user->getPseudo());        
        return $this->render('main/index.html.twig',[
            'publicites' => $publicites,
            'news' => $news,
            'games'=>$games,
            'user' => $user,
            'userName' => $userForName,


        ]);
      
    }



    // /**
    //  * @Route("/", name="main")
    //  */
    // public function news(EntityManagerInterface $entityManager): Response
    // {
    //     $publicites = $entityManager ->getRepository(Publicite::class)
    //         ->findAll();

    //     $news = $entityManager
    //         ->getRepository(News::class)
    //         ->findAll();

    //     return $this->render('main/index.html.twig', [
    //         'news' => $news,
    //         'publicites' => $publicites,
    //     ]);
    // }




    /**
     * @Route("/frantpubgen", name="app_publicite_showpubge")
     */
    public function showpubge( EntityManagerInterface $entityManager): Response
    {
        $publicites = $entityManager

            ->getRepository(Publicite::class)
            ->findAll();
        $like = $entityManager
            ->getRepository(Publike::class)
            ->findAll();
        return $this->render('publicite/frontgeneral.html.twig',[
            'publicites' => $publicites,
            'like'=>$like
        ]);
    }

    /**
     * @Route("/frantpubdet/{id}", name="app_publicite_showpubdet")
     */
    public function showpubde($id, EntityManagerInterface $entityManager): Response
    {
        $publicites = $entityManager
            ->getRepository(Publicite::class)
            ->find($id);
        return $this->render('publicite/frontdet.html.twig',[
            'publicites' => $publicites,

        ]);
    }



    /**
     * @Route("/tarif", name="app_tarif")
     */
    public function showtarif( EntityManagerInterface $entityManager): Response
    {
        return $this->render('main/tarif.html.twig');
    }

    /**
     * @Route("/orga", name="app_orga")
     */
    public function showorga( EntityManagerInterface $entityManager): Response
    {
        return $this->render('main/organisation.html.twig');
    }

    /**
     * @Route("/part", name="app_parti")
     */
    public function showparti( EntityManagerInterface $entityManager): Response
    {
        return $this->render('main/partisipation.html.twig');
    }
    /**
     * @Route("/demandevalid", name="app_demvali")
     */
    public function showdemand( EntityManagerInterface $entityManager): Response
    {

        /*return $this->render('player/show.html.twig', [
            'player' => $player,
        ]);*/
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        // returns your User object, or null if the user is not authenticated
        // use inline documentation to tell your editor your exact User class
        /** @var \App\Entity\User $user */
        $user = $this->getUser();
        $player=$this->getDoctrine()->getRepository(Player::class)->find($user->getId());
        return $this->render('main/demandevalid.html.twig',[
            'player'=>$player,
            'user' => $user,
        ]);
    }



    /**
     * @Route("/validationOK", name="validationOK")
     */
    public function validationOK(Request $request ,EntityManagerInterface $entityManager ,UserRepository $userrep,PlayerRepository $res): Response
    {
        $demande = new Demande();
        $print = new ConsoleOutput();
        $print->writeln("----------------------------------------------");
      //  $id = $request->query->get('idUser');
      //  $print->writeln($id);

       // $user = $userrep->find($id);
       // $print->writeln($user->getUsername());
        //$player=$res->find($idPlayer);



       /* $print->writeln("----------------------------------------------");

        $demande->setIduserAchref($id);
        $print->writeln("----------------------------------------------");

        //$entityManager->persist($demande);
        //$entityManager->flush();
        $print->writeln("----------------------------------------------");*/
        $demande->setIduser($userrep->findOneBy(array('mail'=>$this->getUser()->getUsername())));
        $demande->setTypedemandeur("Personne");

        $em=$this->getDoctrine()->GetManager();
        $em->persist($demande);
        $em->flush();

        return $this->render('main/demandevalid.html.twig',[
       //    'player'=>$player,
       //     'user' => $user,
            'demande' => $demande,

        ]);
    }
    /**
     * @Route("/validationSoc", name="validationSoc")
     */
    public function validationSoc(Request $request ,EntityManagerInterface $entityManager ,UserRepository $userrep,PlayerRepository $res): Response
    {
        $nom=$request->get('nameaa');
        $adress=$request->get('adressaa');
        $code=$request->get('codeaa');
        $demande = new Demande();

        $demande->setIduser($userrep->findOneBy(array('mail'=>$this->getUser()->getUsername())));
        $demande->setTypedemandeur("Societe");
        $demande->setNomsociete($nom);
        $demande->setAdressesociete($adress);
        $demande->setCodetva($code);

        $em=$this->getDoctrine()->GetManager();
        $em->persist($demande);
        $em->flush();

        return $this->render('main/demandevalid.html.twig',[
            //    'player'=>$player,
            //     'user' => $user,
            'demande' => $demande,

        ]);
    }























            //jdid






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
    //                 $inTournament = new InTournament();
    //                 $inTournament->setIdUser($idUser);
    //                 $inTournament->setIdTournament($tournaments[$compteur1]->getIdTournament());
    // //                    $repInTournament = new InTournamentRepository();
    // //                    $repInTournament->add($inTournament);

    //                 $entityManager->persist($inTournament);
    //                 $entityManager->flush();
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