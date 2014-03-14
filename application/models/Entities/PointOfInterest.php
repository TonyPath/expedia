<?php

namespace Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * PointOfInterest
 */
class PointOfInterest
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
    private $nameLong;

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
    private $classification;

    /**
     * @var \Entities\Region
     */
    private $region;


    /**
     * Set id
     *
     * @param integer $id
     * @return PointOfInterest
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
     * @return PointOfInterest
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
     * Set nameLong
     *
     * @param string $nameLong
     * @return PointOfInterest
     */
    public function setNameLong($nameLong)
    {
        $this->nameLong = $nameLong;
    
        return $this;
    }

    /**
     * Get nameLong
     *
     * @return string 
     */
    public function getNameLong()
    {
        return $this->nameLong;
    }

    /**
     * Set latitude
     *
     * @param string $latitude
     * @return PointOfInterest
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
     * @return PointOfInterest
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
     * Set classification
     *
     * @param string $classification
     * @return PointOfInterest
     */
    public function setClassification($classification)
    {
        $this->classification = $classification;
    
        return $this;
    }

    /**
     * Get classification
     *
     * @return string 
     */
    public function getClassification()
    {
        return $this->classification;
    }

    /**
     * Set region
     *
     * @param \Entities\Region $region
     * @return PointOfInterest
     */
    public function setRegion(\Entities\Region $region = null)
    {
        $this->region = $region;
    
        return $this;
    }

    /**
     * Get region
     *
     * @return \Entities\Region 
     */
    public function getRegion()
    {
        return $this->region;
    }
}