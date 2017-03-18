<?php

namespace Kolomiets\BlogBundle\Controller\Api;

use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\FOSRestController;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Kolomiets\BlogBundle\Entity\User;

class UserController extends FOSRestController
{
    /**
     * @ApiDoc(
     *   output = "BlogBundle\Entity\User",
     *   description = "Return all Users in JSON",
     *   resource = true,
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when not found"
     *   }
     * )
     *
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
     * @ApiDoc(
     *   output = "BlogBundle\Entity\User",
     *   description = "Return User from his id in JSON",
     *   resource = true,
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when not found"
     *   }
     * )
     *
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
