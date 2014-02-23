<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH . "libraries/HTTPRequest.php";

/**
 * Base Controller
 *
 * Notice:
 *
 * This is a core library, which means that many things depend upon.
 * 1) Please notify original authors for any changes (via email, blog post or wiki article)
 * 1a) Just notify, if you really need changes do them, don't wait for feedback
 * 2) Please cleary document any new additions
 * 3) If you change current functionality please discuss with team before commiting and document in the wiki afterwards
 *
 * @author foufos <jerry.manolarakis@spitogatos.gr>
 * @copyright Copyright © 2013, Spitogatos.gr
 * @package Base Controller
 * @version svn:$Id$
 */
class MY_Controller extends CI_Controller {

	/**
	 * Show searchbar
	 * 
	 * @var object
	 */
	public $show_searchbar = true;
	
    /**
     * Controller name
     * @var string
     */
    protected $name         = "";

    /**
     * The view positions
     * $position => $view
     * @var array
     */
    protected $positions =
        array(
            "layout"  => "layout",
            "main"    => false,
            "header"  => "layout_header",
        	"searchbar"  => "layout_searchbar",
            "footer"  => "layout_footer",
        );

    /**
     * The data
     * @var array
     */
    protected $data         = array();
    protected $dataView     = array();

    /**
     * the global data
     *
     * @see initGlobals();
     */
    protected $globals      = array();

    /**
     * The language
     * @var string
     *
     * This became public because some models
     * try to get it using ci->language
     * which by the way is not the prefered way
     * of doing things.
     */
    public $language       = "en";

    /**
     * Flags
     */
    protected $flagLoggedIn  = false;
    protected $flagAjax      = false;
    protected $flagDebug     = false;
    protected $flagCache     = true;

    /**
     * Cache date for styles & scripts
     * @var string
     */
    protected $cacheDate     = "19790629";

    /**
     * FirePHP object
     * @var object
     */
    protected $firePHP      = false;

    /**
     * Minify groups
     *
     * @var array
     */
    protected $minifyGroupsScripts    = array();
    protected $minifyGroupsStyles     = array();

    /**
     * Minify directory
     * This is inside public html
     *
     * @var string
     */
    protected $minifyUrl              = "min/";

    /**
     * URI segments array
     *
     * @var array
     */
    protected $segments               = array();

    /**
    * the request instance
    *
    * @var Request
    */
    protected $HTTPRequest = null;

    /**
     * Log messages
     *
     * @var array
     */
    protected $messages = array();

    /**
     * Openx Zones
     *
     * @var array
     */
    protected $aOpenXZones = array();

    protected $footerScripts = "";

    protected $prevnext = array("prev" => "", "next" => "");

    protected $seoContent = false;

    /*
     * Constructor
     *
     * Implements controller constructor logic:
     * - initialize()
     */
    public function __construct() {
        // get tbe output
        ob_start();

        parent::__construct();

        $this->benchmark->mark("benchmarkControllerStart");

        $this->HTTPRequest = new HTTPRequest();

        $this->name      = strtolower(get_class($this));
        $this->flagDebug = $this->config->item("debug") === true;
        $this->flagCache = !($this->config->item("cache") === false);
        $this->cacheDate = ($this->flagCache) ? $this->config->item("cacheDate") : time();
        $this->minifyUrl = $this->config->item("minifyUrl");
        $this->language =
            isset($this->uri)
            && $this->uri->segment(1) == "gr"
                ? "gr"
                : "en";

        $this->voodoo();
    }

    /**
     * Set the json response
     *
     *
     *
     * @param unknown_type $response
     */
    public function setJSONResponse($response) {
        $this->HTTPRequest->setJSONResponse($response);
    }

    public function getJSONResponse() {
        return $this->HTTPRequest->getJSONResponse();
    }

    public function isSGAjax() {
        if (!empty($this->HTTPRequest))
            return $this->HTTPRequest->isSGAjax();
    }

