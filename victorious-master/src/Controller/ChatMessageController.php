<?php

namespace App\Controller;

use App\Entity\ChatMessage;
use App\Form\ChatMessageType;
use App\Repository\ChatMessageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/chat/message")
 */
class ChatMessageController extends AbstractController
{
    /**
     * @Route("/", name="app_chat_message_index", methods={"GET"})
     */
    public function index(ChatMessageRepository $chatMessageRepository): Response
    {
        return $this->render('chat_message/index.html.twig', [
            'chat_messages' => $chatMessageRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_chat_message_new", methods={"GET", "POST"})
     */
    public function new(Request $request, ChatMessageRepository $chatMessageRepository): Response
    {
        $chatMessage = new ChatMessage();
        $form = $this->createForm(ChatMessageType::class, $chatMessage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $chatMessageRepository->add($chatMessage);
            return $this->redirectToRoute('app_chat_message_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('chat_message/new.html.twig', [
            'chat_message' => $chatMessage,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="app_chat_message_show", methods={"GET"})
     */
    public function show(ChatMessage $chatMessage): Response
    {
        return $this->render('chat_message/show.html.twig', [
            'chat_message' => $chatMessage,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_chat_message_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, ChatMessage $chatMessage, ChatMessageRepository $chatMessageRepository): Response
    {
        $form = $this->createForm(ChatMessageType::class, $chatMessage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $chatMessageRepository->add($chatMessage);
            return $this->redirectToRoute('app_chat_message_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('chat_message/edit.html.twig', [
            'chat_message' => $chatMessage,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="app_chat_message_delete", methods={"POST"})
     */
    public function delete(Request $request, ChatMessage $chatMessage, ChatMessageRepository $chatMessageRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$chatMessage->getId(), $request->request->get('_token'))) {
            $chatMessageRepository->remove($chatMessage);
        }

        return $this->redirectToRoute('app_chat_message_index', [], Response::HTTP_SEE_OTHER);
    }
}
