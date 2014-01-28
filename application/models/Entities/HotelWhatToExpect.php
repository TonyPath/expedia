<?php

namespace Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * HotelWhatToExpect
 */
class HotelWhatToExpect
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $whatToExpect;

    /**
     * @var \Entities\Hotel
     */
    private $hotel;


    /**
     * Set id
     *
     * @param integer $id
     * @return HotelWhatToExpect
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
     * Set whatToExpect
     *
     * @param string $whatToExpect
     * @return HotelWhatToExpect
     */
    public function setWhatToExpect($whatToExpect)
    {
        $this->whatToExpect = $whatToExpect;
    
        return $this;
    }

    /**
     * Get whatToExpect
     *
     * @return string 
     */
    public function getWhatToExpect()
    {
        return $this->whatToExpect;
    }

    /**
     * Set hotel
     *
     * @param \Entities\Hotel $hotel
     * @return HotelWhatToExpect
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