<?php

namespace App\Controller;

use App\Entity\PubliciteAimer;
use App\Form\PubliciteAimerType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/publicite/aimer")
 */
class PubliciteAimerController extends AbstractController
{
    /**
     * @Route("/", name="app_publicite_aimer_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        $publiciteAimers = $entityManager
            ->getRepository(PubliciteAimer::class)
            ->findAll();

        return $this->render('publicite_aimer/index.html.twig', [
            'publicite_aimers' => $publiciteAimers,
        ]);
    }

    /**
     * @Route("/new", name="app_publicite_aimer_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $publiciteAimer = new PubliciteAimer();
        $form = $this->createForm(PubliciteAimerType::class, $publiciteAimer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($publiciteAimer);
            $entityManager->flush();

            return $this->redirectToRoute('app_publicite_aimer_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('publicite_aimer/new.html.twig', [
            'publicite_aimer' => $publiciteAimer,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idPubAimer}", name="app_publicite_aimer_show", methods={"GET"})
     */
    public function show(PubliciteAimer $publiciteAimer): Response
    {
        return $this->render('publicite_aimer/show.html.twig', [
            'publicite_aimer' => $publiciteAimer,
        ]);
    }

    /**
     * @Route("/{idPubAimer}/edit", name="app_publicite_aimer_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, PubliciteAimer $publiciteAimer, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PubliciteAimerType::class, $publiciteAimer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_publicite_aimer_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('publicite_aimer/edit.html.twig', [
            'publicite_aimer' => $publiciteAimer,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idPubAimer}", name="app_publicite_aimer_delete", methods={"POST"})
     */
    public function delete(Request $request, PubliciteAimer $publiciteAimer, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$publiciteAimer->getIdPubAimer(), $request->request->get('_token'))) {
            $entityManager->remove($publiciteAimer);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_publicite_aimer_index', [], Response::HTTP_SEE_OTHER);
    }
}
