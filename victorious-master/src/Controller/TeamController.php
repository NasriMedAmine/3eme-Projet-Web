<?php

namespace App\Controller;

use App\Entity\Team;
use App\Entity\User;
use App\Entity\Games;
use App\Entity\Player;
use App\Form\TeamType;
use App\Entity\Notification;
use App\Repository\TeamRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\NotificationRepository;
use Knp\Component\Pager\PaginatorInterface;

use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\Request;
use MercurySeries\FlashyBundle\FlashyNotifier;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class TeamController extends AbstractController
{
     /**
     * @Route("/back", name="app_back_index", methods={"GET"})
     */
    public function index(Request $request ,TeamRepository $rep,FlashyNotifier $flashy, PaginatorInterface $paginator,NotificationRepository $repository)
    {
        $notification=$repository->sountq();
        $donnees=$this->getDoctrine()->getRepository(Team::class)->findAll();

        $teams= $paginator->paginate(
            $donnees,
            $request->query->getInt('page',1),
            4
        );
        $teams4=$rep->orderbyname();
        $flashy->success('Event created!', 'http://your-awesome-link.com');
        return $this->render('team/back.html.twig', [
            'teams' => $teams,
            'teams4' => $teams4,
            'notification'=>$notification,
        ]);
    }
     /**
     * @Route("/tirier", name="trie")
     */
    public function trienom(Request $request ,TeamRepository  $repository,NotificationRepository $rep, PaginatorInterface $paginator){
       
        $donnees=$repository->orderbyname();
        $notification=$rep->sountq();
        $teams4=$repository->orderbyname();
        $teams4= $paginator->paginate(
            $donnees,
            $request->query->getInt('page',1),
            4
        );
        
        return $this->render('team/orderbyname.html.twig',
        ['teams4'=>$teams4,
        'notification'=>$notification,]);
    }
    /**
     * @Route("/tirierplayer", name="trieplayer")
     */
    public function trieplayer(Request $request ,TeamRepository  $repository,NotificationRepository $rep, PaginatorInterface $paginator){
       
        $donnees=$repository->orderbyplayer();
        $notification=$rep->sountq();
        $teams5=$repository->orderbyname();
        $teams5= $paginator->paginate(
            $donnees,
            $request->query->getInt('page',1),
            4
        );
        
        return $this->render('team/orderbyplayer.html.twig',
        ['teams5'=>$teams5,
        'notification'=>$notification,]);
    }
     /**
     * @Route("/stat", name="stat")
     */
    public function stat(EntityManagerInterface $entityManager,TeamRepository  $repository)
    {   $team=$repository->findAll();
       $nom=[];
       $nb=[];
       foreach($team as $team){
        $nom[]=$team->getTeamName();  
        $nb[]=$team->getNb(); 
       }
        return $this->render('team/stat.html.twig', [
          'nom'=>json_encode($nom),
          'nb'=>json_encode($nb),
        ]);
    }
    /**
     * @Route("/team" , name="app_team_index")
     */
    public function team(EntityManagerInterface $entityManager,TeamRepository  $repository): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        // returns your User object, or null if the user is not authenticated
        // use inline documentation to tell your editor your exact User class
        /** @var \App\Entity\User $user */
        $user = $this->getUser();
    
        
        $teams = $entityManager
            ->getRepository(Team::class)
            ->findAll();
           
            $teams2=$repository->orderby();

        return $this->render('team/team.html.twig', [
            'teams' => $teams,
            'teams2' => $teams2,
       
            'user' => $user,
        ]);
       
    }
    /**
     * @Route("/{idTeam}/edit" , name="app_team_profile")
     */
    public function teamProfile(EntityManagerInterface $entityManager,FlashyNotifier $flashy,$idTeam ,TeamRepository  $repository): Response
    {
        $teams=$repository->find($idTeam);
        $teams1=$repository->findAll();

          $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        // returns your User object, or null if the user is not authenticated
        // use inline documentation to tell your editor your exact User class
        /** @var \App\Entity\User $user */
        $user = $this->getUser();
        $player=$this->getDoctrine()->getRepository(Player::class)->find($user->getId());
         
        $flashy->success('Event created!', 'http://your-awesome-link.com');
        return $this->render('team/teamProfile.html.twig', [
            'teams' => $teams,
            'teams1' => $teams1,
            'player' => $player,
            'user' =>$user,
           
        ]);
    }
     /**
     * @Route("/team1" , name="app_team1_index")
     */
    public function team1(TeamRepository  $repository): Response
    {
        $team=$repository->findAll();
        $team2=$repository->orderby();
        
          

        return $this->render('team/show.html.twig', [
            'team' => $team,
            'team2' => $team2,
           
        ]);
    }
    

   
       /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     *  @Route("/new", name="app_team_new")
     */
    function add(Request $request){
        $team=new Team();
        
      

        $rep=$this->getDoctrine()->getRepository(Team::class);
        $form=$this->createForm(TeamType::class,$team);
        $form->add('ajouter',SubmitType::class);
        $form->HandleRequest($request);
      
        if($form->isSubmitted() && $form->isValid()){
            $team->setPlayers("farouk");
            $em=$this->getDoctrine()->getManager();
            $em->persist($team);
            $em->flush();
            return $this->redirectToRoute('app_team_index');
        }
        return $this->render('team/new.html.twig',[
            'form' => $form->createView() ]);
    }
    /**
    * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     *  @Route("/backnew", name="app_back_new")
     */
    function addback(Request $request,FlashyNotifier $flashy){
        $flashy->success('Team created!', 'http://your-awesome-link.com');
        $team=new team();
        $rep=$this->getDoctrine()->getRepository(Team::class);
        $form=$this->createForm(TeamType::class,$team);
      
        $form->HandleRequest($request);
      
        if($form->isSubmitted() && $form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $em->persist($team);
            $em->flush();
            return $this->redirectToRoute('app_back_index');
        }
        return $this->render('team/backnew.html.twig',[
            'form' => $form->createView() ]);
    }
    
     /**
     * @Route("/editback\{idTeam}", name="app_back_edit", methods={"GET", "POST"})
     */
    public function editback(TeamRepository  $repository,$idTeam,Request $request)
    {
        $teams=$repository->find($idTeam);
        $formA=$this->createForm(TeamType::class,$teams);
        $formA->add('Update',SubmitType::class);
        $formA->HandleRequest($request);
      
        if($formA->isSubmitted() && $formA->isValid()){
            $em=$this->getDoctrine()->getManager();
        
            $em->flush();
            return $this->redirectToRoute('app_back_index');
    }
    return $this->render('team/editback.html.twig',[
        'form' => $formA->createView() ]);
       
    }
    


    /**
     * @Route("/", name="app_team_show", methods={"GET"})
     */
    public function show(TeamRepository  $repository): Response
    {
        $teams=$repository->findAll();
        return $this->render('team/show.html.twig', [
            'teams' => $teams,
        ]);
    }

    /**
     * @Route("/teamprofilejson" , name="app_team_profilejson")
     */
    public function teamProfilejson(NormalizerInterface $Normalizer,EntityManagerInterface $entityManager,Request $Request,TeamRepository  $repository): Response
    {  $idTeam=$Request->get("idTeam");
        $teams=$repository->find($idTeam);

         
         
        $jsonContent=$Normalizer->normalize($teams);
      
       
        return new JsonResponse(($jsonContent));
           
           
        
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
             
        $team->setPassword($request->get('password'));
             
        $team->setTeamMail($request->get('teamMail'));
             
        $team->setLogo($request->get('logo'));
                          
      
     
      $em->persist($team);
      $em->flush();
     

      $jsonContent=$Normalizer->normalize($team);
      return new Response(json_encode($jsonContent));
    }

      /**
      * @Route("/displayTeams", name="display_reclamation")
      */
     public function allRecAction()
     {

         $reclamation = $this->getDoctrine()->getManager()->getRepository(Team::class)->findAll();
         $serializer = new Serializer([new ObjectNormalizer()]);
         $formatted = $serializer->normalize($reclamation);

         return new JsonResponse($formatted);

     }
   