    /**
    * capture the output and return it correctly if ajax output
    */
    public function __destruct() {
        $output = ob_get_contents();
        ob_end_clean();
        $output = trim($output); // to output xml docs

        /**
        // check if it is an ajax/json request
        if ($this->isSGAjax()) {
            $Request = new HTTPRequest();

            $Response = $Request->getJSONResponse();
            $Response->output = $output;
            $Response->title = "New Title";
            //$Response->setResponse()

            echo $Response->getOutput();
            return;
        }
         * **/
//        if(
//            $response = $this->HTTPRequestObject
//        ) {
//            $response->output = $output;
//            echo $response;
//        } else {
//            echo $output;
//        }

        echo $output;
        return;
    }

    /**
     * Remap an action function
     *
     * 1) Capture return value
     * 2) Decide on function scope
     * 3) Decide on ajax
     * 4) Output
     *
     * @param string $method
     */
    public function _remap($method) {
        if(!method_exists($this, $method)) {
            show_404(__CLASS__ . "::" . __FUNCTION__ ." - Method {$method} does not exist");
            return false;
        }


        // we dont allow access to the frontend and base controller public functions by url!
        $reflection = new ReflectionMethod($this, $method);
        $class      = $reflection->getDeclaringClass();
        $class      = $class->name;

        if(
            in_array($class, array("Controller_Base", "Controller_FrontEnd"))
            && $reflection->isPublic()
        ) {
            show_404(__CLASS__ . "::" . __FUNCTION__ ." - Trying to access private method {$method}");
            return false;
        }

        $this->benchmark->mark("benchmarkMethodStart");

        if(
            $response = $this->HTTPRequest->getJSONResponse()
        ) {
            header("Cache-Control: no-cache, must-revalidate");
            header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
            header("Content-type: application/json");
            echo $response->setResponse($this->$method(), $this->config->item("debug"));
        } else {
            $this->$method();
        }

        $this->benchmark->mark("benchmarkMethodEnd");

        return;
    }

    /**
     * Voodoo init
     */
    protected function voodoo() {
        $methods = get_class_methods($this);

        if(empty($methods)) {
            return true;
        }

        $callsInit = array();
        $callsLoad = array();

        foreach($methods as $method) {
            if(strpos($method, "_init") === 0) {
                $callsInit[] = $method;
            } else if(strpos($method, "_load") === 0) {
                $callsLoad[] = $method;
            }
        }
        $calls = array_merge($callsInit, $callsLoad);

        foreach($calls as $call) {
            $this->$call();
        }

        $this->log("Voodoo calls: " . implode($calls, ", "));
        
    }

    /**
     * Loads system wide helpers
     */
    protected function _initHelpers() {
        $this->load->helper("browser");
    }

    /**
     * Loads system wide libraries
     */
    protected function _initLibraries() {
        $this->load->library("CacheMode.php");
    }

    /**
     * Creates dataView arrays for each position
     */
    protected function _initDataViews() {
        $positions = array_keys($this->positions);
        foreach($positions as $position) {
            if(!$this->hasDataView($position)) {
                $this->dataView[$position] = array();
            }
        }
    }

     /**
      * Set global values
      * @todo legacy base
      */
     protected function _initGlobals() {
        $this->globals["baseUrl"]       = base_url();
        $this->globals["cdnRoot"]       = base_url();
        $this->globals["baseUrlLang"]   = $this->globals["baseUrl"] . $this->language . "/";
        $this->globals["lang"]          = $this->language;
        $this->globals["language"]      = $this->language;
        $this->globals["langHtml"]      = ($this->language == "en") ? "en" : "el";
     }

     /**
      * Initializes Firebug
      */
     protected function _initFirebug() {
        if($this->flagDebug) {
            $this->load->library("FirePHP/FirePHP");
            $this->firePHP = FirePHP::getInstance(true);
        }
     }

