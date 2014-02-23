<?php
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );

class AjaxRequests extends MY_Controller
{

	/**
	 *
	 * Constructor
	 */
    public function __construct() {
        parent::__construct();

        //load the form validation and the languge
        $this->load->library("form_validation");
        $this->lang->load("form_validation", ($this->language == "gr" ? "greek" : "english"));

        if(!$this->isSGAjax())
        {
//             show_404(__CLASS__ . "::" . __FUNCTION__ . " - AJAX only");
//             die();
        }

		//default validation rules based on the names of the input elements of the form
    }
}
