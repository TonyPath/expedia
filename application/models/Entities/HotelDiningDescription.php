<?php

namespace Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * HotelDiningDescription
 */
class HotelDiningDescription
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $diningDescription;

    /**
     * @var \Entities\Hotel
     */
    private $hotel;


    /**
     * Set id
     *
     * @param integer $id
     * @return HotelDiningDescription
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
     * Set diningDescription
     *
     * @param string $diningDescription
     * @return HotelDiningDescription
     */
    public function setDiningDescription($diningDescription)
    {
        $this->diningDescription = $diningDescription;
    
        return $this;
    }

    /**
     * Get diningDescription
     *
     * @return string 
     */
    public function getDiningDescription()
    {
        return $this->diningDescription;
    }

    /**
     * Set hotel
     *
     * @param \Entities\Hotel $hotel
     * @return HotelDiningDescription
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