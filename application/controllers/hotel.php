<?php

if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );



class Hotel extends MY_Controller {

	public function __construct() {

		parent::__construct ();
		
		$this->show_searchbar = false;
		
		$this->addMinifyStylesGroup('form_styles');
		$this->addMinifyScriptsGroup('form_scripts');
		
		$this->addMinifyStylesGroup('homepage_styles');
		$this->addMinifyScriptsGroup('homepage_scripts');
		
		$this->load->helper('url');		
	}
	
	public function index(){
		
		$this->addMinifyScriptsGroup('hotel_list_scripts');
		
		$params = $_GET;
		
		$this->dataView["main"]["checkin_date"] = $params["arrival_date"];
		$this->dataView["main"]["checkout_date"] = $params["departure_date"];
		
		$this->setView('hotel/list');
		
		$this->loadLayout();
	}
	
	
}
