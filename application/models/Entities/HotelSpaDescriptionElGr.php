<?php

namespace Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * HotelSpaDescriptionElGr
 */
class HotelSpaDescriptionElGr
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
     * @var \Entities\HotelElGr
     */
    private $hotel;


    /**
     * Set id
     *
     * @param integer $id
     * @return HotelSpaDescriptionElGr
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
     * @return HotelSpaDescriptionElGr
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
     * @param \Entities\HotelElGr $hotel
     * @return HotelSpaDescriptionElGr
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