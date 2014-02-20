<?php

namespace Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * HotelElGr
 */
class HotelElGr
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $location;

    /**
     * @var string
     */
    private $checkInTime;

    /**
     * @var string
     */
    private $checkOutTime;

    /**
     * @var \Entities\HotelDescriptionElGr
     */
    private $description;

    /**
     * @var \Entities\HotelPolicyElGr
     */
    private $policy;

    /**
     * @var \Entities\HotelAreaAttractionElGr
     */
    private $areaAttractions;

    /**
     * @var \Entities\HotelWhatToExpectElGr
     */
    private $whatToExpect;

    /**
     * @var \Entities\HotelSpaDescriptionElGr
     */
    private $spaDescription;

    /**
     * @var \Entities\HotelDiningDescriptionElGr
     */
    private $diningDescription;


    /**
     * Set id
     *
     * @param integer $id
     * @return HotelElGr
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
     * Set name
     *
     * @param string $name
     * @return HotelElGr
     */
    public function setName($name)
    {
        $this->name = $name;
    
        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set location
     *
     * @param string $location
     * @return HotelElGr
     */
    public function setLocation($location)
    {
        $this->location = $location;
    
        return $this;
    }

    /**
     * Get location
     *
     * @return string 
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * Set checkInTime
     *
     * @param string $checkInTime
     * @return HotelElGr
     */
    public function setCheckInTime($checkInTime)
    {
        $this->checkInTime = $checkInTime;
    
        return $this;
    }

    /**
     * Get checkInTime
     *
     * @return string 
     */
    public function getCheckInTime()
    {
        return $this->checkInTime;
    }

    /**
     * Set checkOutTime
     *
     * @param string $checkOutTime
     * @return HotelElGr
     */
    public function setCheckOutTime($checkOutTime)
    {
        $this->checkOutTime = $checkOutTime;
    
        return $this;
    }

    /**
     * Get checkOutTime
     *
     * @return string 
     */
    public function getCheckOutTime()
    {
        return $this->checkOutTime;
    }

    /**
     * Set description
     *
     * @param \Entities\HotelDescriptionElGr $description
     * @return HotelElGr
     */
    public function setDescription(\Entities\HotelDescriptionElGr $description = null)
    {
        $this->description = $description;
    
        return $this;
    }

    /**
     * Get description
     *
     * @return \Entities\HotelDescriptionElGr 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set policy
     *
     * @param \Entities\HotelPolicyElGr $policy
     * @return HotelElGr
     */
    public function setPolicy(\Entities\HotelPolicyElGr $policy = null)
    {
        $this->policy = $policy;
    
        return $this;
    }

    /**
     * Get policy
     *
     * @return \Entities\HotelPolicyElGr 
     */
    public function getPolicy()
    {
        return $this->policy;
    }

    /**
     * Set areaAttractions
     *
     * @param \Entities\HotelAreaAttractionElGr $areaAttractions
     * @return HotelElGr
     */
    public function setAreaAttractions(\Entities\HotelAreaAttractionElGr $areaAttractions = null)
    {
        $this->areaAttractions = $areaAttractions;
    
        return $this;
    }

    /**
     * Get areaAttractions
     *
     * @return \Entities\HotelAreaAttractionElGr 
     */
    public function getAreaAttractions()
    {
        return $this->areaAttractions;
    }

    /**
     * Set whatToExpect
     *
     * @param \Entities\HotelWhatToExpectElGr $whatToExpect
     * @return HotelElGr
     */
    public function setWhatToExpect(\Entities\HotelWhatToExpectElGr $whatToExpect = null)
    {
        $this->whatToExpect = $whatToExpect;
    
        return $this;
    }

    /**
     * Get whatToExpect
     *
     * @return \Entities\HotelWhatToExpectElGr 
     */
    public function getWhatToExpect()
    {
        return $this->whatToExpect;
    }

    /**
     * Set spaDescription
     *
     * @param \Entities\HotelSpaDescriptionElGr $spaDescription
     * @return HotelElGr
     */
    public function setSpaDescription(\Entities\HotelSpaDescriptionElGr $spaDescription = null)
    {
        $this->spaDescription = $spaDescription;
    
        return $this;
    }

    /**
     * Get spaDescription
     *
     * @return \Entities\HotelSpaDescriptionElGr 
     */
    public function getSpaDescription()
    {
        return $this->spaDescription;
    }

    /**
     * Set diningDescription
     *
     * @param \Entities\HotelDiningDescriptionElGr $diningDescription
     * @return HotelElGr
     */
    public function setDiningDescription(\Entities\HotelDiningDescriptionElGr $diningDescription = null)
    {
        $this->diningDescription = $diningDescription;
    
        return $this;
    }

    /**
     * Get diningDescription
     *
     * @return \Entities\HotelDiningDescriptionElGr 
     */
    public function getDiningDescription()
    {
        return $this->diningDescription;
    }
}