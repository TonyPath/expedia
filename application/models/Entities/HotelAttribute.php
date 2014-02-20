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
     * @var string
     */
    private $type;

    /**
     * @var string
     */
    private $subType;

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
     * Set type
     *
     * @param string $type
     * @return HotelAttribute
     */
    public function setType($type)
    {
        $this->type = $type;
    
        return $this;
    }

    /**
     * Get type
     *
     * @return string 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set subType
     *
     * @param string $subType
     * @return HotelAttribute
     */
    public function setSubType($subType)
    {
        $this->subType = $subType;
    
        return $this;
    }

    /**
     * Get subType
     *
     * @return string 
     */
    public function getSubType()
    {
        return $this->subType;
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