/**
     * @Route("/jeu", name="app_jeu_show", methods={"GET"})
     */
    public function jeu(TeamRepository  $repository,EntityManagerInterface $entityManager): Response
    {       $games = $entityManager
        ->getRepository(Games::class)
        ->findAll();
        $teams=$repository->findAll();
        return $this->render('team/jeu.html.twig', [
            'teams' => $teams,
            'games' => $games,
        ]);
    }
    /**
     * @Route("/edit\{idTeam}", name="app_team_edit", methods={"GET", "POST"})
     */
    public function edit(TeamRepository  $repository,$idTeam,Request $request)
    {
        $teams=$repository->find($idTeam);
        $formA=$this->createForm(TeamType::class,$teams);
        $formA->add('Update',SubmitType::class);
        $formA->HandleRequest($request);
      
        if($formA->isSubmitted() && $formA->isValid()){
            $em=$this->getDoctrine()->getManager();
        
            $em->flush();
            return $this->redirectToRoute('app_team1_index');
    }
    return $this->render('team/edit.html.twig',[
        'formA' => $formA->createView() ]);
       
    }
     /**
     * @Route("/{idTeam}", name="app_back_delete")
     */
    public function deleteback(FlashyNotifier $flashy,$idTeam,TeamRepository  $repository)
    {
        $team=$repository->find($idTeam);
        $em=$this->getDoctrine()->getManager();
        $em->remove($team);
        $em->flush();
        $flashy->success('team deleated!', 'http://your-awesome-link.com');
        return $this->redirectToRoute('app_back_index');
    }

    /**
     * @Route("/{idTeam}", name="app_team_delete")
     */
    public function delete($idTeam,TeamRepository  $repository)
    {
        $team=$repository->find($idTeam);
        $em=$this->getDoctrine()->getManager();
        $em->remove($team);
        $em->flush();
  
        return $this->redirectToRoute('app_team1_index');
    }
    /**
     * @Route("/teams/recherche", name="recherche")
     */
    public function searchdql(TeamRepository  $repository, Request $request){
        $data=$request->get('search');
        $teams=$repository->findBy(['teamName'=>$data]);
       
        return $this->render('team/show.html.twig', [
            'teams' => $teams,
        ]);
    }
    /**
     * @Route("/teams/{idTeam}", name="recherche1")
     */
    public function searchdq(TeamRepository  $repository, Request $request){
        $data=$request->get('search');
        $teams=$repository->findOneBy(['id'=>$data]);
       
        return $this->render('team/teamProfile.html.twig', [
            'teams' => $teams,
        ]);
    }
    /**
     * @Route("/team/recherche/{$teamName}", name="rechercheback")
     */
    function Rechercheback(TeamRepository $repository,Request $request,PaginatorInterface $paginator){
        $data=$request->get('searchback');

        /* $exercices=$this->getDoctrine()->getRepository(Exercice::class)->findBy(['nom'=>$data] );*/
        $donnees=$this->getDoctrine()->getRepository(Team::class)->findBy(['teamName'=>$data] );
        $teams= $paginator->paginate(
            $donnees,
            $request->query->getInt('page',1),
            4
        );


        return $this->render('team/back.html.twig',
            ['teams'=>$teams]);
    }
      /**
     * @Route("/leave/{teamName}/{idTeam}", name="app_not_leave")
     */
    public function leave(FlashyNotifier $flashy,$idTeam,$teamName,EntityManagerInterface $entityManager,NotificationRepository $repository): Response
    {       $team = new Team();
            $teams=$repository->findALL();
            $teams3=$repository->find("nbPlayers");
           
           

            
            $sql = " UPDATE team  SET `Players`=REPLACE(Players,'farouk','') Where Team_Name='$teamName' ";
            $stmt = $entityManager->getConnection()->prepare($sql);
            $stmt->execute();
            
           

           
        
        $flashy->success('Permission to join approved', 'http://your-awesome-link.com');

            return $this->redirectToRoute('app_team_index', ['teams'=>$teams]);
        
    }
     
}
