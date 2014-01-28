<?php

namespace Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * AttributeHotelMappingElGr
 */
class AttributeHotelMappingElGr
{
    /**
     * @var integer
     */
    private $attributeID;

    /**
     * @var integer
     */
    private $eanHotelID;

    /**
     * @var string
     */
    private $appendTxt;


    /**
     * Set attributeID
     *
     * @param integer $attributeID
     * @return AttributeHotelMappingElGr
     */
    public function setAttributeID($attributeID)
    {
        $this->attributeID = $attributeID;
    
        return $this;
    }

    /**
     * Get attributeID
     *
     * @return integer 
     */
    public function getAttributeID()
    {
        return $this->attributeID;
    }

    /**
     * Set eanHotelID
     *
     * @param integer $eanHotelID
     * @return AttributeHotelMappingElGr
     */
    public function setEanHotelID($eanHotelID)
    {
        $this->eanHotelID = $eanHotelID;
    
        return $this;
    }

    /**
     * Get eanHotelID
     *
     * @return integer 
     */
    public function getEanHotelID()
    {
        return $this->eanHotelID;
    }

    /**
     * Set appendTxt
     *
     * @param string $appendTxt
     * @return AttributeHotelMappingElGr
     */
    public function setAppendTxt($appendTxt)
    {
        $this->appendTxt = $appendTxt;
    
        return $this;
    }

    /**
     * Get appendTxt
     *
     * @return string 
     */
    public function getAppendTxt()
    {
        return $this->appendTxt;
    }
}