<?php

namespace Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * Region
 */
class Region
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
     * @var string
     */
    private $nameLong;

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
     * @return Region
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
     * @return Region
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
     * Set nameLong
     *
     * @param string $nameLong
     * @return Region
     */
    public function setNameLong($nameLong)
    {
        $this->nameLong = $nameLong;
    
        return $this;
    }

    /**
     * Get nameLong
     *
     * @return string 
     */
    public function getNameLong()
    {
        return $this->nameLong;
    }

    /**
     * Add hotels
     *
     * @param \Entities\RegionHotelMapping $hotels
     * @return Region
     */
    public function addHotel(\Entities\RegionHotelMapping $hotels)
    {
        $this->hotels[] = $hotels;
    
        return $this;
    }

    /**
     * Remove hotels
     *
     * @param \Entities\RegionHotelMapping $hotels
     */
    public function removeHotel(\Entities\RegionHotelMapping $hotels)
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