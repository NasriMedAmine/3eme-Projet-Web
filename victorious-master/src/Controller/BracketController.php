<?php

namespace App\Controller;

use App\Entity\Bracket;
use App\Form\BracketType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/bracket")
 */
class BracketController extends AbstractController
{
    /**
     * @Route("/", name="app_bracket_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        $brackets = $entityManager
            ->getRepository(Bracket::class)
            ->findAll();

        return $this->render('bracket/index.html.twig', [
            'brackets' => $brackets,
        ]);
    }

    /**
     * @Route("/new", name="app_bracket_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $bracket = new Bracket();
        $form = $this->createForm(BracketType::class, $bracket);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($bracket);
            $entityManager->flush();

            return $this->redirectToRoute('app_bracket_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('bracket/new.html.twig', [
            'bracket' => $bracket,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idBracket}", name="app_bracket_show", methods={"GET"})
     */
    public function show(Bracket $bracket): Response
    {
        return $this->render('bracket/show.html.twig', [
            'bracket' => $bracket,
        ]);
    }

    /**
     * @Route("/{idBracket}/edit", name="app_bracket_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Bracket $bracket, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(BracketType::class, $bracket);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_bracket_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('bracket/edit.html.twig', [
            'bracket' => $bracket,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idBracket}", name="app_bracket_delete", methods={"POST"})
     */
    public function delete(Request $request, Bracket $bracket, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$bracket->getIdBracket(), $request->request->get('_token'))) {
            $entityManager->remove($bracket);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_bracket_index', [], Response::HTTP_SEE_OTHER);
    }
}
