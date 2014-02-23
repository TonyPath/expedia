<?php

if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );



class Hotel extends MY_Controller {

	public function __construct() {

		parent::__construct ();
		
		$this->show_searchbar = false;
		
		$this->addMinifyStylesGroup('form_styles');
		$this->addMinifyScriptsGroup('form_scripts');
		
		$this->load->helper('url');		
	}
	
	public function search(){
		
		$this->addMinifyScriptsGroup('hotel_list_scripts');
		
		$this->setView('hotel/list');
		
		$this->loadLayout();
	}
	
	public function index() {
		
		$this->dataView['main']['markup']['frm_search'] = $this->loadView("hotel/frm_search");
		
		$this->setView('hotel/index');
		/*
		$this->loadLayout ();
		*/
	}
}
