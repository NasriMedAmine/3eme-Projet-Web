<?php

namespace App\Controller;

use App\Entity\Winner;
use App\Form\WinnerType;
use App\Repository\WinnerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/winner")
 */
class WinnerController extends AbstractController
{
    /**
     * @Route("/", name="app_winner_index", methods={"GET"})
     */
    public function index(WinnerRepository $winnerRepository): Response
    {
        return $this->render('winner/index.html.twig', [
            'winners' => $winnerRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_winner_new", methods={"GET", "POST"})
     */
    public function new(Request $request, WinnerRepository $winnerRepository): Response
    {
        $winner = new Winner();
        $form = $this->createForm(WinnerType::class, $winner);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $winnerRepository->add($winner);
            return $this->redirectToRoute('app_winner_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('winner/new.html.twig', [
            'winner' => $winner,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="app_winner_show", methods={"GET"})
     */
    public function show(Winner $winner): Response
    {
        return $this->render('winner/show.html.twig', [
            'winner' => $winner,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_winner_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Winner $winner, WinnerRepository $winnerRepository): Response
    {
        $form = $this->createForm(WinnerType::class, $winner);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $winnerRepository->add($winner);
            return $this->redirectToRoute('app_winner_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('winner/edit.html.twig', [
            'winner' => $winner,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="app_winner_delete", methods={"POST"})
     */
    public function delete(Request $request, Winner $winner, WinnerRepository $winnerRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$winner->getId(), $request->request->get('_token'))) {
            $winnerRepository->remove($winner);
        }

        return $this->redirectToRoute('app_winner_index', [], Response::HTTP_SEE_OTHER);
    }
}
