<?php

namespace Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * HotelAreaAttractionElGr
 */
class HotelAreaAttractionElGr
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
     * @var \Entities\HotelElGr
     */
    private $hotel;


    /**
     * Set id
     *
     * @param integer $id
     * @return HotelAreaAttractionElGr
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
     * @return HotelAreaAttractionElGr
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
     * @param \Entities\HotelElGr $hotel
     * @return HotelAreaAttractionElGr
     */
    public function setHotel(\Entities\HotelElGr $hotel = null)
    {
        $this->hotel = $hotel;
    
        return $this;
    }

    /**
     * Get hotel
     *
     * @return \Entities\HotelElGr 
     */
    public function getHotel()
    {
        return $this->hotel;
    }
}