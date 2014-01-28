<?php

namespace Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * HotelWhatToExpectElGr
 */
class HotelWhatToExpectElGr
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
     * @var \Entities\HotelElGr
     */
    private $hotel;


    /**
     * Set id
     *
     * @param integer $id
     * @return HotelWhatToExpectElGr
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
     * @return HotelWhatToExpectElGr
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
     * @param \Entities\HotelElGr $hotel
     * @return HotelWhatToExpectElGr
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