<?php

namespace Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * HotelAreaAttraction
 */
class HotelAreaAttraction
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $areaAttractions;

    /**
     * @var \Entities\Hotel
     */
    private $hotel;


    /**
     * Set id
     *
     * @param integer $id
     * @return HotelAreaAttraction
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
     * Set areaAttractions
     *
     * @param string $areaAttractions
     * @return HotelAreaAttraction
     */
    public function setAreaAttractions($areaAttractions)
    {
        $this->areaAttractions = $areaAttractions;
    
        return $this;
    }

    /**
     * Get areaAttractions
     *
     * @return string 
     */
    public function getAreaAttractions()
    {
        return $this->areaAttractions;
    }

    /**
     * Set hotel
     *
     * @param \Entities\Hotel $hotel
     * @return HotelAreaAttraction
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