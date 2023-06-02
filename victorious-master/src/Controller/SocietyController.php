<?php

namespace App\Controller;

use App\Entity\Society;
use App\Form\SocietyType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/society")
 */
class SocietyController extends AbstractController
{
    /**
     * @Route("/", name="app_society_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        $societies = $entityManager
            ->getRepository(Society::class)
            ->findAll();

        return $this->render('society/index.html.twig', [
            'societies' => $societies,
        ]);
    }

    /**
     * @Route("/new", name="app_society_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $society = new Society();
        $form = $this->createForm(SocietyType::class, $society);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($society);
            $entityManager->flush();

            return $this->redirectToRoute('app_society_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('society/new.html.twig', [
            'society' => $society,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idSociety}", name="app_society_show", methods={"GET"})
     */
    public function show(Society $society): Response
    {
        return $this->render('society/show.html.twig', [
            'society' => $society,
        ]);
    }

    /**
     * @Route("/{idSociety}/edit", name="app_society_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Society $society, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(SocietyType::class, $society);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_society_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('society/edit.html.twig', [
            'society' => $society,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idSociety}", name="app_society_delete", methods={"POST"})
     */
    public function delete(Request $request, Society $society, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$society->getIdSociety(), $request->request->get('_token'))) {
            $entityManager->remove($society);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_society_index', [], Response::HTTP_SEE_OTHER);
    }
}
