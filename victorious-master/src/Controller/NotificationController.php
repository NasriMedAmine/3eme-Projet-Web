<?php

namespace App\Controller;

use App\Entity\Team;
use App\Entity\User;
use App\Entity\Admin;
use App\Entity\Player;
use App\Entity\Notification;
use App\Repository\UserRepository;
use Doctrine\DBAL\Driver\Connection;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\NotificationRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bridge\Doctrine\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use MercurySeries\FlashyBundle\FlashyNotifier;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class NotificationController extends AbstractController
{
    /**
     * @Route("/backnot", name="app_backnot_index", methods={"GET"})
     */
    public function index(Request $request , PaginatorInterface $paginator)
    {
        $donnees=$this->getDoctrine()->getRepository(Notification::class)->findAll();
        $notification= $paginator->paginate(
            $donnees,
            $request->query->getInt('page',1),
            4
        );
        return $this->render('notification/index.html.twig', [
            'notification' => $notification
        ]);
    }
    /**
     *  @Route("/{idTeam}/edit/not", name="app_not_joi")
     */
    public function join($idTeam,EntityManagerInterface $entityManager,UserRepository $red){
     
       $notification = new Notification();
      
       $teams=$entityManager
       ->getRepository(Team::class)
       ->find($idTeam);
       $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        // returns your User object, or null if the user is not authenticated
        // use inline documentation to tell your editor your exact User class
        /** @var \App\Entity\User $user */
        $user = $this->getUser();

    
      $notification->setteam_name($teams);
      $notification->setplayer_name($user->getPseudo());
      $em=$this->getDoctrine()->getManager();
       $em->persist($notification);
       $em->flush();
      
       return $this->render('team/teaprofile.html.twig', [
        'teams' => $teams,
        'isValide' => "yes",
        
        
       
    ]);
        }
       /**
     * @Route("/de/{id}", name="app_not_delete")
     */
    public function deletenot(FlashyNotifier $flashy,$id,NotificationRepository $repository)
    {
        $notif=$repository->find($id);
        $em=$this->getDoctrine()->getManager();
        $em->remove($notif);
        $em->flush();
        $flashy->success('Permission to join declined', 'http://your-awesome-link.com');
        return $this->redirectToRoute('app_backnot_index');
    }
     /**
     * @Route("/editno/{team_name}/{id}", name="app_not_edit")
     */
    public function editno(FlashyNotifier $flashy,$id,$team_name,EntityManagerInterface $entityManager,NotificationRepository $repository): Response
    {       $team = new Team();
         $teams3=$repository->find($team_name);
            $teams3=$repository->find("nbPlayers");
         
           

            
            $sql = " UPDATE team  SET `Players`=CONCAT_WS(' , ',Players,'farouk') Where Team_Name='$team_name' ";
            $stmt = $entityManager->getConnection()->prepare($sql);
            $stmt->execute();
            $sql1 = " UPDATE team  SET `Nb_Players`=Nb_Players + 1 Where Team_Name='$team_name' ";
            $stmt = $entityManager->getConnection()->prepare($sql1);
            $stmt->execute();
            
           

           
            $notif=$repository->find($id);

            $notif->setplayer_name("farouk");
        $em=$this->getDoctrine()->getManager();
        $em->remove($notif);
        $em->flush();
        $flashy->success('Permission to join approved', 'http://your-awesome-link.com');

            return $this->redirectToRoute('app_backnot_index', [], Response::HTTP_SEE_OTHER);
        
    }
    
}