     /**
      * Gets uri segments into segments array
      */
     protected function _loadSegments() {
         $segments = $this->uri->segment_array();

         if(!is_array($segments)) {
             $this->segments = array();
             return;
         }

         foreach($segments as $key => $seg) {
             $seg = strtolower($seg);
         }

          $this->segments = $segments;
     }

    /**
     * Load a language file
     *
     * @param string $file
     */
    public function loadLangFile($file) {
        $this->lang->load($file, $this->language);
    }

    /**
     * Load Layout minify scripts and groups
     */
     protected function _loadLayoutMinify() {
        $this->addMinifyStylesGroup('layout_styles');
        $this->addMinifyScriptsGroup('layout_scripts');
     }

    /**
     * Get array of public data (lang items + globals)
     *
     * @return array
     */
    public function getPublicData() {
        return
            array_merge($this->lang->language, $this->globals);
    }

    /**
     * Check if user is logged in
     *
     * @todo replace with concise authentication class
     * @return bool
     */
    public function checkLogin() {
        return
            $this->flagLoggedIn =
                function_exists("checkLogin")
                ? checkLogin()
                : false;
    }

    public function getLoginStatus() {
        return $this->flagLoggedIn;
    }

    /**
     * Gets language
     * @return string
     */
    public function getLanguage() {
        return $this->language;
    }

    public function setPrevLink($link) {
        $link = trim(str_replace("\\", "/", $link), "/");
        $this->prevnext["perv"] = "<link rel=\"prev\" href=\"{$link}\" />";
    }

    public function setNextLink($link) {
        $link = trim(str_replace("\\", "/", $link), "/");
        $this->prevnext["next"] = "<link rel=\"next\" href=\"{$link}\" />";
    }

    public function getPrevNextLinks() {
        $result = "";
        if(!empty($this->prevnext)) {
            foreach($this->prevnext as $link) {
                $result .= $link . "\n";
            }
        }
        return trim($result);
    }
    
