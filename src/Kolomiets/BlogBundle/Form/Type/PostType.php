<?php

namespace Kolomiets\BlogBundle\Form\Type;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class PostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, ['label' => 'Title'])
            ->add('text', TextareaType::class)
            ->add('author', TextType::class, ['label' => 'Enter you name'])
            ->add('category', EntityType::class,
                [
                    'label' => 'Category',
                    'choice_label' => 'getName',
                    'multiple' => false,
                    'class' => 'KolomietsBlogBundle:Category',
                ]
            )
            ->add('save', SubmitType::class, ['label' => 'Save']);
    }

    public function getName()
    {
        return 'kolomiets_blog_bundle_post_type';
    }
}
