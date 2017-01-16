<?php

namespace Kolomiets\BlogBundle\Controller;

use Kolomiets\BlogBundle\Entity\Post;
use Kolomiets\BlogBundle\Form\Type\AddCommentType;
use Kolomiets\BlogBundle\Form\Type\EditPostType;
use Kolomiets\BlogBundle\Form\Type\PostType;
use Kolomiets\BlogBundle\Form\Type\RemovePostType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function showPostsAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $posts = $em->getRepository('KolomietsBlogBundle:Post')->findAll();
        $categories = $em->getRepository('KolomietsBlogBundle:Category')->findAll();

        if (count($posts) == 0) {
            return $this->render('KolomietsBlogBundle:Default:emptyPosts.html.twig',
                [
                    'posts' => $posts,
                    'categories' => $categories,
                ]
            );
        }

        for($i = 0; $i < count($posts); $i++) {
            $removeForm[$i] = $this->createForm(RemovePostType::class);
            $editForm[$i] = $this->createForm(EditPostType::class);
            $addCommentForm[$i] = $this->createForm(AddCommentType::class);

            if ($request->isMethod($request::METHOD_POST)) {
                $removeForm[$i]->handleRequest($request);
                $editForm[$i]->handleRequest($request);
                $addCommentForm[$i]->handleRequest($request);

                if ($removeForm[$i]->isSubmitted() && $removeForm[$i]->isValid()) {
                    $post = $removeForm[$i]->getData();

                    return $this->redirectToRoute('remove_post', ['postId' => $post['name']]);
                }

                if ($editForm[$i]->isSubmitted() && $editForm[$i]->isValid()) {
                    $post = $editForm[$i]->getData();

                    return $this->redirectToRoute('edit_post', ['postId' => $post['name']]);
                }

                if ($addCommentForm[$i]->isSubmitted() && $addCommentForm[$i]->isValid()) {
                    $post = $addCommentForm[$i]->getData();

                    return $this->redirectToRoute('add_comment', ['postId' => $post['name']]);
                }
            }
            $removeForm[$i] = $removeForm[$i]->createView();
            $editForm[$i] = $editForm[$i]->createView();
            $addCommentForm[$i] = $addCommentForm[$i]->createView();
        }

        return $this->render('KolomietsBlogBundle:Default:showPosts.html.twig',
            [
                'posts' => $posts,
                'categories' => $categories,
                'removeForm' => $removeForm,
                'editForm' => $editForm,
                'addCommentForm' => $addCommentForm,
            ]
        );
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function addPostAction(Request $request)
    {
        $post = new Post();
        $form = $this->createForm(PostType::class, $post);

        if($request->isMethod($request::METHOD_POST)) {
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $post = $form->getData();

                $em = $this->getDoctrine()->getManager();
                $em->persist($post);
                $em->flush();

                return $this->redirectToRoute('show_posts');
            }
        }

        return $this->render('KolomietsBlogBundle:Default:form.html.twig',
            [
                'form' => $form->createView(),
            ]
        );
    }

    /**
     * @param int $postId
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editPostAction(Request $request, $postId)
    {
        $em = $this->getDoctrine()->getManager();
        $post = $em->getRepository('KolomietsBlogBundle:Post')->find($postId);

        $form = $this->createForm(PostType::class, $post);

        if($request->isMethod($request::METHOD_POST)) {
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $post = $form->getData();

                $em = $this->getDoctrine()->getManager();
                $em->flush();

                return $this->redirectToRoute('show_posts');
            }
        }

        return $this->render('KolomietsBlogBundle:Default:form.html.twig',
            [
                'form' => $form->createView(),
            ]
        );
    }

    /**
     * @param int $postId
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function removePostAction($postId)
    {
        $em = $this->getDoctrine()->getManager();
        $post = $em->getRepository('KolomietsBlogBundle:Post')->find($postId);
        $em->remove($post);
        $em->flush();

        return $this->redirectToRoute('show_posts');
    }
}
