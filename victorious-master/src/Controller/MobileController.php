<?php

namespace App\Controller;

use App\AppBundle\Servers\Singleton;
use App\Entity\Chat;
use App\Entity\Demande;
use App\Entity\Player;
use App\Entity\Publicite;
use App\Entity\Reclamation;
use App\Entity\ResTournament;
use App\Entity\Team;
use App\Entity\Tournament;
use App\Entity\User;
use App\Repository\DemandeRepository;
use App\Repository\PlayerRepository;
use App\Repository\PubliciteRepository;
use App\Repository\ReclamationRepository;
use App\Repository\TeamRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class MobileController extends AbstractController
{
    /**
     * @Route("/mobile", name="app_mobile")
     */
    public function index(): Response
    {
        return $this->render('mobile/index.html.twig', [
            'controller_name' => 'MobileController',
        ]);
    }
    /**
     * @Route("/useraffjson",name="mobileaffiche")
     */
    public function useraff(SerializerInterface $serializer)
    {
        $repository= $this->getDoctrine()->getRepository(User::class);
        $users = $repository->findAll();
        $json = $serializer->serialize($users, 'json', ['groups' => 'userlist']);
        return new JsonResponse($json);
    }



    /**
     * @Route("/teamaffjson",name="mobileaffiche")
     */
    public function teamaff(SerializerInterface $serializer)
    {
        $repository= $this->getDoctrine()->getRepository(Team::class);
        $users = $repository->findAll();
        $json = $serializer->serialize($users, 'json', ['groups' => 'teamlist']);




        return new JsonResponse($json);
    }

    /**
     * @Route("/create", name="mobiladd")
     */
    public function useradd(Request $request, EntityManagerInterface $em, UserPasswordEncoderInterface $userPasswordEncoder,\Swift_Mailer $mailer)
    {
        $user = new user();
        $email = $request->query->get("mail");
        $pseudo = $request->query->get("pseudo");
        $dob = new \DateTime($request->query->get("dateofbirth"));
        $password = $request->query->get("password");


        $user->setMail($email);
        $user->setPseudo($pseudo);
        $user->setDateofbirth($dob);
        $user->setImage('default.jpg');
        $user->setPassword(
            $userPasswordEncoder->encodePassword(
                $user,
                (string)$password
            )
        );
        $user->setActivationToken(md5(uniqid()));
        $em->persist($user);
        $em->flush();

        // do anything else you need here, like send an email
        $message=(new \Swift_Message('Account activation'))
            ->setFrom('Victorious.HighFive@gmail.com')
            ->setTo($user->getMail())
            ->setBody(
                $this->renderView(
                    'emails/activation.html.twig',['token'=>$user->getActivationToken()]
                ),'text/html'
            );
        $mailer->send($message);

        return new JsonResponse('succees');
    }

    /**
     * @Route("/edit",name="mobileedit");
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return JsonResponse
     */
    public function mobilmodif(Request $request, EntityManagerInterface $em)
    {
        $repository=$this->getDoctrine()->getRepository(User::class);
        $id=$request->query->get("id");
        $user=$repository->find($id);


        $email = $request->query->get("mail");
        $pseudo = $request->query->get("pseudo");
        $password = $request->query->get("password");
        $dob = new \DateTime($request->query->get("dateofbirth"));

        $user->setMail($email);
        $user->setPseudo($pseudo);
        $user->setPassword($password);
        $user->setDateofBirth($dob);

        $em->flush();

        //return new JsonResponse($user->getPseudo());
        return new JsonResponse("modifid succefuly");

    }
    /**
     * @Route ("/del", name="mobildel")
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return JsonResponse
     */
    public function mobildel(Request $request,EntityManagerInterface $em): JsonResponse
    {
        $repository=$this->getDoctrine()->getRepository(User::class);
        $id =$request->get("id");
        $user=$repository->find($id);

        $em->remove($user);
        $em->flush();



        return new JsonResponse("deleted succefuly");
    }



    /**
     * @Route("/mobilsignin",name="mobilsignin")
     */
    public function mobilsign(Request $request,EntityManagerInterface $entityManager)
    {
        $rep = $this->getDoctrine()->getRepository(User::class);
        $email = $request->query->get('mail');
        $password = $request->query->get('password');
        $user = $rep->findOneBy(['mail' => $email]);
        //return new JsonResponse(password_hash($password,PASSWORD_ARGON2ID));


        if($user)
        {
            $token=$user->getActivationToken();
            if(password_verify($password,$user->getPassword()))
            {
                if($token!=null)
                {
                    return new JsonResponse('Account blocked');
                }
                else {
                    $printer =new ConsoleOutput();
                    $printer->writeln('---------------------------------------');
                    $printer->writeln('---------------------------------------');
                    $mobil = new User();
                    $printer->writeln('---------------------------------------');
                    $mobil->setId($user->getId());
                    $printer->writeln('---------------------------------------');
                    $mobil->setPseudo($user->getPseudo());
                    $printer->writeln('---------------------------------------');
                    $mobil->setPassword($user->getPassword());
                    $printer->writeln('---------------------------------------');
                    $mobil->setMail($user->getMail());
                    $printer->writeln('---------------------------------------');
                    //$mobil->setRoles($user->getRoles()[0]);
                    $mobil->setDateofbirth($user->getDateofBirth());

                    $printer->writeln('---------------------------------------');
                    $serializer = new \Symfony\Component\Serializer\Serializer([new ObjectNormalizer()]);
                    $printer->writeln('---------------------------------------');
                    $formatted = $serializer->normalize($mobil);
                    $printer->writeln('---------------------------------------');


                    $resTournaments =$resTournaments = $entityManager
                        ->getRepository(ResTournament::class)
                        ->findAll();;
                    foreach ($resTournaments as $compteur2){
                        $printer->writeln('---------------------------------------');
                        if($compteur2->getIdUser() == $user->getId()){
                            $printer->writeln('---------------------------------------');

                            $printer->writeln('---------------------------------------');
                            $printer->writeln('---------------------------------------');
                            $printer->writeln('hedha ta-o Responsable Tournoi');
                            $serializer = new \Symfony\Component\Serializer\Serializer([new ObjectNormalizer()]);
                            $printer->writeln('hedha Responsable Mobil');
                            $formatted = $serializer->normalize($user);
                            $printer->writeln('---------------------------------------');
                            return new JsonResponse($formatted);

                        }

                    }

                    return new JsonResponse($formatted);
                    //return new JsonResponse('Login success');
                }
            }
            return new JsonResponse('password invalid');
        }
        return new JsonResponse('user not found');
    }













        //    amine


    /**
     * @Route("/AddTournamentMobile",name="AddTournamentMobile")
     */
    public function AddTournamentMobile(Request $request,EntityManagerInterface $entityManager):JsonResponse
    {
        $nameTournament = $request->query->get('nameTournament');
        $Responsable = $request->query->get('Responsable');
        $code = $request->query->get('code');
        $NameGame = $request->query->get('NameGame');
        $type = $request->query->get('type');



        $tournament = new Tournament();
        $tournament->setCode($code);
        $tournament->setNameGame($NameGame);
        $tournament->setType($type);
        $tournament->setTournamentName($nameTournament);
        $tournament->setManagers($Responsable);

        $entityManager->persist($tournament);
        $entityManager->flush();



        $messageJSONAddTournament = array(
            "Function" => "ChatFromServeurMe",

        );
        return new JsonResponse($messageJSONAddTournament);
        //return new Response("AddTournament1");






//        $messageJSON = array(
//            "Function" => "cbon Mobil",
//
//        );
//        return new JsonResponse($messageJSON);
    }






    /**
     * @Route("/ShowTournamentMobile",name="ShowTournamentMobile")
     */
    public function ShowTournamentMobile(Request $request,EntityManagerInterface $entityManager,SerializerInterface $serializer):JsonResponse
    {
        $tournaments = $entityManager
            ->getRepository(Tournament::class)
            ->findAll();
        //$json = $serializer->serialize($tournaments, 'json');


        if ($tournaments) {
            return new JsonResponse($tournaments, 200);
        } else {
            return new JsonResponse([], 204);


            //return new JsonResponse($json);

        }
    }





    /**
     * @Route("/CheckTournamentMobile",name="CheckTournamentMobile")
     */
    public function CheckTournamentMobile(Request $request,EntityManagerInterface $entityManager,SerializerInterface $serializer):JsonResponse
    {


        $tournaments = $entityManager
            ->getRepository(Tournament::class)
            ->findAll();


            $nomTournament = $request->query->get('nameTournament');
            $codeTournament = $request->query->get('code');
            $printer = new ConsoleOutput();
            $printer->writeln('---------------------------------------');
            $printer->writeln('---------------------------------------');
            $printer->writeln('---------------------------------------');
            $printer->writeln('---------------------------------------');
            $printer->writeln('brwoser aamal request ajax pour ajouter tournament to user');
            //$printer->writeln($idUser);
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

                    $printer->writeln('---------------------------------------');
                    $printer->writeln('cbon user w tournament tzedou f inTournament BD');
                    $messageJSON = array(
                        "Function" => "CheckTournamentMobile",
                        "Is" => "valideCheckTournamentMobileYes",
                        "IdGroupe"=> $tournaments[$compteur1]->getIdTournament()
                    );

                    return new JsonResponse($messageJSON, 200);

                    //return new Response("c bon f BD inTournament");

                }


            }


            $printer->writeln('---------------------------------------');
            $printer->writeln('---------------------------------------');
            $printer->writeln('nom w code mtaa tournament invalide ');
            $printer->writeln('---------------------------------------');

            $messageJSON = array(
                "Function" => "CheckTournamentMobile",
                "Is" => "valideCheckTournamentMobileNo",
            );

            return new JsonResponse($messageJSON, 200);
        }








    /**
     * @Route("/ShowTournamentMobileMot",name="ShowTournamentMobileMot")
     */
    public function ShowTournamentMobileMot(Request $request,EntityManagerInterface $entityManager,SerializerInterface $serializer):JsonResponse
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

        if ($query->getResult()) {
            return new JsonResponse($query->getResult(), 200);
        } else {
            return new JsonResponse([], 204);


            //return new JsonResponse($json);

        }



    }

      /**
     * @Route("/AddTeamMobile",name="AddTeamMobile")
     */
    public function AddTeamMobile(Request $request,EntityManagerInterface $entityManager,NormalizerInterface $normal):JsonResponse
    {
        $teamName1 = $request->query->get('teamName');
        $nbPlayers1 = $request->query->get('nbPlayers');
        $players1 = $request->query->get('players');


        $favoriteGames1 = $request->query->get('favoriteGames');
        $teamDesciption1 = $request->query->get('teamDesciption');



        $team76 = new Team();
        $team76->setTeamName($teamName1);
        $team76->setNbPlayers($nbPlayers1);
        $team76->setPlayers($players1);

        $team76->setFavoriteGames($favoriteGames1);
        $team76->setTeamDesciption($teamDesciption1);

        $entityManager->persist($team76);
        $entityManager->flush();


        $jsoncontent=$normal->normalize($team76);
        return new JsonResponse(json_encode($jsoncontent));
    }


    /**
     * @Route("/deleteteamjson", name="app_team_deletejson")
     */
    public function deleteteamjson(Request $request ,TeamRepository  $repository,NormalizerInterface $Normalizer)
    {
        $idTeam=$request->get("idTeam");
        $team=$repository->find($idTeam);
        $em=$this->getDoctrine()->getManager();
        $em->remove($team);
        $em->flush();

        $jsonContent=$Normalizer->normalize($team);


        return new JsonResponse(($jsonContent));
    }



    /******************Modifier team*****************************************/
    /**
     * @Route("/updateTeam", name="update_reclamation")
     */
    public function modifierTeam(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $team = $this->getDoctrine()->getManager()
            ->getRepository(Team::class)
            ->find($request->get("idTeam"));




        $team->setTeamName($request->get("teamName"));
        $team->setPlayers($request->get("players"));
        $team->setFavoriteGames($request->get("favoriteGames"));
        $team->setTeamDesciption($request->get("teamDesciption"));



        $em->persist($team);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($team);
        return new JsonResponse("Team a ete modifiee avec success.");

    }
    /**
         * @Route("/ShowTeamMobile",name="ShowTeamMobile")
         */
        public function ShowTeamMobile(Request $request,EntityManagerInterface $entityManager,SerializerInterface $serializer):JsonResponse
    {
        $team = $entityManager
            ->getRepository(Team::class)
            ->findAll();
        //$json = $serializer->serialize($tournaments, 'json');


        if ($team) {
            return new JsonResponse($team, 200);
        } else {
            return new JsonResponse([], 204);


            //return new JsonResponse($json);

        }
    }









































    /**
     * @Route("/showallpub", methods={"GET"})
     */
    public function showallpub(NormalizerInterface $Normalizer,Request $request, PubliciteRepository $publiciteRepository): Response
    {
        $pub = $this->getDoctrine()->getRepository(Publicite::class)->findAll();
        $jsonContent = $Normalizer->normalize($pub);
        if ( $jsonContent) {
            return new JsonResponse( $jsonContent, 200);
        } else {
            return new JsonResponse([], 204);
        }
    }



    /**
     * @Route("/showpub")
     */
    public function show(NormalizerInterface $Normalizer,Request $request, PubliciteRepository $publiciteRepository): Response
    {
        $pub = $this->getDoctrine()->getRepository(Publicite::class)->find((int)$request->get("id"));
        $jsonContent = $Normalizer->normalize($pub);
        if ($jsonContent) {
            return new JsonResponse($jsonContent, 200);
        } else {
            return new JsonResponse([], 204);
        }
    }


    /**
     * @Route("/addpub")
     */
    public function add(Request $request): JsonResponse
    {
        $publicite = new Publicite();

        return $this->manage($publicite,  $request);
    }


    /**
     * @Route("/editpub")
     */
    public function edit(Request $request,  PubliciteRepository $publiciteRepository ): Response
    {
        $publicite = $publiciteRepository ->find((int)$request->get("id"));

        if (!$publicite) {
            return new JsonResponse(null, 404);
        }

        return $this->manage($publicite,  $request);
    }


    public function manage($publicite,  $request): JsonResponse
    {


        $file = $request->files->get("file");
        if ($file) {
            $imageFileName = md5(uniqid()) . '.' . $file->guessExtension();

            try {
                $file->move($this->getParameter('photos_directory'), $imageFileName);
            } catch (FileException $e) {
                dd($e);
            }
        } else {
            if ($request->get("image")) {
                $imageFileName = $request->get("image");
            } else {
                $imageFileName = "null";
            }
        }

        $publicite->setUp(
            $imageFileName,
            $request->get("nom"),
            $request->get("description"),
            $request->get("video"),
            $request->get("docs"),


            $request->get("dateDebut"),
            $request->get("dateFin"),
            $request->get("nomProprietaire "),
            $request->get("prix"),
        );

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($publicite);
        $entityManager->flush();

        return new JsonResponse($publicite, 200);
    }




    /**
     * @Route("/deletepubjson", name="deletepubjson")
     */
    public function deletepubjson(Request $request ,PubliciteRepository $repository,NormalizerInterface $Normalizer)
    {
        $id=$request->get("id");
        $pub=$repository->find($id);
        $em=$this->getDoctrine()->getManager();
        $em->remove($pub);
        $em->flush();

        $jsonContent=$Normalizer->normalize($pub);


        return new JsonResponse(($jsonContent));
    }



    /**
     * @Route("/deleteAllpub")
     */
    public function deleteAll(EntityManagerInterface $entityManager, PubliciteRepository $publiciteRepository): Response
    {
        $publicites = $publiciteRepository->findAll();

        foreach ($publicites as $publicite) {
            $entityManager->remove($publicite);
            $entityManager->flush();
        }

        return new JsonResponse([], 200);
    }


    /**
     * @Route("/image/{image}", methods={"GET"})
     */
    public function getPicture(Request $request): BinaryFileResponse
    {
        return new BinaryFileResponse(
            $this->getParameter('photos_directory') . "/" . $request->get("image")
        );
    }


















    /**
     * @Route("/listedemande", name="liste")
     * @param DemandeRepository $demandeRepository
     */
    public function showpub(Request $request, DemandeRepository $demandeRepository, NormalizerInterface $normalizer): Response
    {
        $repo = $this->getDoctrine()->getRepository(Demande::class)->findAll();

        $json = $normalizer->normalize($repo, 'json', ['groups' => 'post:read']);
        dd($json);
        return new Response (json_encode($json));

    }





    /**
     * @Route("/deletedemande")
     */
    public function delete(Request $request, EntityManagerInterface $entityManager, DemandeRepository $demandeRepository): JsonResponse
    {
        $dem = $demandeRepository->find((int)$request->get("id"));

        if (!$dem) {
            return new JsonResponse(null, 200);
        }

        $entityManager->remove($dem);
        $entityManager->flush();

        return new JsonResponse([], 200);
    }

    /**
     * @Route("/showreclam", methods={"GET"})
     */
    public function showjsonreclam(NormalizerInterface $Normalizer): Response
    {
        $rec = $this->getDoctrine()->getRepository(Reclamation::class)->findAll();
        $jsonreclam = $Normalizer->normalize($rec);

        dd($jsonreclam);

        return new JsonResponse(($jsonreclam));

    }

    /**
     * @Route("/showreclamation", name="listee")
     * @param ReclamationRepository $reclamationRepository
     */
    public function showreclam(Request $request, ReclamationRepository $reclamationRepository , NormalizerInterface $normalizer): Response
    {
        $rec  = $this->getDoctrine()->getRepository(Reclamation::class)->findAll();

        $json = $normalizer->normalize($rec, 'json', ['groups' => 'reclam']);
        dd($json);
        return new Response (json_encode($json));

    }









    /**
     * @Route("/modifierpub", name="modifierpub")
     */
    public function modifierpub(Request $request) {

        $em = $this->getDoctrine()->getManager();
        $pub = $this->getDoctrine()->getManager()
            ->getRepository(Publicite::class)
            ->find($request->get("id"));






        $pub->setCode($request->get("nom"));
        $pub->setNomProprietaire($request->get("nomProprietaire-"));
        $pub->setDescription($request->get("description"));







        $em->persist($pub);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($pub);
        return new JsonResponse("Team a ete modifiee avec success.");

    }














