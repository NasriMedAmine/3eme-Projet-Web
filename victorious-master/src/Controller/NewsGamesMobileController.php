<?php

namespace App\Controller;

use App\Entity\Games;
use App\Entity\News;
use App\Entity\User;
use App\Form\NewsType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;


class NewsGamesMobileController extends AbstractController
{
    /**
     * @Route("/newsmobile", name="app_news_games_mobile")
     */
    public function index(): Response
    {
        return $this->render('news_games_mobile/index.html.twig', [
            'controller_name' => 'NewsGamesMobileController',
        ]);
    }

    /**
     * @Route("/newsadd", name="newsadd")
     */
    public function new(Request $request, EntityManagerInterface $em, \Swift_Mailer $mailer): Response
    {
        $news = new News();

        $dateDebut= new \DateTime($request->query->get("dateDebut"));
        $title= $request->query->get("title");
        $description= $request->query->get("description");

        $news->setDateDebut($dateDebut);
        $news->setTitle($title);
        $news->setDescription($description);


        $em->persist($news);
        $em->flush();

/*
        // do anything else you need here, like send an email
        $Users = $em->getRepository(User::class)->findAll();
        foreach ($Users as $user) {
            $message = (new \Swift_Message('NEWS on Victorious'))
                ->setFrom('Victorious.HighFive@gmail.com')
                ->setTo($user->getMail())
                ->setBody(
                    "<p>Bonjour </p></p>Des actualités annoncés sur notre plateforme qui peuvent vous interesser :'</p>'",
                    'text/html');
            $mailer->send($message);


        }
*/
            return new JsonResponse('news added');
    }
    /**
     * @Route("/gamesadd", name="gamesadd")
     */
    public function newga(Request $request, EntityManagerInterface $em): Response
    {
        $games = new Games();

        $newsDate= new \DateTime($request->query->get("newsDate"));
        $gameName= $request->query->get("gameName");
        $description= $request->query->get("description");
        $news= $request->query->get("news");

        $games->setNewsDate($newsDate);
        $games->setGameName($gameName);
        $games->setDescription($description);
        $games->setNews($news);


        $em->persist($games);
        $em->flush();

        /*
                // do anything else you need here, like send an email
                $Users = $em->getRepository(User::class)->findAll();
                foreach ($Users as $user) {
                    $message = (new \Swift_Message('NEWS on Victorious'))
                        ->setFrom('Victorious.HighFive@gmail.com')
                        ->setTo($user->getMail())
                        ->setBody(
                            "<p>Bonjour </p></p>Des actualités annoncés sur notre plateforme qui peuvent vous interesser :'</p>'",
                            'text/html');
                    $mailer->send($message);


                }
        */
        return new JsonResponse('game added');
    }

    /**
     * @Route("/editnews",name="editnews");
     */
    public function editnews(Request $request, EntityManagerInterface $em): JsonResponse
    {
        $repository=$this->getDoctrine()->getRepository(News::class);
        $id=$request->query->get("id");
        $news=$repository->find($id);

        $dateDebut= new \DateTime($request->query->get("dateDebut"));
        $title= $request->query->get("title");
        $description= $request->query->get("description");

        $news->setDateDebut($dateDebut);
        $news->setTitle($title);
        $news->setDescription($description);

        $em->flush();
        //return new JsonResponse($user->getPseudo());
        return new JsonResponse("news modifid succefuly");
    }

    /**
     * @Route("/editgames",name="editgames");
     */
    public function editgames(Request $request, EntityManagerInterface $em): JsonResponse
    {
        $repository=$this->getDoctrine()->getRepository(Games::class);
        $id=$request->query->get("id");
        $games=$repository->find($id);

        $newsDate= new \DateTime($request->query->get("newsDate"));
        $gameName= $request->query->get("gameName");
        $description= $request->query->get("description");
        $news= $request->query->get("news");

        $games->setNewsDate($newsDate);
        $games->setGameName($gameName);
        $games->setDescription($description);
        $games->setNews($news);

        $em->flush();
        //return new JsonResponse($user->getPseudo());
        return new JsonResponse("games modifid succefuly");
    }

    /**
    * @Route ("/delnews", name="newsdel")
    */
    public function newsdel(Request $request,EntityManagerInterface $em): JsonResponse
    {
        $repository=$this->getDoctrine()->getRepository(News::class);
        $id =$request->get("id");
        $news=$repository->find($id);

        $em->remove($news);
        $em->flush();

        return new JsonResponse("news deleted");
    }

    /**
     * @Route ("/delgames", name="gamedel")
     */
    public function gamesdel(Request $request,EntityManagerInterface $em): JsonResponse
    {
        $repository=$this->getDoctrine()->getRepository(Games::class);
        $id =$request->get("id");
        $games=$repository->find($id);

        $em->remove($games);
        $em->flush();

        return new JsonResponse("game deleted");
    }


    /**
     * @Route("/ShowNewsMobile",name="ShowTeamMobile")
     */
    public function ShowNewsMobile(Request $request,EntityManagerInterface $entityManager,SerializerInterface $serializer):JsonResponse
    {
        $news = $entityManager
            ->getRepository(News::class)
            ->findAll();
        $json = $serializer->serialize($news, 'json');


        if ($json) {
            return new JsonResponse($json, 200);
        } else {
            return new JsonResponse([], 204);


            //return new JsonResponse($json);

        }
    }
}
