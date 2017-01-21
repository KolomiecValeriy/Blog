<?php

namespace Kolomiets\BlogBundle\Controller;

use Kolomiets\BlogBundle\Entity\Comment;
use Kolomiets\BlogBundle\Form\Type\CommentType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CommentController extends Controller
{
    public function addCommentAction(Request $request, $postId)
    {
        $em = $this->getDoctrine()->getManager();
        $post = $em->getRepository("KolomietsBlogBundle:Post")->find($postId);

        $comment = new Comment();
        $comment->setPost($post);
        $form = $this->createForm(CommentType::class, $comment);

        if($request->isMethod($request::METHOD_POST)) {
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $comment = $form->getData();
                $em->persist($comment);
                $em->flush();

                return $this->redirectToRoute('show_posts');
            }
        }

        return $this->render('KolomietsBlogBundle:Default:comment.html.twig',
            [
                'form' => $form->createView()
            ]
        );
    }
}
