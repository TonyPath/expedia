<?php

namespace Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * Hotel
 */
class Hotel
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
    private $address1;

    /**
     * @var string
     */
    private $address2;

    /**
     * @var string
     */
    private $city;

    /**
     * @var string
     */
    private $stateProvince;

    /**
     * @var string
     */
    private $postalCode;

    /**
     * @var string
     */
    private $country;

    /**
     * @var string
     */
    private $latitude;

    /**
     * @var string
     */
    private $longitude;

    /**
     * @var string
     */
    private $airportCode;

    /**
     * @var string
     */
    private $currency;

    /**
     * @var float
     */
    private $starRating;

    /**
     * @var integer
     */
    private $confidence;

    /**
     * @var string
     */
    private $supplierType;

    /**
     * @var string
     */
    private $location;

    /**
     * @var string
     */
    private $highRate;

    /**
     * @var string
     */
    private $lowRate;

    /**
     * @var string
     */
    private $checkInTime;

    /**
     * @var string
     */
    private $checkOutTime;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $regions;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $images;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $attributes;

    /**
     * @var \Entities\HotelType
     */
    private $category;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->regions = new \Doctrine\Common\Collections\ArrayCollection();
        $this->images = new \Doctrine\Common\Collections\ArrayCollection();
        $this->attributes = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Set id
     *
     * @param integer $id
     * @return Hotel
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
     * @return Hotel
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
     * Set address1
     *
     * @param string $address1
     * @return Hotel
     */
    public function setAddress1($address1)
    {
        $this->address1 = $address1;
    
        return $this;
    }

    /**
     * Get address1
     *
     * @return string 
     */
    public function getAddress1()
    {
        return $this->address1;
    }

    /**
     * Set address2
     *
     * @param string $address2
     * @return Hotel
     */
    public function setAddress2($address2)
    {
        $this->address2 = $address2;
    
        return $this;
    }

    /**
     * Get address2
     *
     * @return string 
     */
    public function getAddress2()
    {
        return $this->address2;
    }

    /**
     * Set city
     *
     * @param string $city
     * @return Hotel
     */
    public function setCity($city)
    {
        $this->city = $city;
    
        return $this;
    }

    /**
     * Get city
     *
     * @return string 
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set stateProvince
     *
     * @param string $stateProvince
     * @return Hotel
     */
    public function setStateProvince($stateProvince)
    {
        $this->stateProvince = $stateProvince;
    
        return $this;
    }

    /**
     * Get stateProvince
     *
     * @return string 
     */
    public function getStateProvince()
    {
        return $this->stateProvince;
    }

    /**
     * Set postalCode
     *
     * @param string $postalCode
     * @return Hotel
     */
    public function setPostalCode($postalCode)
    {
        $this->postalCode = $postalCode;
    
        return $this;
    }

    /**
     * Get postalCode
     *
     * @return string 
     */
    public function getPostalCode()
    {
        return $this->postalCode;
    }

    /**
     * Set country
     *
     * @param string $country
     * @return Hotel
     */
    public function setCountry($country)
    {
        $this->country = $country;
    
        return $this;
    }

    /**
     * Get country
     *
     * @return string 
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set latitude
     *
     * @param string $latitude
     * @return Hotel
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;
    
        return $this;
    }

    /**
     * Get latitude
     *
     * @return string 
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Set longitude
     *
     * @param string $longitude
     * @return Hotel
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;
    
        return $this;
    }

    /**
     * Get longitude
     *
     * @return string 
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * Set airportCode
     *
     * @param string $airportCode
     * @return Hotel
     */
    public function setAirportCode($airportCode)
    {
        $this->airportCode = $airportCode;
    
        return $this;
    }

    /**
     * Get airportCode
     *
     * @return string 
     */
    public function getAirportCode()
    {
        return $this->airportCode;
    }

    /**
     * Set currency
     *
     * @param string $currency
     * @return Hotel
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;
    
        return $this;
    }

    /**
     * Get currency
     *
     * @return string 
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * Set starRating
     *
     * @param float $starRating
     * @return Hotel
     */
    public function setStarRating($starRating)
    {
        $this->starRating = $starRating;
    
        return $this;
    }

    /**
     * Get starRating
     *
     * @return float 
     */
    public function getStarRating()
    {
        return $this->starRating;
    }

    /**
     * Set confidence
     *
     * @param integer $confidence
     * @return Hotel
     */
    public function setConfidence($confidence)
    {
        $this->confidence = $confidence;
    
        return $this;
    }

    /**
     * Get confidence
     *
     * @return integer 
     */
    public function getConfidence()
    {
        return $this->confidence;
    }

    /**
     * Set supplierType
     *
     * @param string $supplierType
     * @return Hotel
     */
    public function setSupplierType($supplierType)
    {
        $this->supplierType = $supplierType;
    
        return $this;
    }

    /**
     * Get supplierType
     *
     * @return string 
     */
    public function getSupplierType()
    {
        return $this->supplierType;
    }

    /**
     * Set location
     *
     * @param string $location
     * @return Hotel
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
     * Set highRate
     *
     * @param string $highRate
     * @return Hotel
     */
    public function setHighRate($highRate)
    {
        $this->highRate = $highRate;
    
        return $this;
    }

    /**
     * Get highRate
     *
     * @return string 
     */
    public function getHighRate()
    {
        return $this->highRate;
    }

    /**
     * Set lowRate
     *
     * @param string $lowRate
     * @return Hotel
     */
    public function setLowRate($lowRate)
    {
        $this->lowRate = $lowRate;
    
        return $this;
    }

    /**
     * Get lowRate
     *
     * @return string 
     */
    public function getLowRate()
    {
        return $this->lowRate;
    }

    /**
     * Set checkInTime
     *
     * @param string $checkInTime
     * @return Hotel
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
     * @return Hotel
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
     * Add regions
     *
     * @param \Entities\RegionHotelMapping $regions
     * @return Hotel
     */
    public function addRegion(\Entities\RegionHotelMapping $regions)
    {
        $this->regions[] = $regions;
    
        return $this;
    }

    /**
     * Remove regions
     *
     * @param \Entities\RegionHotelMapping $regions
     */
    public function removeRegion(\Entities\RegionHotelMapping $regions)
    {
        $this->regions->removeElement($regions);
    }

    /**
     * Get regions
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getRegions()
    {
        return $this->regions;
    }

    /**
     * Add images
     *
     * @param \Entities\HotelImage $images
     * @return Hotel
     */
    public function addImage(\Entities\HotelImage $images)
    {
        $this->images[] = $images;
    
        return $this;
    }

    /**
     * Remove images
     *
     * @param \Entities\HotelImage $images
     */
    public function removeImage(\Entities\HotelImage $images)
    {
        $this->images->removeElement($images);
    }

    /**
     * Get images
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * Add attributes
     *
     * @param \Entities\AttributeHotelMapping $attributes
     * @return Hotel
     */
    public function addAttribute(\Entities\AttributeHotelMapping $attributes)
    {
        $this->attributes[] = $attributes;
    
        return $this;
    }

    /**
     * Remove attributes
     *
     * @param \Entities\AttributeHotelMapping $attributes
     */
    public function removeAttribute(\Entities\AttributeHotelMapping $attributes)
    {
        $this->attributes->removeElement($attributes);
    }

    /**
     * Get attributes
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * Set category
     *
     * @param \Entities\HotelType $category
     * @return Hotel
     */
    public function setCategory(\Entities\HotelType $category = null)
    {
        $this->category = $category;
    
        return $this;
    }

    /**
     * Get category
     *
     * @return \Entities\HotelType 
     */
    public function getCategory()
    {
        return $this->category;
    }
}