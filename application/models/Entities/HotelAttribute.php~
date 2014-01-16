<?php

namespace Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * HotelAttribute
 */
class HotelAttribute
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $description;

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
     * @return HotelAttribute
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
     * Set description
     *
     * @param string $description
     * @return HotelAttribute
     */
    public function setDescription($description)
    {
        $this->description = $description;
    
        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Add hotels
     *
     * @param \Entities\AttributeHotelMapping $hotels
     * @return HotelAttribute
     */
    public function addHotel(\Entities\AttributeHotelMapping $hotels)
    {
        $this->hotels[] = $hotels;
    
        return $this;
    }

    /**
     * Remove hotels
     *
     * @param \Entities\AttributeHotelMapping $hotels
     */
    public function removeHotel(\Entities\AttributeHotelMapping $hotels)
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