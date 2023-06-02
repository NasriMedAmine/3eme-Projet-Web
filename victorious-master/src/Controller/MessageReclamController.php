<?php

namespace App\Controller;

use App\Entity\MessageReclam;
use App\Form\MessageReclamType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/message/reclam")
 */
class MessageReclamController extends AbstractController
{
    /**
     * @Route("/", name="app_message_reclam_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        $messageReclams = $entityManager
            ->getRepository(MessageReclam::class)
            ->findAll();

        return $this->render('message_reclam/index.html.twig', [
            'message_reclams' => $messageReclams,
        ]);
    }

    /**
     * @Route("/new", name="app_message_reclam_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $messageReclam = new MessageReclam();
        $form = $this->createForm(MessageReclamType::class, $messageReclam);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($messageReclam);
            $entityManager->flush();

            return $this->redirectToRoute('app_message_reclam_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('message_reclam/new.html.twig', [
            'message_reclam' => $messageReclam,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="app_message_reclam_show", methods={"GET"})
     */
    public function show(MessageReclam $messageReclam): Response
    {
        return $this->render('message_reclam/show.html.twig', [
            'message_reclam' => $messageReclam,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_message_reclam_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, MessageReclam $messageReclam, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(MessageReclamType::class, $messageReclam);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_message_reclam_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('message_reclam/edit.html.twig', [
            'message_reclam' => $messageReclam,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="app_message_reclam_delete", methods={"POST"})
     */
    public function delete(Request $request, MessageReclam $messageReclam, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$messageReclam->getId(), $request->request->get('_token'))) {
            $entityManager->remove($messageReclam);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_message_reclam_index', [], Response::HTTP_SEE_OTHER);
    }
}
