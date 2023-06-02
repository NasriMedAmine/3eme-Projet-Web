<?php

namespace App\Controller;

use App\Entity\NameGame;
use App\Form\NameGameType;
use App\Repository\NameGameRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/name/game")
 */
class NameGameController extends AbstractController
{
    /**
     * @Route("/", name="app_name_game_index", methods={"GET"})
     */
    public function index(NameGameRepository $nameGameRepository): Response
    {
        return $this->render('name_game/index.html.twig', [
            'name_games' => $nameGameRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_name_game_new", methods={"GET", "POST"})
     */
    public function new(Request $request, NameGameRepository $nameGameRepository): Response
    {
        $nameGame = new NameGame();
        $form = $this->createForm(NameGameType::class, $nameGame);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $nameGameRepository->add($nameGame);
            return $this->redirectToRoute('app_name_game_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('name_game/new.html.twig', [
            'name_game' => $nameGame,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="app_name_game_show", methods={"GET"})
     */
    public function show(NameGame $nameGame): Response
    {
        return $this->render('name_game/show.html.twig', [
            'name_game' => $nameGame,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_name_game_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, NameGame $nameGame, NameGameRepository $nameGameRepository): Response
    {
        $form = $this->createForm(NameGameType::class, $nameGame);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $nameGameRepository->add($nameGame);
            return $this->redirectToRoute('app_name_game_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('name_game/edit.html.twig', [
            'name_game' => $nameGame,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="app_name_game_delete", methods={"POST"})
     */
    public function delete(Request $request, NameGame $nameGame, NameGameRepository $nameGameRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$nameGame->getId(), $request->request->get('_token'))) {
            $nameGameRepository->remove($nameGame);
        }

        return $this->redirectToRoute('app_name_game_index', [], Response::HTTP_SEE_OTHER);
    }
}
