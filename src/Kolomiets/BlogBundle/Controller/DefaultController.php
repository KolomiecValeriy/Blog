<?php

namespace Kolomiets\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('KolomietsBlogBundle:Default:index.html.twig');
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    //KolomietsBlogBundle:Post
    public function showPostsAction()
    {
        $em = $this->getDoctrine()->getManager();
        $posts = $em->getRepository('KolomietsBlogBundle:Post')->findAll();

        return $this->render('KolomietsBlogBundle:Show:showPosts.html.twig',
                [
                    'posts' => $posts,
                ]
            );
    }
}
