<?php

namespace Kolomiets\BlogBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class EditPostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', HiddenType::class)
        ;
//            ->add('submit', SubmitType::class, [
//                'label' => 'Submit',
//                'attr' => ['class' => 'btn btn-link glyphicon glyphicon-edit']
//            ])
    }

    public function getName()
    {
        return 'kolomiets_blog_bundle_remove_post_type';
    }
}
