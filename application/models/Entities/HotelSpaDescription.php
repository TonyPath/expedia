<?php

namespace Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * HotelSpaDescription
 */
class HotelSpaDescription
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $spaDescription;

    /**
     * @var \Entities\Hotel
     */
    private $hotel;


    /**
     * Set id
     *
     * @param integer $id
     * @return HotelSpaDescription
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
     * Set spaDescription
     *
     * @param string $spaDescription
     * @return HotelSpaDescription
     */
    public function setSpaDescription($spaDescription)
    {
        $this->spaDescription = $spaDescription;
    
        return $this;
    }

    /**
     * Get spaDescription
     *
     * @return string 
     */
    public function getSpaDescription()
    {
        return $this->spaDescription;
    }

    /**
     * Set hotel
     *
     * @param \Entities\Hotel $hotel
     * @return HotelSpaDescription
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