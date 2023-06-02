<?php

namespace App\Controller;

use App\Entity\Games;
use App\Entity\News;
use App\Form\GamesType;
use App\Repository\GameRepository;
use App\Repository\NewsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/games")
 */
class GamesController extends AbstractController
{
    /**
     * @Route("/", name="app_games_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        $games = $entityManager
            ->getRepository(Games::class)
            ->findAll();

        return $this->render('games/index.html.twig', [
            'games' => $games,
        ]);
    }

    /**
     * @Route("/new", name="app_games_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $game = new Games();
        $form = $this->createForm(GamesType::class, $game);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($game);
            $entityManager->flush();

            return $this->redirectToRoute('app_games_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('games/new.html.twig', [
            'game' => $game,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idGame}", name="app_games_show", methods={"GET"})
     */
    public function show(Games $game): Response
    {
        return $this->render('games/show.html.twig', [
            'game' => $game,
        ]);
    }

    /**
     * @Route("{idGame}/edit", name="app_games_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, EntityManagerInterface $entityManager,$idGame,GameRepository $gameRepository)
    {
        $game = $gameRepository->find($idGame);
        $form = $this->createForm(GamesType::class, $game);
        $form->add('update',SubmitType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
           // $entityManager->$this->getDoctrine()->getManger();
            $entityManager->flush();

            return $this->redirectToRoute('app_games_index');
        }
        return $this->render('games/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("{idGame}/delete", name="app_games_delete")
     */
    public function delete($idGame,  EntityManagerInterface $entityManager ,GameRepository $gameRepository): Response
    {

        $news = $gameRepository->find($idGame);
        $entityManager->remove($news);
        $entityManager->flush();
        return $this->redirectToRoute('app_games_index');
    }

}
