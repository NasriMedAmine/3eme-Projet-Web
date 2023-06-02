<?php

namespace App\Controller;

use App\Entity\Interditmot;
use App\Form\InterditmotType;
use App\Repository\InterditmotRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/interditmot")
 */
class InterditmotController extends AbstractController
{
    /**
     * @Route("/", name="app_interditmot_index", methods={"GET"})
     */
    public function index(InterditmotRepository $interditmotRepository): Response
    {
        return $this->render('interditmot/index.html.twig', [
            'interditmots' => $interditmotRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_interditmot_new", methods={"GET", "POST"})
     */
    public function new(Request $request, InterditmotRepository $interditmotRepository): Response
    {
        $interditmot = new Interditmot();
        $form = $this->createForm(InterditmotType::class, $interditmot);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $interditmotRepository->add($interditmot);
            return $this->redirectToRoute('app_interditmot_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('interditmot/new.html.twig', [
            'interditmot' => $interditmot,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="app_interditmot_show", methods={"GET"})
     */
    public function show(Interditmot $interditmot): Response
    {
        return $this->render('interditmot/show.html.twig', [
            'interditmot' => $interditmot,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_interditmot_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Interditmot $interditmot, InterditmotRepository $interditmotRepository): Response
    {
        $form = $this->createForm(InterditmotType::class, $interditmot);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $interditmotRepository->add($interditmot);
            return $this->redirectToRoute('app_interditmot_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('interditmot/edit.html.twig', [
            'interditmot' => $interditmot,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="app_interditmot_delete", methods={"POST"})
     */
    public function delete(Request $request, Interditmot $interditmot, InterditmotRepository $interditmotRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$interditmot->getId(), $request->request->get('_token'))) {
            $interditmotRepository->remove($interditmot);
        }

        return $this->redirectToRoute('app_interditmot_index', [], Response::HTTP_SEE_OTHER);
    }
}
