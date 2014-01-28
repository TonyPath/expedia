<?php

namespace Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * HotelDiningDescriptionElGr
 */
class HotelDiningDescriptionElGr
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
     * @var \Entities\HotelElGr
     */
    private $hotel;


    /**
     * Set id
     *
     * @param integer $id
     * @return HotelDiningDescriptionElGr
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
     * @return HotelDiningDescriptionElGr
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
     * @param \Entities\HotelElGr $hotel
     * @return HotelDiningDescriptionElGr
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