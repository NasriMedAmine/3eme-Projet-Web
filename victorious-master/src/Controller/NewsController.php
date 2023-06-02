<?php

namespace App\Controller;

use App\Entity\Games;
use App\Entity\News;
use App\Entity\User;
use App\Form\GamesType;
use App\Form\NewsType;
use App\Repository\NewsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Dompdf\Dompdf;
use Dompdf\Options;

/**
 * @Route("/news")
 */
class NewsController extends AbstractController
{
    /**
     * @Route("/", name="app_news_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        $news = $entityManager
            ->getRepository(News::class)
            ->findAll();


        return $this->render('news/index.html.twig', [
            'news' => $news,
        ]);
    }


    /**
     * @Route("/new", name="app_news_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager, \Swift_Mailer $mailer): Response
    {
        $news = new News();
        $form = $this->createForm(NewsType::class, $news);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($news);
            $entityManager->flush();


            // do anything else you need here, like send an email
            $Users = $entityManager->getRepository(User::class)->findAll();
            foreach ($Users as $user) {
                $message = (new \Swift_Message('NEWS on Victorious'))
                    ->setFrom('Victorious.HighFive@gmail.com')
                    ->setTo($user->getMail())
                    ->setBody(
                        "<p>Bonjour </p></p>Des actualités annoncés sur notre plateforme qui peuvent vous interesser :'</p>'",
                        'text/html');
                $mailer->send($message);
            }


            return $this->redirectToRoute('app_news_index');
        }

        return $this->render('news/new.html.twig', [
            'news' => $news,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idNews}", name="app_news_show", methods={"GET"})
     */
    public function show(News $news): Response
    {
        return $this->render('news/show.html.twig', [
            'news' => $news,
        ]);
    }

    /**
     * @Route("/{idNews}/edit", name="app_news_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, $idNews, EntityManagerInterface $entityManager, NewsRepository $newsRepository): Response
    {
        $new = $newsRepository->find($idNews);
        $form = $this->createForm(NewsType::class, $new);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $entityManager->$this->getDoctrine()->getManger();
            $entityManager->flush();

            return $this->redirectToRoute('app_news_index');
        }
        return $this->render('news/edit.html.twig', [
            'form' => $form->createView()
        ]);

    }

    /**
     * @Route("{idNews}/delete", name="app_news_delete")
     */
    public function delete($idNews, EntityManagerInterface $entityManager, NewsRepository $newsRepository): Response
    {

        $news = $newsRepository->find($idNews);
        $entityManager->remove($news);
        $entityManager->flush();
        return $this->redirectToRoute('app_news_index');
    }


}
