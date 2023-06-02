<?php

namespace App\Controller;

use App\Entity\Advertise;
use App\Form\AdvertiseType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/advertise")
 */
class AdvertiseController extends AbstractController
{
    /**
     * @Route("/", name="app_advertise_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        $advertises = $entityManager
            ->getRepository(Advertise::class)
            ->findAll();

        return $this->render('advertise/index.html.twig', [
            'advertises' => $advertises,
        ]);
    }

    /**
     * @Route("/new", name="app_advertise_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $advertise = new Advertise();
        $form = $this->createForm(AdvertiseType::class, $advertise);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($advertise);
            $entityManager->flush();

            return $this->redirectToRoute('app_advertise_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('advertise/new.html.twig', [
            'advertise' => $advertise,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idAdvertise}", name="app_advertise_show", methods={"GET"})
     */
    public function show(Advertise $advertise): Response
    {
        return $this->render('advertise/show.html.twig', [
            'advertise' => $advertise,
        ]);
    }

    /**
     * @Route("/{idAdvertise}/edit", name="app_advertise_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Advertise $advertise, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AdvertiseType::class, $advertise);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_advertise_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('advertise/edit.html.twig', [
            'advertise' => $advertise,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idAdvertise}", name="app_advertise_delete", methods={"POST"})
     */
    public function delete(Request $request, Advertise $advertise, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$advertise->getIdAdvertise(), $request->request->get('_token'))) {
            $entityManager->remove($advertise);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_advertise_index', [], Response::HTTP_SEE_OTHER);
    }
}
