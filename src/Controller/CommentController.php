<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use App\Entity\Comment;
use App\Form\CommentType;

class CommentController extends AbstractController
{
    /**
     * @Route("/comments/{id}/edit", name="comment_edit", methods={"GET","POST"})
     * @return Response
     */
    public function edit(Request $request, Comment $comment): Response
    {
        /* Check wether the logged in user is the owner of the program */
        if (!($this->getUser() == $comment->getAuthor()) && !in_array('ROLE_ADMIN', $this->getUser()->getRoles())) {
            /* If not the owner, throws a 403 Access Denied exception */
            throw new AccessDeniedException('Only the owner can edit the comment!');
        }

        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('program_episode_show', [
                'program' => $comment->getEpisode()->getSeason()->getProgram()->getSlug(),
                'seasonId' => $comment->getEpisode()->getSeason()->getId(),
                'episode' => $comment->getEpisode()->getSlug()
            ]);
        }
        return $this->render('comment/edit.html.twig', [
            'comment' => $comment,
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/comments/{id}", requirements={"program"="d+"}, name="comment_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Comment $comment): Response
    {
        if ($this->isCsrfTokenValid('delete'.$comment->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($comment);
            $entityManager->flush();
        }

        return $this->redirectToRoute('episode_index');
    }

}
