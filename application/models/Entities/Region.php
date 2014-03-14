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
     * @var string
     */
    private $subClass;

    /**
     * @var string
     */
    private $type;

    /**
     * @var integer
     */
    private $parentID;

    /**
     * @var string
     */
    private $parentType;

    /**
     * @var string
     */
    private $parentName;

    /**
     * @var string
     */
    private $parentNameLong;

    /**
     * @var \Entities\RegionCenterCoordinates
     */
    private $coordinates;

    /**
     * @var \Entities\PointOfInterest
     */
    private $poi;

    /**
     * @var \Entities\City
     */
    private $city;

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
     * Set subClass
     *
     * @param string $subClass
     * @return Region
     */
    public function setSubClass($subClass)
    {
        $this->subClass = $subClass;
    
        return $this;
    }

    /**
     * Get subClass
     *
     * @return string 
     */
    public function getSubClass()
    {
        return $this->subClass;
    }

    /**
     * Set type
     *
     * @param string $type
     * @return Region
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
     * Set parentID
     *
     * @param integer $parentID
     * @return Region
     */
    public function setParentID($parentID)
    {
        $this->parentID = $parentID;
    
        return $this;
    }

    /**
     * Get parentID
     *
     * @return integer 
     */
    public function getParentID()
    {
        return $this->parentID;
    }

    /**
     * Set parentType
     *
     * @param string $parentType
     * @return Region
     */
    public function setParentType($parentType)
    {
        $this->parentType = $parentType;
    
        return $this;
    }

    /**
     * Get parentType
     *
     * @return string 
     */
    public function getParentType()
    {
        return $this->parentType;
    }

    /**
     * Set parentName
     *
     * @param string $parentName
     * @return Region
     */
    public function setParentName($parentName)
    {
        $this->parentName = $parentName;
    
        return $this;
    }

    /**
     * Get parentName
     *
     * @return string 
     */
    public function getParentName()
    {
        return $this->parentName;
    }

    /**
     * Set parentNameLong
     *
     * @param string $parentNameLong
     * @return Region
     */
    public function setParentNameLong($parentNameLong)
    {
        $this->parentNameLong = $parentNameLong;
    
        return $this;
    }

    /**
     * Get parentNameLong
     *
     * @return string 
     */
    public function getParentNameLong()
    {
        return $this->parentNameLong;
    }

    /**
     * Set coordinates
     *
     * @param \Entities\RegionCenterCoordinates $coordinates
     * @return Region
     */
    public function setCoordinates(\Entities\RegionCenterCoordinates $coordinates = null)
    {
        $this->coordinates = $coordinates;
    
        return $this;
    }

    /**
     * Get coordinates
     *
     * @return \Entities\RegionCenterCoordinates 
     */
    public function getCoordinates()
    {
        return $this->coordinates;
    }

    /**
     * Set poi
     *
     * @param \Entities\PointOfInterest $poi
     * @return Region
     */
    public function setPoi(\Entities\PointOfInterest $poi = null)
    {
        $this->poi = $poi;
    
        return $this;
    }

    /**
     * Get poi
     *
     * @return \Entities\PointOfInterest 
     */
    public function getPoi()
    {
        return $this->poi;
    }

    /**
     * Set city
     *
     * @param \Entities\City $city
     * @return Region
     */
    public function setCity(\Entities\City $city = null)
    {
        $this->city = $city;
    
        return $this;
    }

    /**
     * Get city
     *
     * @return \Entities\City 
     */
    public function getCity()
    {
        return $this->city;
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
