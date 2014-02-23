<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// ------------------------------------------------------------------------

/**
 * Browser helper
 *
 * @package     Custom Spitogatos Codeigniter code
 * @subpackage  Helpers
 * @category    Helpers
 * @author      foufos
 * @copyright   2013 Spitogatos.gr
 * @version     1a
 * @link        system/application/helpers/browser_helper
 */

// ------------------------------------------------------------------------

if(!function_exists("detectIE6")) {
    /**
     * Detects IE6 from user agent string
     *
     * List of User Agent Strings: http://www.useragentstring.com/pages/useragentstring.php
     *
     * @access public
     * @return bool
     */
    function detectIE6() {
        // User Agent to lower to ease comparisons
        $userAgent = isset($_SERVER["HTTP_USER_AGENT"]) ? strtolower($_SERVER["HTTP_USER_AGENT"]) : "";

        // Second strpos because in some cases opera user agent includes msie 6. string
        return
            strpos($userAgent, "msie 6.") !== false
            && strpos($userAgent, "opera") === false
            // weird bug that sometimes ie8 send also the ie6 user agent string back
            &&  strpos($userAgent, "msie 8.") === false
            &&  strpos($userAgent, "msie 7.") === false;

    }
}

if(!function_exists("detectIE7")) {
    /**
     * Detects IE7 from user agent string
     *
     * List of User Agent Strings: http://www.useragentstring.com/pages/useragentstring.php
     *
     * @access public
     * @return bool
     */
    function detectIE7() {
        // User Agent to lower to ease comparisons
        $userAgent = isset($_SERVER["HTTP_USER_AGENT"]) ? strtolower($_SERVER["HTTP_USER_AGENT"]) : "";

        // Second strpos because in some cases opera user agent includes msie 6. string
        return
            strpos($userAgent, "msie 7.") !== false
            && strpos($userAgent, "opera") === false;

    }
}

if(!function_exists("detectIE8")) {
    /**
     * Detects IE8 from user agent string
     *
     * List of User Agent Strings: http://www.useragentstring.com/pages/useragentstring.php
     *
     * @access public
     * @return bool
     */
    function detectIE8() {
        // User Agent to lower to ease comparisons
        $userAgent = isset($_SERVER["HTTP_USER_AGENT"]) ? strtolower($_SERVER["HTTP_USER_AGENT"]) : "";

        // Second strpos because in some cases opera user agent includes msie 6. string
        return
            strpos($userAgent, "msie 8.") !== false
            && strpos($userAgent, "opera") === false;

    }
}

if(!function_exists("detectIE9")) {
    /**
     * Detects IE9 from user agent string
     *
     * List of User Agent Strings: http://www.useragentstring.com/pages/useragentstring.php
     *
     * @access public
     * @return bool
     */
    function detectIE9() {
        // User Agent to lower to ease comparisons
        $userAgent = isset($_SERVER["HTTP_USER_AGENT"]) ? strtolower($_SERVER["HTTP_USER_AGENT"]) : "";

        // Second strpos because in some cases opera user agent includes msie 6. string
        return
            strpos($userAgent, "msie 9.") !== false
            && strpos($userAgent, "opera") === false;

    }
}

if(!function_exists("detectIE")) {
    /**
     * Detects MSIE from user agent string
     *
     * List of User Agent Strings: http://www.useragentstring.com/pages/useragentstring.php
     *
     * @access public
     * @return bool
     */
    function detectIE() {
        // User Agent to lower to ease comparisons
        $userAgent = isset($_SERVER["HTTP_USER_AGENT"]) ? strtolower($_SERVER["HTTP_USER_AGENT"]) : "";

        // Second strpos because in some cases opera user agent includes msie 6. string
        return
            (
                stripos($userAgent, "msie") !== false
                || stripos($userAgent, "trident") !== false
            ) && stripos($userAgent, "opera") === false;

    }
}