    /**
     * Return true if page is accessed through https
     */
    public function isHttps() {
        return isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] === "on";
    }

    /**
     * Set a view and a dataView array (if not exists)
     *
     * @param string $view
     * @param string $position Layout position name
     */
    protected function setView($view, $position = "main") {
        $this->positions[$position] = $view;
        $this->setDataView($position, array());
    }

    /**
     * Does the view have view specific data?
     *
     * @param $position Layout position name
     */
    protected function hasDataView($position) {
        return
            isset($this->dataView[$position])
            && is_array($this->dataView[$position]);
    }

     /**
      * @todo document
      */
    protected function getDataView($position, $data = array()) {
        if(!$this->hasDataView($position)) {
            $this->dataView[$position] = $this->data;
        }

        return $this->dataView[$position];
    }

     /**
      * @todo document
      */
    protected function setDataView($position, $data = array()) {
        if(!$this->hasDataView($position)) {
            $this->dataView[$position] = array();
        }

        $this->dataView[$position] = array_merge($this->dataView[$position], $data);
    }

    /**
     * Set layout
     *
     * @param string $layout
     */
    protected function setLayout($layout) {
        $this->positions["layout"] = $layout;
        $this->log("setLayout({$layout})", "info");
    }

    /**
     * Add minify scripts group
     *
     * @param string $group
     */
    public function addMinifyScriptsGroup($group) {
        if(
            strpos(strtolower($group), "layout") !== false
        ) {
            $this->minifyGroupsScripts["layout"][] = $group;
        } else {
            $this->minifyGroupsScripts["page"][] = $group;
        }
    }

    /**
     * Add minify styles group
     *
     * @param string $group
     * @param string $media CSS media
     */
    public function addMinifyStylesGroup($group, $media = "screen") {
        if (!isset($this->minifyGroupsStyles[$media]))
            $this->minifyGroupsStyles[$media] = array();

        $this->minifyGroupsStyles[$media][] = $group;
    }

     /**
      * @todo document
      * @todo add cache date
      */
    public function getMinifyGroupsStyles($position = false) {

        $url   = $this->isHttps() ? $this->globals["secureCdnRoot"] . $this->minifyUrl : $this->globals["cdnRoot"] . $this->minifyUrl;
        
        $html  = "";
        $debug = $this->flagDebug ? "&amp;debug=1" : "";
        $aGroups = array();

        if (!empty($this->minifyGroupsStyles))
            foreach ($this->minifyGroupsStyles as $media => $aGroups) {

                $groups = "";

                if (!empty($aGroups))
                {
                    $aGroups = array_unique($aGroups);

                    foreach ($aGroups as $group) {
                        if(
                            !empty($position)
                            && false === stripos($group, $position)
                        ) {
                            continue;
                        }

                        if (stripos($group, "layout_") !== false)
                            $html .= "\t<link rel=\"stylesheet\" href=\"{$url}g={$group}{$debug}&amp;{$this->cacheDate}\" type=\"text/css\" media=\"{$media}\" />\n";
                        else
                            $groups .= "," . $group;
                    }
                }

                if (!empty($groups)) {
                    $groups = trim($groups, ", ");
                    $html .= "\t<link rel=\"stylesheet\" href=\"{$url}g={$groups}{$debug}&amp;{$this->cacheDate}\" type=\"text/css\" media=\"{$media}\" />\n";
                }

            }

        return "<!-- minify styles -->\n{$html}\t<!-- minify styles end -->";
    }

     /**
      * @todo document
      * @todo add cache date
      */
    public function getMinifyGroupsScripts($position = false) {
    	
    	$url    = $this->isHttps() ? $this->globals["secureCdnRoot"] . $this->minifyUrl : $this->globals["cdnRoot"] . $this->minifyUrl;
    	
        $html   = "";
        $debug  = $this->flagDebug ? "&amp;debug=1" : "";
        $aGroups = array();

        if(isset($this->minifyGroupsScripts["layout"])) {
            $aGroups = $this->minifyGroupsScripts["layout"];
        }

        if(isset($this->minifyGroupsScripts["page"])) {
            $aGroups = array_merge($aGroups, $this->minifyGroupsScripts["page"]);
        }

        $groups = "";
        if (!empty($aGroups)) {
            $aGroups = array_unique($aGroups);

            foreach ($aGroups as $group) {

                if(
                    !empty($position)
                    && false === stripos($group, $position)
                ) {
                    continue;
                }
                if (stripos($group, "layout_") !== false)
                    $html .= "\t<script type=\"text/javascript\" src=\"{$url}g={$group}{$debug}&amp;{$this->cacheDate}\"></script>\n";
                else
                    $groups .= "," . $group;
            }
        }

        if (!empty($groups)) {
            $groups = trim($groups, ", ");
            $html .= "\t<script type=\"text/javascript\" src=\"{$url}g={$groups}{$debug}&amp;{$this->cacheDate}\"></script>\n";
        }

        return "<!-- minify scripts -->\n{$html}\t<!-- minify scripts end -->";
    }

    protected function setFooterScript($script) {
        if(!is_string($script) || empty($script)) {
            return false;
        }

        $this->footerScripts .= trim($script) . "\n";
        return true;
    }

    protected function getFooterScripts() {
        return $this->footerScripts;
    }

    /**
     * FirePHP log
     *
     * @param string $message
     * @param string $severity
     */
    public function log($message, $severity = "log") {
        $message = get_class($this) . " // {$message}";
        $this->messages[] = array($message, $severity);
        return $this;
    }

    protected function showFirePHPMessages() {
        if(!$this->flagDebug || empty($this->firePHP) || detectIE() || empty($this->messages)) {
            return false;
        }

        foreach($this->messages as $value) {
            list($message, $severity) = $value;
                switch($severity) {
                    case "info":
                        $this->firephp->info($message);
                        break;
                    case "warn":
                        $this->firephp->warn($message);
                        break;
                    case "error":
                        $this->firephp->error($message);
                        break;
                    default:
                        $this->firephp->log($message);
                        break;
                }
        }
    }

    /**
     * This loads lang items from internal lang array to
     * view variables
     *
     * @param string $position
     */
    protected function setLanguageItems($position) {
        $languageItems = $this->lang->language;
        if(empty($languageItems)) {
            return;
        }
        $this->dataView[$position] = $this->dataView[$position] + $languageItems;
//        foreach($languageItems as $key => $value) {
//            if(!isset($this->dataView[$position][$key])) {
//                $this->dataView[$position][$key] = $value;
//            }
//        }
    }

    protected function getLanguageItems() {
        return $this->lang->language;
    }

    /**
    * parse the openx zones
    *
    * @param mixed $template
    *
    * @return boolean
    */
    protected function parseOpenXZones($template = "") {
        if(empty($template)) {
            return false;
        }

        preg_match_all("/\{openx__(.*)\}/", $template, $aOpenXZones, PREG_PATTERN_ORDER);

        if (!empty($aOpenXZones[0]))
            foreach ($aOpenXZones[0] as $key => $value) {
                $zone = $aOpenXZones[1][$key];

                $lazy = true;

                // check if we should load this zone normal
                if (stripos($zone, "__nonlazy") !== false) {
                    $lazy = false;
                    $zone = str_ireplace("__nonlazy", "", $zone);
                }

                $trimmedValue = trim($value, "{}");
                //$this->aOpenXZones[$trimmedValue] = $zone;
                $this->dataView["layout"][$trimmedValue] = createLazyLoadOpenX($zone, $lazy);
            }

        return true;
    }

    /**
     * get the openx zones from the session var
     */
    protected function getOpenXZones() {
        if (!empty($_SESSION["openx_zones"])) { //}this->aOpenXZones)) {
            $nameZoneJS = "
                <script type=\"text/javascript\">
                   var OA_zones = {";

            foreach ($_SESSION["openx_zones"] as $nameZone => $zone)
                $nameZoneJS .= "\"" . $nameZone . "\" : " . $zone . ",";

            unset($_SESSION["openx_zones"]);

            $nameZoneJS = rtrim($nameZoneJS, ",");
            $nameZoneJS .= "} </script>\n";

            $this->dataView["layout"]["layout_namedZonesArray"] = $nameZoneJS;
        }
    }

    /**
     * Parse layout
     *
     * @param bool $return Return or ech output
     * @return string
     */
    protected function parse($return = false) {
        $this->benchmark->mark("benchmarkParserStart");

        if(
            empty($this->positions["layout"])
        ) {
            return false;
        }

        foreach($this->positions as $position => $view) {
            if(
                empty($view)
            ) {
                continue;
            }

            $this->setLanguageItems($position);
            $this->setDataView($position, $this->globals);

            $this->dataView["layout"]["position_{$position}"] = $this->parser->parse($view, $this->getDataView($position), true);

            $this->parseOpenXZones($this->dataView["layout"]["position_{$position}"]);
        }

        $this->dataView["layout"]["layout_prevnext"]      = $this->getPrevNextLinks();
        
        $this->dataView["layout"]["layout_minifyStyles"]  = $this->getMinifyGroupsStyles();
        $this->dataView["layout"]["layout_minifyScripts"] = $this->getMinifyGroupsScripts();
        $this->dataView["layout"]["layout_footerScripts"] = $this->getFooterScripts();
        $this->dataView["layout"]["googleAnalyticsCode"] = $this->config->item("googleAnalyticsCode");

        $this->setDataView("layout", $this->globals);

        $this->getOpenXZones();

        // parse the actual output
        $output = $this->parser->parse($this->positions["layout"], $this->dataView["layout"], true);
//        if($this->flagDebug === false) {
//            $output = str_replace(array("\t", "\r\n", "\n"), " ", $output);
//            $output = preg_replace("/\s\s+/", " ", $output);
//        }

        $this->benchmark->mark("benchmarkParserEnd");

        $this->log(
            "parser benchmark: " . $this->benchmark->elapsed_time("benchmarkParserStart", "benchmarkParserEnd")
        );

        $this->log(
            "method benchmark: " . $this->benchmark->elapsed_time("benchmarkMethodStart", "benchmarkMethodEnd")
        );

        $this->log(
            "controller benchmark: " . $this->benchmark->elapsed_time("benchmarkControllerStart", "benchmarkParserEnd")
        );

        if(!$return) {
            $this->showFirePHPMessages();
            echo $output;
        }

        return $output;
    }
    
    /**
     * loadJsPlugin
     *
     * @param string $name load specific plugin
     * @return string
     */
    protected function loadJsPlugin($name = null) {
        if(empty($name)){
            return;
        }
        $this->addMinifyStylesGroup($name . '_styles');
        $this->addMinifyScriptsGroup($name . '_scripts');
    }
    
    /**
     * Load layout
     *
     * @param bool $return Return or ech output
     * @return string
     */
    protected function loadLayout($return = false) {
    	
        $this->benchmark->mark("benchmarkParserStart");
    
        if(
            empty($this->positions["layout"])
        ) {
            return false;
        }
    
        foreach($this->positions as $position => $view) {
            if(
                empty($view)
            ) {
                continue;
            }
    
            $this->setLanguageItems($position);
            $this->setDataView($position, $this->globals);
    
            $this->dataView["layout"]["position_{$position}"] = $this->load->view($view, $this->getDataView($position), true);
    
            $this->parseOpenXZones($this->dataView["layout"]["position_{$position}"]);
        }
    
        $this->dataView["layout"]["layout_prevnext"]      = $this->getPrevNextLinks();
    	
        $this->dataView["layout"]["show_searchbar"]  = $this->show_searchbar;
        
        $this->dataView["layout"]["layout_minifyStyles"]  = $this->getMinifyGroupsStyles();
        $this->dataView["layout"]["layout_minifyScripts"] = $this->getMinifyGroupsScripts();
        $this->dataView["layout"]["layout_footerScripts"] = $this->getFooterScripts();
        $this->dataView["layout"]["googleAnalyticsCode"] = $this->config->item("googleAnalyticsCode");
        
    
        $this->setDataView("layout", $this->globals);
    
        $this->getOpenXZones();
    
        // parse the actual output
        $output = $this->load->view($this->positions["layout"], $this->dataView["layout"], true);
        //        if($this->flagDebug === false) {
        //            $output = str_replace(array("\t", "\r\n", "\n"), " ", $output);
        //            $output = preg_replace("/\s\s+/", " ", $output);
        //        }
    
        $this->benchmark->mark("benchmarkParserEnd");
    
        $this->log(
            "parser benchmark: " . $this->benchmark->elapsed_time("benchmarkParserStart", "benchmarkParserEnd")
        );
    
        $this->log(
            "method benchmark: " . $this->benchmark->elapsed_time("benchmarkMethodStart", "benchmarkMethodEnd")
        );
    
        $this->log(
            "controller benchmark: " . $this->benchmark->elapsed_time("benchmarkControllerStart", "benchmarkParserEnd")
        );
    
        if(!$return) {
            $this->showFirePHPMessages();
            echo $output;
        }
    
        return $output;
    }

    /**
     * Parses a view with data + global data
     *
     * @param string $view
     * @param array $data
     * @param bool $merge
     * @return string
     */
    public function parseView($view, array $data = array(), $merge = true) {
        if($merge === true) {
            $data = array_merge($data, $this->getPublicData());
        }

        $view = $this->parser->parse($view, $data, true);
        // $view = preg_replace("/\s\s+/", " ", $view);
        return $view;
    }
    
    /**
     * Loads a view with data + global data
     *
     * @param string $view
     * @param array $data
     * @param bool $merge
     * @return string
     */
    public function loadView($view, array $data = array(), $merge = true) {
        if($merge === true) {
            $data = array_merge($data, $this->getPublicData());
        }
    
        $view = $this->load->view($view, $data, true);
        // $view = preg_replace("/\s\s+/", " ", $view);
        return $view;
    }

}