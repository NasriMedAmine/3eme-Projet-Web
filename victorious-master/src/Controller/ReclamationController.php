<?php

namespace App\Controller;

use App\Entity\Reclamation;
use App\Entity\Player;
use App\Entity\User;
use App\Entity\ReponseReclamation;
use App\Form\ReclamationType;
use App\Form\ReponseReclamationType;
use App\Repository\ReclamationRepository;
use App\Repository\UserRepository;
use App\Repository\UsersRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/reclamation")
 */
class ReclamationController extends AbstractController
{
    /**
     * @Route("/", name="reclamation_index", methods={"GET"})
     */
    public function index(ReclamationRepository $reclamationRepository): Response
    {
        return $this->render('reclamation/index.html.twig', [
            'reclamations' => $reclamationRepository->findBy(array('user'=>$this->getUser())),
        ]);
    }
    /**
     * @Route("/reclamation_traitement/{id}", name="reclamation_traiter")
     */
    public function traiter(Request $request, Reclamation $reclamation): Response
    {
         $reponse=new ReponseReclamation();
        $form = $this->createForm(ReponseReclamationType::class, $reponse);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $reclamation->setReponse($reponse);
            $reclamation->setEtat('Traitee');
            $reponse->setDate(new \DateTime());


            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($reponse);
            $entityManager->flush();

            return $this->redirectToRoute('reclamation_index_traiter');
        }

        return $this->render('reclamation/Traitement.html.twig', [
            'reclamation' => $reclamation,
            'form' => $form->createView(),
        ]);

    }

    /**
     * @Route("/reclamationAdmin", name="reclamation_index_traiter", methods={"GET"})
     */
    public function index2(ReclamationRepository $reclamationRepository): Response
    {
        return $this->render('reclamation/ListeReclamationAtraiter.html.twig', [
            'reclamations' => $reclamationRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="reclamation_new")
     */
    public function new(Request $request,UserRepository $userrep): Response
    {

        $reclamation = new Reclamation();
        $form = $this->createForm(ReclamationType::class, $reclamation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $reclamation->setDate(new \DateTime());
            $reclamation->setEtat('En cours');
            $reclamation->setUser($userrep->findOneBy(array('mail'=>$this->getUser()->getUsername())));

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($reclamation);
            $entityManager->flush();



            return $this->redirectToRoute('reclamation_index');


        }

        return $this->render('reclamation/new.html.twig', [
            'reclamation' => $reclamation,
            'form' => $form->createView(),


        ]);
    }


    /**
     * @Route("/{id}", name="reclamation_show", methods={"GET"})
     */
    public function show(Reclamation $reclamation): Response
    {
        return $this->render('reclamation/show.html.twig', [
            'reclamation' => $reclamation,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="reclamation_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Reclamation $reclamation): Response
    {
        $form = $this->createForm(ReclamationType::class, $reclamation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('reclamation_index');
        }

        return $this->render('reclamation/edit.html.twig', [
            'reclamation' => $reclamation,
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/ndeleten/{id}", name="reclamation_ndeleten")
     */
    public function ndeleten($id,ReclamationRepository $reclamationRepository)
    {
        $recl=$reclamationRepository->find($id);
        $em=$this->getDoctrine()->getManager();
        $em->remove($recl);
        $em->flush();


        return $this->redirectToRoute('reclamation_index');
    }
}
