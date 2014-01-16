<?php

namespace Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * HotelImage
 */
class HotelImage
{
    /**
     * @var string
     */
    private $url;

    /**
     * @var integer
     */
    private $hotelID;

    /**
     * @var string
     */
    private $caption;

    /**
     * @var string
     */
    private $thumbURL;

    /**
     * @var \Entities\Hotel
     */
    private $hotel;


    /**
     * Set url
     *
     * @param string $url
     * @return HotelImage
     */
    public function setUrl($url)
    {
        $this->url = $url;
    
        return $this;
    }

    /**
     * Get url
     *
     * @return string 
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set hotelID
     *
     * @param integer $hotelID
     * @return HotelImage
     */
    public function setHotelID($hotelID)
    {
        $this->hotelID = $hotelID;
    
        return $this;
    }

    /**
     * Get hotelID
     *
     * @return integer 
     */
    public function getHotelID()
    {
        return $this->hotelID;
    }

    /**
     * Set caption
     *
     * @param string $caption
     * @return HotelImage
     */
    public function setCaption($caption)
    {
        $this->caption = $caption;
    
        return $this;
    }

    /**
     * Get caption
     *
     * @return string 
     */
    public function getCaption()
    {
        return $this->caption;
    }

    /**
     * Set thumbURL
     *
     * @param string $thumbURL
     * @return HotelImage
     */
    public function setThumbURL($thumbURL)
    {
        $this->thumbURL = $thumbURL;
    
        return $this;
    }

    /**
     * Get thumbURL
     *
     * @return string 
     */
    public function getThumbURL()
    {
        return $this->thumbURL;
    }

    /**
     * Set hotel
     *
     * @param \Entities\Hotel $hotel
     * @return HotelImage
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