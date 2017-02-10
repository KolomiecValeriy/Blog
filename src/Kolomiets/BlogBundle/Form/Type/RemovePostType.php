<?php

namespace Kolomiets\BlogBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class RemovePostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', HiddenType::class)
        ;
//            ->add('submit', SubmitType::class, [
//                'label' => ' ',
//                'attr' => ['class' => 'btn btn-link glyphicon glyphicon-trash']
//            ])
    }

    public function getName()
    {
        return 'kolomiets_blog_bundle_remove_post_type';
    }
}
