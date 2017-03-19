<?php

namespace Kolomiets\BlogBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Kolomiets\BlogBundle\Entity\Comment;
use Faker\Factory;

class LoadCommentData extends AbstractFixture implements OrderedFixtureInterface
{

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();
        for($i = 1; $i <= 20; $i++){
            $comment = new Comment();
            $comment
                ->setText($faker->text(rand(50, 255)))
                ->setCreatedAt($faker->dateTimeBetween('-5 month', 'now'))
                ->setAuthor($faker->name)
                ->setPost($this->getReference('post'.rand(1, 14)))
            ;
            $manager->persist($comment);
        }

        $manager->flush();
    }

    /**
     * @return integer
     */
    public function getOrder()
    {
        return 3;
    }
}