/**
* @Route("/ShowPlayerMobile",name="ShowPlayerMobile")
*/
    public function ShowPlayerMobile(Request $request,EntityManagerInterface $entityManager,SerializerInterface $serializer):JsonResponse
    {
        $tournaments = $entityManager
            ->getRepository(Player::class)
            ->findAll();
        //$json = $serializer->serialize($tournaments, 'json');


        if ($tournaments) {
            return new JsonResponse($tournaments, 200);
        } else {
            return new JsonResponse([], 204);


            //return new JsonResponse($json);

        }
    }
    /**
     * @Route("/deleteplayerjson", name="deleteplayerjson")
     */
    public function deleteplayerjson(Request $request ,PlayerRepository  $repository,NormalizerInterface $Normalizer)
    {
        $id=$request->get("id");
        $team=$repository->find($id);
        $em=$this->getDoctrine()->getManager();
        $em->remove($team);
        $em->flush();

        $jsonContent=$Normalizer->normalize($team);


        return new JsonResponse(($jsonContent));
    }














    /**
     * @Route("/ShowTeamMobileMot",name="ShowTeamMobileMot")
     */
    public function ShowTeamMobileMot(Request $request,EntityManagerInterface $entityManager,SerializerInterface $serializer):JsonResponse
    {
        $name = $request->query->get('id');
        $em = $this->container->get('doctrine')->getManager();
        $rep = $em->getRepository(Team::class);


        $query = $rep->createQueryBuilder('a')
            ->where('a.teamName LIKE :key')
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

        if ($query->getResult()) {
            return new JsonResponse($query->getResult(), 200);
        } else {
            return new JsonResponse([], 204);


            //return new JsonResponse($json);

        }



    }






    /**
     * @Route("/AddteamJson", name="AddteamJson")
     */
    public function AddTeamJson(Request $request,NormalizerInterface $Normalizer){

        $team=new Team();
        $em=$this->getDoctrine()->getManager();
        $team->setTeamName($request->get('teamName'));

        $team->setNbPlayers($request->get('nbPlayers'));

        $team->setPlayers($request->get('players'));

        $team->setFavoriteGames($request->get('favoriteGames'));

        $team->setTeamDesciption($request->get('teamDesciption'));





        $em->persist($team);
        $em->flush();


        $jsonContent=$Normalizer->normalize($team);
        return new Response(json_encode($jsonContent));
    }




    /**
     * @Route("/AddMessageJson", name="AddMessageJson")
     */
    public function AddMessageJson(Request $request,NormalizerInterface $Normalizer){
        $idUser = $request->query->get('idUser');
        $message = $request->query->get('message');
        $printer2 = new ConsoleOutput();
        $printer2->writeln('---------------------------------------');
        $printer2->writeln('---------------------------------------');

        $printer2->writeln('---------------------------------------');

        $printer2->writeln('---------------------------------------');
        $printer2->writeln('---------------------------------------');
        $printer2->writeln('---------------------------------------');
        $printer2->writeln('---------------------------------------');
        $printer2->writeln('---------------------------------------');
        $printer2->writeln('---------------------------------------');
        $printer2->writeln('---------------------------------------');

        $printer2->writeln($idUser);
        $printer2->writeln($message);
        $chat = Singleton::getInstance();


        foreach ($chat->getClients() as $client) {
                $messageJSON = array(
                    "Function" => "ChatFromServeur",
                    "message" => $message,
                    "From" =>$idUser
                );
                $client->send(sprintf(json_encode($messageJSON)));

            echo "saye baathet l Browser message \n";
        }






        return new Response("valide message");
    }











}