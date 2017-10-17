<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="profil")
 */
class Profil
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var float
     *
     * @ORM\Column(name="min_moisture", type="float")
     */
    private $minMoisture;

    /**
     * @var float
     *
     * @ORM\Column(name="max_temperature", type="float")
     */
    private $maxTemperature;

    /**
     * @ORM\OneToMany(targetEntity="Profil", mappedBy="pot")
     */
    private $pots;



    public function __construct()
    {
        parent::__construct();
        $this->pots = new ArrayCollection();
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
     * Set minMoisture
     *
     * @param float $minMoisture
     *
     * @return Profil
     */
    public function setMinMoisture($minMoisture)
    {
        $this->minMoisture = $minMoisture;

        return $this;
    }

    /**
     * Get minMoisture
     *
     * @return float
     */
    public function getMinMoisture()
    {
        return $this->minMoisture;
    }

    /**
     * Set maxTemperature
     *
     * @param float $maxTemperature
     *
     * @return Profil
     */
    public function setMaxTemperature($maxTemperature)
    {
        $this->maxTemperature = $maxTemperature;

        return $this;
    }

    /**
     * Get maxTemperature
     *
     * @return float
     */
    public function getMaxTemperature()
    {
        return $this->maxTemperature;
    }

    /**
     * Add pot
     *
     * @param \AppBundle\Entity\Pot $pot
     *
     * @return Pot
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
    public function removepot(\AppBundle\Entity\Pot $pot)
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
