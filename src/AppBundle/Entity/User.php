<?php

namespace AppBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
    * @ORM\ManyToMany(targetEntity="Pot",  cascade={"persist"})
    */
    private $pots;

    public function __construct()
    {
        parent::__construct();
        $this->pots = new ArrayCollection();
    }

    /**
     * Add pot
     *
     * @param \AppBundle\Entity\Pot $pot
     *
     * @return User
     */
    public function addPot(\AppBundle\Entity\Pot $pot)
    {
        $this->pots[] = $pot;

        return $this;
    }

    /**
     * Remove pot
     *
     * @param \AppBundle\Entity\Pot $pot
     */
    public function removePot(\AppBundle\Entity\Pot $pot)
    {
        $this->pots->removeElement($pot);
    }

    /**
     * Get pots
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPots()
    {
        return $this->pots;
    }
}
