<?php

namespace Kolomiets\BlogBundle\Controller;

use Kolomiets\BlogBundle\Entity\Category;
use Kolomiets\BlogBundle\Form\Type\CategoryType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CategoryController extends Controller
{
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function addCategoryAction(Request $request)
    {
        $category = new Category();

        $form = $this->createForm(CategoryType::class, $category);

        if($request->isMethod($request::METHOD_POST)) {
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $category = $form->getData();

                $em = $this->getDoctrine()->getManager();
                $em->persist($category);
                $em->flush();

                return $this->redirectToRoute('show_posts');
            }
        }

        return $this->render('KolomietsBlogBundle:Default:category.html.twig',
            [
                'form' => $form->createView(),
            ]
        );
    }
}
