<?php

namespace AppBundle\Entity;
use Doctrine\Common\Collections\ArrayCollection;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="pot")
 */
class Pot
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="mac", type="string", length=255)
     */
    private $mac;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="Moisture", mappedBy="pot")
     */
    private $moistures;

    /**
     * @ORM\OneToMany(targetEntity="Temperature", mappedBy="pot")
     */
    private $temperatures;

    /**
     * @ORM\ManyToOne(targetEntity="Profil", inversedBy="pots")
     * @ORM\JoinColumn(name="profil_id", referencedColumnName="id")
     */
     private $profil;


    public function __construct()
    {
        parent::__construct();
        $this->moistures = new ArrayCollection();
        $this->temperatures = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set mac
     *
     * @param string $mac
     *
     * @return Pot
     */
    public function setMac($mac)
    {
        $this->mac = $mac;

        return $this;
    }

    /**
     * Get mac
     *
     * @return string
     */
    public function getMac()
    {
        return $this->mac;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Pot
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Add moisture
     *
     * @param \AppBundle\Entity\Moisture $moisture
     *
     * @return Pot
     */
    public function addMoisture(\AppBundle\Entity\Moisture $moisture)
    {
        $this->moistures[] = $moisture;

        return $this;
    }

    /**
     * Remove moisture
     *
     * @param \AppBundle\Entity\Moisture $moisture
     */
    public function removeMoisture(\AppBundle\Entity\Moisture $moisture)
    {
        $this->moistures->removeElement($moisture);
    }

    /**
     * Get moistures
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMoistures()
    {
        return $this->moistures;
    }

    /**
     * Add temperature
     *
     * @param \AppBundle\Entity\Temperature $temperature
     *
     * @return Pot
     */
    public function addTemperature(\AppBundle\Entity\Temperature $temperature)
    {
        $this->temperatures[] = $temperature;

        return $this;
    }

    /**
     * Remove temperature
     *
     * @param \AppBundle\Entity\Temperature $temperature
     */
    public function removeTemperature(\AppBundle\Entity\Temperature $temperature)
    {
        $this->temperatures->removeElement($temperature);
    }

    /**
     * Get temperatures
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTemperatures()
    {
        return $this->temperatures;
    }

    /**
     * Set profil
     *
     * @param \AppBundle\Entity\Profil $profil
     *
     * @return Pot
     */
    public function setProfil(\AppBundle\Entity\Profil $profil = null)
    {
        $this->profil = $profil;

        return $this;
    }

    /**
     * Get profil
     *
     * @return \AppBundle\Entity\profil
     */
    public function getProfil()
    {
        return $this->profil;
    }
}
