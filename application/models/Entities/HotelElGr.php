<?php

namespace Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * HotelElGr
 */
class HotelElGr
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
    private $location;

    /**
     * @var string
     */
    private $checkInTime;

    /**
     * @var string
     */
    private $checkOutTime;


    /**
     * Set id
     *
     * @param integer $id
     * @return HotelElGr
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
     * @return HotelElGr
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
     * Set location
     *
     * @param string $location
     * @return HotelElGr
     */
    public function setLocation($location)
    {
        $this->location = $location;
    
        return $this;
    }

    /**
     * Get location
     *
     * @return string 
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * Set checkInTime
     *
     * @param string $checkInTime
     * @return HotelElGr
     */
    public function setCheckInTime($checkInTime)
    {
        $this->checkInTime = $checkInTime;
    
        return $this;
    }

    /**
     * Get checkInTime
     *
     * @return string 
     */
    public function getCheckInTime()
    {
        return $this->checkInTime;
    }

    /**
     * Set checkOutTime
     *
     * @param string $checkOutTime
     * @return HotelElGr
     */
    public function setCheckOutTime($checkOutTime)
    {
        $this->checkOutTime = $checkOutTime;
    
        return $this;
    }

    /**
     * Get checkOutTime
     *
     * @return string 
     */
    public function getCheckOutTime()
    {
        return $this->checkOutTime;
    }
}