<?php

namespace Kolomiets\BlogBundle\DataFixtures\ORM;


use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Kolomiets\BlogBundle\Entity\Category;
use Faker\Factory;

class LoadCategoryData extends AbstractFixture implements OrderedFixtureInterface
{

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();
        for($i = 1; $i <= 6; $i++){
            $category = new Category();
            $category->setName($faker->jobTitle);

            $manager->persist($category);

            $this->addReference('category'.$i, $category);
        }

        $manager->flush();
    }

    /**
     * @return integer
     */
    public function getOrder()
    {
        return 1;
    }
}