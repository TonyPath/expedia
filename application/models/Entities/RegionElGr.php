<?php

namespace Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * RegionElGr
 */
class RegionElGr
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
     * Set id
     *
     * @param integer $id
     * @return RegionElGr
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
     * @return RegionElGr
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
     * @return RegionElGr
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
}