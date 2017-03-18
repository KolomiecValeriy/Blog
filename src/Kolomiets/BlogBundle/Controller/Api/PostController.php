<?php

namespace Kolomiets\BlogBundle\Controller\Api;

use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Kolomiets\BlogBundle\Entity\Post;

class PostController extends FOSRestController
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @View(serializerGroups={"post"})
     */
    public function getPostsAllAction()
    {
        $posts = $this->getDoctrine()->getRepository('KolomietsBlogBundle:Post')->findAll();
        $view = $this->view($posts, 200);

        return $this->handleView($view);
    }

    /**
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     * @View(serializerGroups={"post"})
     */
    public function getPostAction($id)
    {
        $post = $this->getDoctrine()->getRepository('KolomietsBlogBundle:Post')->find($id);

        if (!$post instanceof Post) {
            throw new NotFoundHttpException('Post not found');
        }

        $view = $this->view($post, 200);

        return $this->handleView($view);
    }
}
