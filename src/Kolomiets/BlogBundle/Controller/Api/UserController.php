<?php

namespace Kolomiets\BlogBundle\Controller\Api;

use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Kolomiets\BlogBundle\Entity\User;

class UserController extends FOSRestController
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @View(serializerGroups={"user"})
     */
    public function getUsersAllAction()
    {
        $users = $this->getDoctrine()->getRepository('KolomietsBlogBundle:User')->findAll();
        $view = $this->view($users, 200);

        return $this->handleView($view);
    }

    /**
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     * @View(serializerGroups={"user"})
     */
    public function getUserAction($id)
    {
        $user = $this->getDoctrine()->getRepository('KolomietsBlogBundle:User')->find($id);

        if (!$user instanceof User) {
            throw new NotFoundHttpException('User not found');
        }

        $view = $this->view($user, 200);

        return $this->handleView($view);
    }
}
