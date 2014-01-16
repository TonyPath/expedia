<?php

namespace Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * HotelType
 */
class HotelType
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $hotels;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->hotels = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Set id
     *
     * @param integer $id
     * @return HotelType
     */
    public function setId($id)
    {
        $this->id = $id;
    
        return $this;
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
     * Set name
     *
     * @param string $name
     * @return HotelType
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
     * Add hotels
     *
     * @param \Entities\Hotel $hotels
     * @return HotelType
     */
    public function addHotel(\Entities\Hotel $hotels)
    {
        $this->hotels[] = $hotels;
    
        return $this;
    }

    /**
     * Remove hotels
     *
     * @param \Entities\Hotel $hotels
     */
    public function removeHotel(\Entities\Hotel $hotels)
    {
        $this->hotels->removeElement($hotels);
    }

    /**
     * Get hotels
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getHotels()
    {
        return $this->hotels;
    }
}