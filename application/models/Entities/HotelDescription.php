<?php

namespace Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * HotelDescription
 */
class HotelDescription
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
     * @var \Entities\Hotel
     */
    private $hotel;


    /**
     * Set id
     *
     * @param integer $id
     * @return HotelDescription
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
     * @return HotelDescription
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
     * Set hotel
     *
     * @param \Entities\Hotel $hotel
     * @return HotelDescription
     */
    public function setHotel(\Entities\Hotel $hotel = null)
    {
        $this->hotel = $hotel;
    
        return $this;
    }

    /**
     * Get hotel
     *
     * @return \Entities\Hotel 
     */
    public function getHotel()
    {
        return $this->hotel;
    }
}