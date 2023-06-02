<?php

namespace App\Controller;

use App\Entity\Leader;
use App\Form\LeaderType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/leader")
 */
class LeaderController extends AbstractController
{
    /**
     * @Route("/", name="app_leader_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        $leaders = $entityManager
            ->getRepository(Leader::class)
            ->findAll();

        return $this->render('leader/index.html.twig', [
            'leaders' => $leaders,
        ]);
    }

    /**
     * @Route("/new", name="app_leader_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $leader = new Leader();
        $form = $this->createForm(LeaderType::class, $leader);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($leader);
            $entityManager->flush();

            return $this->redirectToRoute('app_leader_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('leader/new.html.twig', [
            'leader' => $leader,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="app_leader_show", methods={"GET"})
     */
    public function show(Leader $leader): Response
    {
        return $this->render('leader/show.html.twig', [
            'leader' => $leader,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_leader_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Leader $leader, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(LeaderType::class, $leader);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_leader_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('leader/edit.html.twig', [
            'leader' => $leader,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="app_leader_delete", methods={"POST"})
     */
    public function delete(Request $request, Leader $leader, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$leader->getIdLeader(), $request->request->get('_token'))) {
            $entityManager->remove($leader);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_leader_index', [], Response::HTTP_SEE_OTHER);
    }
}
