<?php

namespace Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * HotelAttributeElGr
 */
class HotelAttributeElGr
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
     * Set id
     *
     * @param integer $id
     * @return HotelAttributeElGr
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
     * @return HotelAttributeElGr
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
}
