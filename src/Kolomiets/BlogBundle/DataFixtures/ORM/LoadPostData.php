<?php

namespace Kolomiets\BlogBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Kolomiets\BlogBundle\Entity\Post;
use Faker\Factory;

class LoadPostData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();
        for($i = 1; $i <= 14; $i++){
            $post = new Post();
            $post
                ->setName($faker->text(rand(5, 50)))
                ->setText($faker->text(rand(400, 1000)))
                ->setAuthor($faker->name)
                ->setCategory($this->getReference('category'.rand(1, 6)))
                ->setCreatedAt($faker->dateTimeBetween('-5 month', 'now'))
                ->setPosted(true)
            ;
            $manager->persist($post);

            $this->addReference('post'.$i, $post);
        }

        $manager->flush();
    }

    /**
     * @return integer
     */
    public function getOrder()
    {
        return 2;
    }
}