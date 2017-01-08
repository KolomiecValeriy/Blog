<?php

namespace Kolomiets\BlogBundle\Menu;

use Knp\Menu\FactoryInterface;

class MenuBuilder
{
    private $factory;

    /**
     * @param FactoryInterface $factory
     *
     * Add any other dependency you need
     */
    public function __construct(FactoryInterface $factory)
    {
        $this->factory = $factory;
    }

    public function createMainMenu(array $options)
    {
        $menu = $this->factory->createItem('mainMenu');

        $menu->addChild('All posts', array('route' => 'show_posts'));
        $menu->addChild('Add post', array('route' => 'add_post'));
        $menu->setChildrenAttribute('class', 'nav navbar-nav');

        return $menu;
    }
}