<?php

use MyProject\Proxies\__CG__\OtherProject\Proxies\__CG__\stdClass;
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
	
	public function index()
	{
	
		$this->addMinifyScriptsGroup('hotel_home_scripts');
		
		$this->setView('hotel/home');
	
		$this->loadLayout();
	}
	
	public function search(){
		
		$params = $_GET;
		
		$this->dataView["main"]["checkin_date"] = isset($params["arrival_date"])? $params["arrival_date"] : "";
		$this->dataView["main"]["checkout_date"] = isset($params["departure_date"])? $params["departure_date"] : "";
		
		$this->addMinifyScriptsGroup('hotel_list_scripts');
		
		$this->setView('hotel/list');
		
		$this->loadLayout();
	}
	
	public function overview(){
		
		$params = $_GET;
		
		$returnResponse = new \stdClass();
		
		$detailHotelResponse  = $this->srveanapi->getHotelDetails($params['hotelId']);
		
		if ($detailHotelResponse->status){
			
			$returnResponse->hotel = $detailHotelResponse->response->hotel;
			
			if (isset($params['arrival_date']) && isset($params['departure_date'])){ // for room availability
			
				$dateLess = false;
			
				$availabilityParams["arrivalDate"] = DateTime::createFromFormat('d-m-Y', $params['arrival_date'])->format('m/d/Y');
				$availabilityParams["departureDate"] = DateTime::createFromFormat('d-m-Y', $params['departure_date'])->format('m/d/Y');
			
				if (isset($params["rooms"])){
						
					parse_str($params["rooms"], $rooms);
						
					$availabilityParams += $rooms;
				}
				else {
					$availabilityParams += array("room1"=>"2");
				}
				
				$availabilityParams["currencyCode"] = $params["currencyCode"];
				$availabilityParams["includeDetails"] = true;
				
				$availabilityParams["hotelId"] = $params["hotelId"];
				
				
				$availableRoomResponse  = $this->srveanapi->getHotelAvailability($availabilityParams);
				
				if ($availableRoomResponse->status){
						
					$returnResponse->hotel->rooms = $availableRoomResponse->response->hotel->rooms;
						
				}
				
			}
			
			
		}
		else {
			Zend\Debug\Debug::dump($detailHotelResponse);
			exit;
		}
		
		$this->dataView['main']['hotelOverview'] = $returnResponse;
	
		$this->setView('hotel/overview');
	
		$this->loadLayout();
	}
	
	
}
