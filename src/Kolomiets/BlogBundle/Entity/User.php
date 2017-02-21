<?php

namespace Kolomiets\BlogBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * User
 *
 * @ORM\Table(name="fos_user")
 * @ORM\Entity(repositoryClass="Kolomiets\BlogBundle\Repository\UserRepository")
 */
class User extends BaseUser
{
    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=25, unique=true)
     */
//    private $name;
//
//    public function __construct()
//    {
//        parent::__construct();
//    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return User
     */
//    public function setName($name)
//    {
//        $this->name = $name;
//
//        return $this;
//    }

    /**
     * Get name
     *
     * @return string
     */
//    public function getName()
//    {
//        return $this->name;
//    }
}

