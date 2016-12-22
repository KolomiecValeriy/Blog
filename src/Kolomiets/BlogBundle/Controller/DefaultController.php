<?php

namespace Kolomiets\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('KolomietsBlogBundle:Default:index.html.twig');
    }
}
