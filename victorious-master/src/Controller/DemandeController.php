<?php

namespace App\Controller;

use App\Entity\Demande;
use App\Entity\ResTournament;
use App\Entity\Player;

use App\Entity\User;
use App\Form\DemandeType;
use App\Repository\ReclamationRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/demande")
 */
class DemandeController extends AbstractController
{
    /**
     * @Route("/", name="app_demande_index", methods={"GET"})
     */
    public function index(Request $request,EntityManagerInterface $entityManager, PaginatorInterface $paginator): Response
    {
      $donnees = $entityManager
            ->getRepository(Demande::class)
            ->findAll();
        $demandes= $paginator->paginate(
        $donnees,
        $request->query->getInt('page',1)
            
        );
        return $this->render('demande/index.html.twig', [
            'demandes' => $demandes,
        ]);
    }
    /**
     * @Route("/demande", name="demande")
     */
    public function demade(Request $request,UserRepository $userrep)
    {     $demande= new Demande();
        $demande->setIduser($userrep->findOneBy(array('mail'=>$this->getUser()->getUsername())));
        $sql=" INSERT INTO `demande`(`idUser`) VALUES (`$demande`)";

        return $this->render('demande/show.html.twig', [
            'demande' => $demande,
        ]);
    }
    /**
     * @Route("/accepte/{iddemande}", name="accepte")
     */
    public function accepte($iddemande,EntityManagerInterface $entityManager,Request $request)
    {

        $demandes1 = $entityManager
            ->getRepository(Demande::class)
            ->find($iddemande);
        $demandes = $entityManager
            ->getRepository(Demande::class)
            ->findAll();

        $sql = "INSERT into res_tournament(`Id_User`) SELECT idUser FROM demande d WHERE d.idDemande='$iddemande'";
        $stmt = $entityManager->getConnection()->prepare($sql);
        $stmt->execute();
        $demandes1->setValide('1');

        return $this->render('demande/index.html.twig', [

            'demandes' => $demandes,



        ]);
    }

    /**
     * @Route("/new", name="app_demande_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $demande = new Demande();
        $form = $this->createForm(DemandeType::class, $demande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($demande);
            $entityManager->flush();

            return $this->redirectToRoute('app_demande_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('demande/new.html.twig', [
            'demande' => $demande,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{iddemande}", name="app_demande_show", methods={"GET"})
     */
    public function show(Demande $demande): Response
    {
        return $this->render('demande/show.html.twig', [
            'demande' => $demande,
        ]);
    }

    /**
     * @Route("/{iddemande}/edit", name="app_demande_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Demande $demande, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(DemandeType::class, $demande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_demande_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('demande/edit.html.twig', [
            'demande' => $demande,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{iddemande}", name="app_demande_delete", methods={"POST"})
     */
    public function delete(Request $request, Demande $demande, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$demande->getIddemande(), $request->request->get('_token'))) {
            $entityManager->remove($demande);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_demande_index', [], Response::HTTP_SEE_OTHER);
    }

}
