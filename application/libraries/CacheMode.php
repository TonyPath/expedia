<?php
/**
  * Caching functionality
  *
  * Enables the initialization of different caching types
  *
  * @category
  * @package
  * @subpackage
  * @copyright  Copyright (c)  2013 Spitogatos SA. ([http://www.Spitogatos.gr])
  * @since
  * @deprecated
  * @author foufos
  */
class CacheMode {

    public static $cacheTypes = array("file", "apc", "memcached");

    /**
     * Zend_Cache::factory abstraction
     *
     * @throws Exception
     * @param int $lifetime
     * @return Zend_Cache
     */
    public static function getCache($lifetime = 3600) {
        $ci        = get_instance();
        $ci->load->library("Zend");
        $ci->zend->load("Zend/Cache");
        
        $cacheType = self::getCacheType($ci->config->item("cache_cacheType"));
        $automaticSerialization = $ci->config->item("cache_automaticSerialization");
        
        $lifetime = is_int($lifetime) || ctype_digit($lifetime) ? (int) $lifetime : false;

        if(!$lifetime) {
            list($callee) = debug_backtrace();
            throw new Exception("Lifetime should be an integer. Called from {$callee['file']} @ line: {$callee['line']}");
        }
                
        if(!is_bool($automaticSerialization)) {
        	throw new Exception("Automatic serialization should be a boolean.");
        }
        
        $frontendOptions = array(
            "lifetime"                    => (int) $lifetime,
            "automatic_serialization"     => (bool) $automaticSerialization,
            "cache_id_prefix"             => "v5_",
            "automatic_cleaning_factor"   => 0
        );

        if(
            $cacheType == "memcached"
        ) {
            $backendOptions =  $ci->config->item("memcache");
            return Zend_Cache::factory("Core", ucfirst(strtolower($cacheType)), $frontendOptions, $backendOptions);
        }

        if(
            $cacheType == "apc"
        ) {
            return Zend_Cache::factory("Core", ucfirst(strtolower($cacheType)), $frontendOptions);
        }

        $backendOptions =  $ci->config->item("filecache");
        return Zend_Cache::factory("Core", "File", $frontendOptions, $backendOptions);
    }

    /**
     * Get valid cache type from user cache type
     *
     * Will also rollback to simpler cache types if cache engine not available
     *
     * @param strign $cachetype
     */
    public static function getCacheType($cachetype) {
        if(!is_string($cachetype)) {
            return "file";
        }
        
        $cachetype = strtolower($cachetype);
        
        if($cachetype == "file") {
            return $cachetype;
        } 

        if(
            $cachetype == "memcached"
            && !extension_loaded("memcache")
        ) {
            $cachetype = "file";
        }

        if(
            $cachetype == "apc"
            && !extension_loaded("apc")
        ) {
            $cachetype = "file";
        }

        return
            in_array($cachetype, self::$cacheTypes)
                ? $cachetype
                : "file";
    }
    
    /**
     * Get normalized cache name
     * 
     * You should never use this directly, use your controllers getCacheName() 
     * function instead, which add dynamic stuff to your cache name
     * 
     * This:
     * 1) replaces scores (-), spaces, tabs with underscores (for all types of caching)
     * 2) replaces greek letters (from listingDetails url) with english letters (for memcache)
     * 3) makes sure string length of cache name < 255 (for memcache) 
     * 
     * @param unknown_type $name
     * @throws Exception
     */
    public static function getCacheName($name) {
        $name = (!is_object($name) && !is_array($name)) ? (string) $name : false;
        
        if(!$name) {
            throw new Exception("Cache name is wrong.");
        }
        
        $name = trim($name);
        $name = str_replace(array(" ", "\t", "-"), "_", $name);
        
        $letters =
        array(
            "a" => array("α", "Α"),
            "at" => array("ά", "Ά"),
        	"b" => array("β", "Β"),
        	"c" => array("γ", "Γ"),
        	"d" => array("δ", "Δ"),
        	"e" => array("ε", "Ε"),
        	"et" => array("έ", "Ε"),
            "z" => array("ζ", "Ζ"),
            "i" => array("ι", "Ι"),
            "it" => array("ί", "Ί"),
            "h" => array("η", "Η"),
        	"ht" => array("ή", "Η"),
        	"y" => array("υ", "Υ"),
        	"yt" => array("ύ", "Ύ"),
        	"th" => array("θ", "Θ"),
            "k" => array("κ", "Κ"),
            "l" => array("λ", "Λ"),
        	"m" => array("μ", "Μ"),
            "n" => array("ν", "Ν"),
            "x" => array("ξ", "Ξ"),
        	"o" => array("ο", "Ο"),
            "ot" => array("ό", "Ό"),
        	"w" => array("ω", "Ω"),
            "wt" => array("ώ", "Ώ"),       
            "p" => array("π", "Π"),
            "r" => array("ρ", "Ρ"),
        	"s" => array("σ", "Σ", "ς"),
            "t" => array("τ", "Τ"),
            "f" => array("φ", "Φ"),
        	"h" => array("χ", "Χ"),
            "ps" => array("ψ", "Ψ")
        );
                        
        $temp = $name;
        foreach($letters as $english => $greek) {
           $name = str_replace($greek, $english, $name);
        }
        
        if($name != $temp) {
            $name .= "_el";
        }
                
        $name = preg_replace("/[^A-Za-z0-9_]/", "0", $name);
        
        $length = strlen($name);
        if($length > 255) {
            $chunk1 = substr($name, 0, 210); // first 200 chars
            $chunk2 = substr($name, 211, $length); // chars from 201 -> length to be sha1'ed
        
            $name   = $chunk1 . "_" . sha1($chunk2, false);
        }       
        
        return $name;
    }
}
