<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// ------------------------------------------------------------------------

/**
 * Validation helper
 *
 * @package     Custom Spitogatos Codeigniter code
 * @subpackage  Helpers
 * @category    Helpers
 * @author      foufos
 * @copyright   2013 Spitogatos.gr
 * @version     1a
 * @link        application/frontend/helpers/validation_helper
 */

// ------------------------------------------------------------------------

if(!function_exists("intValidate")) {
    /**
     * Return true if input is integer
     */
    function intValidate($value = null) {
        return is_int($value) || ctype_digit($value);
    }
}

if(!function_exists("stguBoolValidate")) {
    /**
     * Return true if input is yes or no
     */
    function stguBoolValidate($value = null) {
        return $value === 'yes' || $value === 'no';
    }
}