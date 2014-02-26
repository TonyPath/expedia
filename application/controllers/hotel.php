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
		$this->load->library('SrvEanApi');
	}
	
	
	
	public function index(){

		$this->addMinifyScriptsGroup('hotel_list_scripts');
		
		$params = $_GET;
		
		$this->dataView["main"]["checkin_date"] = $params["arrival_date"];
		$this->dataView["main"]["checkout_date"] = $params["departure_date"];
		
		$this->setView('hotel/list');
		
		$this->loadLayout();
	}
	
	public function overview(){
		
		$params = $_GET;

		if ( isset($params['arrival_date']) && isset($params['departure_date']) && isset($params["rooms"]) ){
			
			$arrivalDate = DateTime::createFromFormat('d-m-Y', $params['arrival_date'])->format('m/d/Y');
			$departureDate = DateTime::createFromFormat('d-m-Y', $params['departure_date'])->format('m/d/Y');
			
			parse_str($params["rooms"], $rooms);
			
			$overviewResponse  = $this->srveanapi->getAvailHotelRooms(
					$params['hotelId'],
					array(
							'arrivalDate'	=> $arrivalDate,
							'departureDate'	=> $departureDate
					) + $rooms
			);
		}
		else {
			$overviewResponse = $this->srveanapi->getHotelInfos($params['hotelId']);
		}

		$this->dataView['main']['hotelOverview'] = $overviewResponse;
	
		$this->setView('hotel/overview');
	
		$this->loadLayout();
	}
	
	
}
