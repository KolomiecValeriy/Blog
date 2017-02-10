<?php

namespace Kolomiets\BlogBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class SearchPostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('text', TextType::class, [
                'attr' => ['class' => 'form-control']
            ])
        ;
//            ->add('submit', SubmitType::class, [
//                'label' => 'Search',
//                'attr' => ['class' => 'btn btn-default glyphicon glyphicon-search']
//            ])
    }

    public function getName()
    {
        return 'kolomiets_blog_bundle_search_post_type';
    }
}
