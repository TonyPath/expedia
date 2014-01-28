<?php

namespace Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * HotelDescriptionElGr
 */
class HotelDescriptionElGr
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
     * @var \Entities\HotelElGr
     */
    private $hotel;


    /**
     * Set id
     *
     * @param integer $id
     * @return HotelDescriptionElGr
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
     * @return HotelDescriptionElGr
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
     * @param \Entities\HotelElGr $hotel
     * @return HotelDescriptionElGr
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