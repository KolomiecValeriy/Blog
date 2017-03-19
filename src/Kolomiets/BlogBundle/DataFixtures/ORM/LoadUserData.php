<?php

namespace Kolomiets\BlogBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Kolomiets\BlogBundle\Entity\User;

class LoadUserData extends AbstractFixture implements ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @param ContainerInterface|null $container A ContainerInterface instance or null
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $encoder = $this->container->get('security.password_encoder');

        $user = new User();
        $admin = new User();
        $password = $encoder->encodePassword($user, 'password');

        $user
            ->setUsername('user')
            ->setUsernameCanonical('user')
            ->setEmail('user@example.com')
            ->setEmailCanonical('user@example.com')
            ->setEnabled(true)
            ->setPassword($password)
            ->setRoles(['role' => 'ROLE_USER'])
        ;

        $password = $encoder->encodePassword($admin, 'passw0rd');
        $admin
            ->setUsername('admin')
            ->setUsernameCanonical('admin')
            ->setEmail('admin@example.com')
            ->setEmailCanonical('admin@example.com')
            ->setEnabled(true)
            ->setPassword($password)
            ->setRoles(['role' => 'ROLE_SUPER_ADMIN'])
        ;

        $manager->persist($user);
        $manager->persist($admin);
        $manager->flush();
    }
}