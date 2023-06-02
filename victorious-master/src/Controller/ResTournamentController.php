<?php

namespace App\Controller;

use App\Entity\ResTournament;
use App\Form\ResTournamentType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/res/tournament")
 */
class ResTournamentController extends AbstractController
{
    /**
     * @Route("/", name="app_res_tournament_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        $resTournaments = $entityManager
            ->getRepository(ResTournament::class)
            ->findAll();

        return $this->render('res_tournament/index.html.twig', [
            'res_tournaments' => $resTournaments,
        ]);
    }

    /**
     * @Route("/new", name="app_res_tournament_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $resTournament = new ResTournament();
        $form = $this->createForm(ResTournamentType::class, $resTournament);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($resTournament);
            $entityManager->flush();

            return $this->redirectToRoute('app_res_tournament_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('res_tournament/new.html.twig', [
            'res_tournament' => $resTournament,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idRes}", name="app_res_tournament_show", methods={"GET"})
     */
    public function show(ResTournament $resTournament): Response
    {
        return $this->render('res_tournament/show.html.twig', [
            'res_tournament' => $resTournament,
        ]);
    }

    /**
     * @Route("/{idRes}/edit", name="app_res_tournament_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, ResTournament $resTournament, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ResTournamentType::class, $resTournament);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_res_tournament_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('res_tournament/edit.html.twig', [
            'res_tournament' => $resTournament,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idRes}", name="app_res_tournament_delete", methods={"POST"})
     */
    public function delete(Request $request, ResTournament $resTournament, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$resTournament->getIdRes(), $request->request->get('_token'))) {
            $entityManager->remove($resTournament);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_res_tournament_index', [], Response::HTTP_SEE_OTHER);
    }
}
