<?php
/**
 * MY_Form Validation Class
 *
 * @package     CodeIgniter
 * @subpackage  Libraries
 * @category    Validation
 * @author      Jerry Manolarakis, Vassilis Meneklis
 * @version     2.0
 * @copyright   SG 2011
 *
 */
class MY_Form_validation extends CI_Form_validation {

	public function postDataValidation($postArray = "") {
	    //if ther is no _POST array return
		if ( empty($_POST)) {
			return false;
		}

		$CI =& get_instance();
		$targetedPost = false;

		//parse ini file
		$validationCriteria = @parse_ini_file(APPPATH . "config/Form_validation.ini");
		
		//validate the post variables needed
		if(!empty($postArray) && isset($validationCriteria[$postArray])){
		    $emptyArray = array_diff($validationCriteria[$postArray], array_keys($_POST));
		    $targetedPost = true;
    		if(!empty($emptyArray)){
    		    return false;
    		}
		}

		//set the rules for the form validation
		foreach ( $_POST as $key => $value ) {
		    if($targetedPost && !in_array($key, $validationCriteria[$postArray])){
		        continue;
		    }
		    $validationKey = $key;
		    $required = (    substr( $key,
		                        strlen($key) - 3,
		                        strlen($key)
	                        ) == $validationCriteria["requiredExtention"]
                        );
		    if($required){
		        $validationKey = substr($key, 0, strlen($key) - 3);
		    }
			if ( array_key_exists( $validationKey, $validationCriteria ) ) {
				$CI->form_validation->set_rules($key,
												"lang:" . $validationKey,
				                                $required ?
				                                    $validationCriteria["required"] . $validationCriteria[$validationKey] :
				                                    $validationCriteria[$validationKey]
			                                    );
			}
		}

		return true;
	}

	/**
     * AlphaMultilingual
     *
     * @access  public
     * @param   string
     * @return  bool
     */
    public function alphaMultilingual($str) {
        return ( ! preg_match("/^[αβγδεζηθικλμνξοπρστυφχψωςΑΒΓΔΕΖΗΘΙΚΛΜΝΞΟΠΡΣΤΥΦΧΨΩέύίάήώόϋϊΐΰA-Za-z\-\.\s_]+$/", trim($str)) ) ? FALSE : TRUE;
    }

    /**
     * ValidYoutube
     *
     * @access  public
     * @param   string
     * @return  bool
     */
    public function validYoutube($str) {
        return ( ! preg_match("/(?:youtube\.com\/(?:user\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^\"&\?\/ ]{11})/", $str) ) ? FALSE : TRUE;
    }

	/**
     * PhoneNumber
     *
     * @access  public
     * @param   string
     * @return  bool
     */
    public function phoneNumber($str) {
        return ( ! preg_match("/^[\d\s+-]+$/", trim($str)) ) ? FALSE : TRUE;
    }

	/**
     * validDate
     *
     * @access  public
     * @param   string
     * @return  bool
     */
    public function validDate($str) {
    	$tmpDate = str_replace("/", "-", str_replace(".", "-", $str));
    	if ( ( $stamp = strtotime($tmpDate) ) === FALSE ) {
    		return FALSE;
    	}
    	$month = date( "m", $stamp );
        $day   = date( "d", $stamp );
        $year  = date( "Y", $stamp );

        return checkdate($month, $day, $year);
    }

    /**
     * captchaChk
     *
     * @access  public
     * @param   string
     * @return  bool
     */
	public function captchaChk($str) {
		$CI =& get_instance();
        $CI->load->plugin("cryptograph");

        //added string for captcha for testing environment to validate with string eTSsGt
        $debug = $CI->config->item("debug");
        return ($debug === true && $str === "eTSsGt") || (isset($_POST["rnd_captcha"]) && chk_crypt($str, $_POST["rnd_captcha"]));
    }//captchaChk

    /**
     * validPasswordChars
     *
     * @access  public
     * @param   string
     * @return  bool
     */
	public function validPasswordChars($str) {
        return ( ! preg_match("/^[A-Za-z0-9\-\.\!\@\#\$\%\^\&\*\(\)\-\_\=\+\{\}\[\]\|\;\:\?\>\<\.\,]*$/", $str) ) ? FALSE : TRUE;
    }//validPasswordChars

    /**
     * validPasswordConfirm
     *
     * @access  public
     * @param   string
     * @return  bool
     */
	public function validPasswordConfirm($str, $field) {
		if ( ! isset($_POST[$field]) ) {
			return false;
		}
		$field = $_POST[$field];
        return ( $str !== $field ) ? false : true;
    }//validPasswordConfirm

    /**
     * validAgentLandPhoneNumber
     *
     * @access  public
     * @param   string
     * @return  bool
     */
	public function validAgentLandPhoneNumber($str) {
		$CI =& get_instance();
        if( $_POST["fv_countryReq"] == "0030"
            &&
            (
                substr($str, 0, 2) == "69"
                || substr($str, 0, 2) == "00"
                || strlen($str)!= 10
            )
        )
        {
            return false;
        } else {
            return true;
        }
    }//validAgentLandPhoneNumber

	/**
	 * Greather than
	 *
	 * @access	public
	 * @param	string
	 * @return	bool
	 */
	function stgu_greater_than($str, $min)
	{
		if ( ! $this->is_natural($str))
		{
			return FALSE;
		}
		return (int) $str > (int) $min;
	}

	// --------------------------------------------------------------------

	/**
	 * Less than
	 *
	 * @access	public
	 * @param	string
	 * @return	bool
	 */
	function stgu_less_than($str, $max)
	{
		if ( ! $this->is_natural($str))
		{
			return FALSE;
		}
		return (int) $str < (int) $max;
	}

	/**
	 * Greather than or equal
	 *
	 * @access	public
	 * @param	string
	 * @return	bool
	 */
	function stgu_greater_than_or_equal($str, $min)
	{
		if ( ! $this->is_natural($str))
		{
			return FALSE;
		}
		return (int) $str >= (int) $min;
	}

	// --------------------------------------------------------------------

	/**
	 * Less than or equal
	 *
	 * @access	public
	 * @param	string
	 * @return	bool
	 */
	function stgu_less_than_or_equal($str, $max)
	{
		if ( ! $this->is_natural($str))
		{
			return FALSE;
		}
		return (int) $str <= (int) $max;
	}

	// --------------------------------------------------------------------
	
	function stgu_unique_email($str, $exclude_loggedin = false)
	{
		$CI =& get_instance();

		$options = array();

		if ($exclude_loggedin){
			
			$CI->load->helper('sguser');
		
			$user = user_logged_in();
		
			if ($user){
				$options['exclude'] = $user->getUid();
			}
		}
		
		$CI->load->library('validator/NoEmailExists', $options);
		
		return $CI->noemailexists->isValid($str);
	}
}