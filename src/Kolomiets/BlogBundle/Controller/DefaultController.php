<?php

namespace Kolomiets\BlogBundle\Controller;

use Kolomiets\BlogBundle\Entity\Post;
use Kolomiets\BlogBundle\Form\Type\PostType;
use Kolomiets\BlogBundle\Form\Type\RemovePostType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class DefaultController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showPostsAction()
    {
        $em = $this->getDoctrine()->getManager();
        $posts = $em->getRepository('KolomietsBlogBundle:Post')->findAll();
        $categories = $em->getRepository('KolomietsBlogBundle:Category')->findAll();

        $removeLink =$this->generateUrl('removePost', [], UrlGeneratorInterface::ABSOLUTE_URL);
        $editLink =$this->generateUrl('editPost', [], UrlGeneratorInterface::ABSOLUTE_URL);

        return $this->render('KolomietsBlogBundle:Default:showPosts.html.twig',
            [
                'posts' => $posts,
                'categories' => $categories,
                'remove' => $removeLink,
                'edit' => $editLink,
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
    public function editPostAction($postId, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $post = $em->getRepository('KolomietsBlogBundle:Post')->find($postId);

        $form = $this->createFormBuilder($post)
            ->add('name', TextType::class)
            ->add('text', TextareaType::class)
            ->add('date', DateType::class)
            ->add('author', TextType::class)
            ->add('save', SubmitType::class, ['label' => 'Send'])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $post = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($post);
            $em->flush();

            return $this->redirectToRoute('show_posts');
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
