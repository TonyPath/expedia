<?php
require_once APPPATH . "libraries/JSONResponse.php";            

/**
 * Handles HTTP Requests
 * 
 * Notice: 
 * 
 * This is a core library, which means that many things depend on. 
 * 1) Please notify original authors for any changes (via email, blog post or wiki article)
 * 1a) Just notify, if you really need changes do them, don't wait for feedback
 * 2) Please cleary document any new additions
 * 3) If you change current functionality please discuss with team before commiting and document in the wiki afterwards 
 * 
 * @author foufos <jerry.manolarakis@spitogatos.gr>
 * @copyright Copyright © 2013, Spitogatos.gr
 * @package HTTP
 * @version svn:$Id$
 */  
class HTTPRequest {
    
    /**
     * JSONResponse object
     * @var JSONResponse|false
     */
    protected $jsonResponse    = false;
    
    /**
     * Accepted Formats    
     * @var array
     */
    protected $acceptedFormats = array();
    
    /**
     * Best accept format
     * @var string
     */
    protected $acceptFormat    = "html";
    
    /**
     * Is AJAX flag
     * @var bool
     */
    protected $isAjax          = false;
    
    /**
     * Is JSON flag
     * @var bool
     */
    protected $isJson          = false;
    
    /**
     * Is SG Ajax format flag
     * @var bool
     */    
    protected $isSGAjax        = false;
        
    /**
     * Request types
     * 
     * @todo make static (if we ever need them outside the scope of the class)
     * @var array
     */
    protected $requestTypes    = array(
        // js
        "text/javascript" => "js",
        "application/javascript" => "js",
        "application/x-javascript" => "js",
        // json
        "application/json" => "json",
        "application/jsonrequest" => "json",
        "text/x-json" => "json",
        // css
        "text/css" => "css",
        // html
        "text/html" => "html",
        "text/xhtml" => "html",
        "text/*" => "html",
        "application/xhtml+xml" => "html",
        "application/xhtml" => "html",
        "application/*" => "html",
        "*/*" => "html",
        // csv
        "application/vnd.ms-excel" => "csv",
        "text/csv" => "csv",
        // xml
        "application/xml" => "xml",
        "application/x-xml" => "xml",
        "text/xml" => "xml",
        "text/xml" => "xml",
        // wap
        "text/vnd.wap.wml" => "wap",
        "text/vnd.wap.wmlscript" => "wap",
        "image/vnd.wap.wbmp" => "wap",
        // yaml
        "application/x-yaml" => "yaml",
        "text/yaml" => "yaml",
        // atom
        "application/atom+xml" => "atom",
        // amf
        "application/x-amf" => "amf",
        // html-mobile
        "application/vnd.wap.xhtml+xml" => "html-mobile",
        // text
        "text/plain" => "text",
        // url-form
        "application/x-www-form-urlencoded" => "url-form",
        // form
        "application/x-www-form-urlencoded" => "form",
        // file
        "multipart/form-data" => "file",
        // rss
        "application/rss+xml" => "rss",
        // wml
        "text/vnd.wap.wml" => "wml",
        // wmlscript
        "text/vnd.wap.wmlscript" => "wmlscript",
        // wbmp
        "image/vnd.wap.wbmp" => "wbmp",
        // pdf
        "application/pdf" => "pdf",
        // zip
        "application/x-zip" => "zip",
        // tar
        "application/x-tar" => "tar",
        // rar
        "application/x-rar" => "rar",
        // pictures
        "image/png" => "png",
        "image/jpg" => "jpg",
        "image/jpeg" => "jpg",
        "image/gif" => "gif",
        "image/tif" => "tif",
        "image/bmp" => "bmp"
    );    
    
    /**
     * Constructor
     * 
     * Sets all flags and accept format
     */
    public function __construct() {     
        $this->setURI()
             ->setAcceptedFormats()
             ->setAcceptFormat()
             ->setChecks()
             ->setAjax();                                  
    }
    
    /**
     * Get best accept format
     * 
     * @return string
     */
    public function getAcceptFormat() {
        return $this->acceptFormat;
    }

    /**
     * Is request an ajax request
     * 
     * @return bool
     */
    public function isAjax() {
        return $this->isAjax;
    } 

    /**
     * Is request a json request
     * 
     * @return bool
     */    
    public function isJson() {
        return $this->isJson;
    } 

    /**
     * Is request an SG ajax request
     * 
     * @return bool
     */        
    public function isSGAjax() {
        return $this->isSGAjax;
    }     
    
    /**
     * Get the JSONResponse object
     * 
     * @return JSONResponse|false
     */        
    public function getJSONResponse() {
        return $this->jsonResponse;
    }
    
    /** 
     * Set a JSON response array
     *
     * @param array|string $response
     * @return HTTPRequest
     */
    public function setJSONResponse($response) {
        if(!$this->jsonResponse) {
            return;
        }
        
        $this->jsonResponse->setResponse($response);
        return $this;
    }

    /**
     * @todo document
     */
    protected function setURI() {
        $this->uri = $_SERVER["REQUEST_URI"];
        return $this;
    }

    /**
     * @todo document
     */    
    protected function setAcceptedFormats() {
        if(empty($_SERVER["HTTP_ACCEPT"])) {
            return $this;
        }
        
        $formats = explode(",", strtolower($_SERVER["HTTP_ACCEPT"]));
        foreach ($formats as $key => $format) {
            $format  = trim($format);
            $quality = 1;
            
            if(strpos($format, "; q=") != false) {
                list($format, $quality) = explode("; q=", $format);
            }
            
            $this->acceptedFormats[$format] = floatval($quality);
        }        
                
        return $this;
    }

    /**
     * @todo document
     */    
    protected function setAcceptFormat() {
        if(empty($this->acceptedFormats)) {
            return $this;
        }
        
        $bestQuality = 0;
        $bestStars   = floatval("0.0");        
        $bestFormat  = "html";
        foreach($this->acceptedFormats as $format => $quality) {
            $stars = substr_count($format, "*");
            
            if(
                ($quality > $bestQuality)
                || (
                    $quality == $bestQuality
                    && $stars < $bestStars
                ) 
            ) {
                    $bestFormat  = $format;
                    $bestQuality = $quality;
                    $bestStars   = $stars;
            } 
        }        
                        
        $this->acceptFormat =
            isset($this->requestTypes[$bestFormat])
            ? $this->requestTypes[$bestFormat]
            : $format;

        return $this;
    }
    
    /**
     * @todo document
     */    
    protected function setChecks() {
        $this->isAjax   = (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && (strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == "xmlhttprequest"));
        $this->isJson   = ($this->acceptFormat == "json");

        $uri      = strtolower($this->uri);
        $spformat = (stripos($uri, "spformat") !== false);
        
        if(!$spformat && isset($_POST) && !empty($_POST)) {
            $spformat = in_array("spformat", array_map("strtolower", array_keys($_POST)));
        }        
        
        // $this->isAjax fails when cross domain ajax request
        // so we have to rely only on the spformat and the $this->isJson
        $this->isSGAjax =
            $this->isJson()
            && $spformat;
        /*
        $this->isSGAjax =
            $this->isAjax()
            && $this->isJson()
            && $spformat;
        */
        return $this;            
    }    
    
    /**
     * @todo document
     */    
    protected function setAjax() {
        $this->jsonResponse = 
            $this->isSGAjax
                ? new JSONResponse()
                : false;
        
        return $this;
    }
    
}