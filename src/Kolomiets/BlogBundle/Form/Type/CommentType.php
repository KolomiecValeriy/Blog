<?php

namespace Kolomiets\BlogBundle\Form\Type;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class CommentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('text', TextareaType::class)
            ->add('author', TextType::class, ['label' => 'Enter you name'])
            ->add('save', SubmitType::class, ['label' => 'Send']);
    }

    public function getName()
    {
        return 'kolomiets_blog_bundle_post_type';
    }
}
