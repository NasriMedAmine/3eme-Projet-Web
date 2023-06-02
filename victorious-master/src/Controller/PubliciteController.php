<?php

namespace App\Controller;

use App\Entity\Publicite;
use App\Form\Publicite1Type;
use App\Repository\PubliciteRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Dompdf\Dompdf;
use Dompdf\Options;
/**
 * @Route("/publicite")
 */
class PubliciteController extends AbstractController
{
    /**
     * @Route("/", name="app_publicite_index", methods={"GET"})
     */
    public function index(Request $request , PaginatorInterface $paginator)
    {
        $donnees=$this->getDoctrine()->getRepository(Publicite::class)->findAll();
        $publicites= $paginator->paginate(
            $donnees,
            $request->query->getInt('page',1),
            4
        );
        return $this->render('publicite/index.html.twig', [
            'publicites' => $publicites
        ]);
    }

    /**
     * @Route("/listp", name="app_publicite_list", methods={"GET"})
     */
    public function listp( PubliciteRepository $publiciteRepository ,Request $request, PaginatorInterface $paginator):Response
    {

        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);

        $donnees=$this->getDoctrine()->getRepository(Publicite::class)->findAll();
        $publicites= $paginator->paginate(
            $donnees,
            $request->query->getInt('page',1),
            11
        );


        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('publicite/listp.html.twig', [
            'publicites' => $publicites
        ]);

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A3', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (force download)
        $dompdf->stream("mypdf.pdf", [
            "Attachment" => false
        ]);







    }


    /**
     * @Route("/{id}/listpp", name="app_publicite_listpp", methods={"GET"})
     */
    public function listpp( PubliciteRepository $publiciteRepository ,Request $request, Publicite $publicite, EntityManagerInterface $entityManager): Response
    {

        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);

        $donnees=$this->getDoctrine()->getRepository(Publicite::class)->findAll();



        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('publicite/listpp.html.twig', [
            'publicite' => $publicite,
        ]);

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (force download)
        $dompdf->stream("mypdf.pdf", [
            "Attachment" => false
        ]);







    }


    /**







    /**
     * @Route("/statisti", name="statisti")
     */
    public function statisti(EntityManagerInterface $entityManager)
    {

        $pub = $entityManager
            ->getRepository(Publicite::class)
            ->findAll();

        return $this->render('publicite/stat.html.twig', [
            'pub' => $pub,
        ]);
    }

    /**
     * @Route("/new", name="app_publicite_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $publicite = new Publicite();
        $form = $this->createForm(Publicite1Type::class, $publicite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();

            $file=$publicite ->getImage();
            $file2=$publicite ->getVideo();
            $file3=$publicite ->getDocs();
            $filename = $this->generateUniqueFileName().'.'.$file->guessExtension();
            $filename2=$this->generateUniqueFileName().'.'.$file2->guessExtension();
            $filename3=$this->generateUniqueFileName().'.'.$file3->guessExtension();
            $file->move($this->getParameter('photos_directory'),$filename);
            $file2->move($this->getParameter('videos_directory'),$filename2);
            $file3->move($this->getParameter('documents_directory'),$filename3);
            $publicite ->setImage($filename);
            $publicite ->setVideo($filename2);
            $publicite ->setDocs($filename3);

            $entityManager->persist($publicite );

            $entityManager->flush();


            return $this->redirectToRoute('app_publicite_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('publicite/new.html.twig', [
            'publicite' => $publicite,
            'form' => $form->createView(),
        ]);
    }
    private function generateUniqueFileName()
    {
        // md5() reduces the similarity of the file names generated by
        // uniqid(), which is based on timestamps
        return md5(uniqid());
    }
    /**
     * @Route("/{id}", name="app_publicite_show", methods={"GET"})
     */
    public function show(Publicite $publicite): Response
    {
        return $this->render('publicite/show.html.twig', [
            'publicite' => $publicite,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_publicite_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Publicite $publicite, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(Publicite1Type::class, $publicite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file=$publicite->getImage();
            $file2=$publicite->getVideo();
            $file3=$publicite->getDocs();
            $filename = $this->generateUniqueFileName().'.'.$file->guessExtension();
            $filename2=$this->generateUniqueFileName().'.'.$file2->guessExtension();
            $filename3=$this->generateUniqueFileName().'.'.$file3->guessExtension();
            $file->move($this->getParameter('photos_directory'),$filename);
            $file2->move($this->getParameter('videos_directory'),$filename2);
            $file3->move($this->getParameter('documents_directory'),$filename3);
            $publicite->setImage($filename);
            $publicite->setVideo($filename2);
            $publicite->setDocs($filename3);

            $entityManager->persist($publicite);
            $entityManager->flush();

            return $this->redirectToRoute('app_publicite_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('publicite/edit.html.twig', [
            'publicite' => $publicite,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="app_publicite_delete", methods={"POST"})
     */
    public function delete(Request $request, Publicite $publicite, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$publicite->getId(), $request->request->get('_token'))) {
            $entityManager->remove($publicite);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_publicite_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/main", name="enligne", methods={"GET"})
     */
    public function afficher()
    {

        $publicite=$this->getDoctrine()->getRepository(Publicite::class)->findAll();

       # $publicite=$this->getDoctrine()->getRepository(Publicite::class)->findBy(array('........'=>$publicite));

        return $this->render('main/index.html.twig',[
            'publicite' =>$publicite  ]);



    }

    /**
     * @Route("/publicite/recherche/{$nom}", name="recherche")
     */
    function Recherche(PubliciteRepository $repository,Request $request,PaginatorInterface $paginator){
        $data=$request->get('search');

        /* $exercices=$this->getDoctrine()->getRepository(Exercice::class)->findBy(['nom'=>$data] );*/
        $donnees=$this->getDoctrine()->getRepository(Publicite::class)->findBy(['nom'=>$data] );
        $publicites= $paginator->paginate(
            $donnees,
            $request->query->getInt('page',1),
            4
        );


        return $this->render('publicite/index.html.twig',
            ['publicites'=>$publicites]);
    }








}
