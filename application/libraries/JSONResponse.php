<?php
if (!defined('PHP_VERSION_ID')) {
    $version = explode('.', PHP_VERSION);

    define('PHP_VERSION_ID', ($version[0] * 10000 + $version[1] * 100 + $version[2]));
}

/**
 * Handles SG JSON format responses
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
 * @package AJAX
 * @package JSON
 * @version svn:$Id$
 */  
class JSONResponse {
    
    /**
     * JSON Response fields
     * 
     * @var array
     */
    protected $fields = 
        array(
            "title"    => null,
            "status"   => 0,
            "responseStatus"   => 0,
            "data"	   => null,
            "messages" => null,
            "redirect" => null,
            "output"   => null        
        );

    /**
     * Debug mode
     * @var bool
     */
    protected $debugMode = false;
     
    /**
     * Set the response
     * 
     * If response is array, SG JSON format is assumed
     * If response is string, output field is used
     * 
     * @param array|string $response
     * @param bool $debugMode This should be mapped to config debug
     * 
     * @return JSONResponse
     */
    public function setResponse($response, $debugMode = false) {
        $this->setDebugMode($debugMode);
         
        if(is_array($response)) {
            foreach($response as $key => $value) {
                $this->$key = $value;
            }                        
        } else {        
            $this->status = 1;
            $this->output = $response;
        }
        
        return $this;        
    }
    
    /**
     * Magic get
     * 
     * @param string $key
     * @return mixed
     */
    public function __isset($key) {
        return isset($this->fields[$key]);
    }    
    
    /**
     * Magic set
     * 
     * @param string $key
     * @param mixed $value
     */
    public function __set($key, $value) {
        if(array_key_exists($key, $this->fields)) {
            if($key == "responseStatus") {
                $this->status = $value;
            }            

            if($key == "status") {
                $this->responseStatus = $value;
            }                        
            
            if($key == "redirect") {
                $this->status = 2;
            }
            
            if(
                $key == "messages"
                && !is_array($value)
            ) {
                $value = array($value);
            }
            
            $this->fields[$key] = $value;
        } 
    }

    /**
     * Magic get 
     * 
     * @param string $key
     * @return mixed|null
     */
    public function __get($key) {
        if (array_key_exists($key, $this->fields)) {
            return $this->fields[$key];
        }

        return null;
    }
    
    /**
     * Get the json encoded output
     * 
     * @return string
     */
    public function getOutput() {
        if(is_null($this->output)) {
            $this->output = $this->jsonEncode($this->fields);
        }
                        
        return $this->output;
    }
    
    /**
     * jsonEncode and handle json exceptions
     * 
     * @param mixed $data
     */
    protected function jsonEncode($data) {        
        try {
            $data = 
                (PHP_VERSION_ID < 50300) 
                    ? json_encode($data)
                    : json_encode($data, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);                                            
        } catch(Exception $e) {            
            $data = array(
                "responseStatus" => 0,
                "status" 		 => 0,
                "messages"		 => ($this->debugMode) ? $e->getMessage() : ""
            );
            
            return json_encode($data);
        }
                    
        return $data;        
    }
    
    /**
     * Set debug mode
     * 
     * This is used by jsonEncode in case of a json exception
     * 
     * @param bool $debug
     */
    public function setDebugMode($debug) {
        $this->debugMode = ($debug === true);
        
        return $this;
    }
    
    /**
     * Get debug mode
     */
    public function getDebugMode() {
        return $this->debugMode;
    }
    
    /**
     * getOutput() alias
     * 
     * Debugging magic function, please use getOutput() in real code
     * @return string
     */
    public function __toString() {
        return $this->getOutput();
    }
    
}