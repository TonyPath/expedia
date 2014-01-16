<?php
if (!defined('BASEPATH')) {exit('No direct script access allowed');}

use Zend\Http\Client as HttpClient;

/**
 * @package libraries\servives\api\Expedia
 */

class SrvEAN {

	private $CI;
	
	//Common Request Parameters
	protected $cid = 55505;
	protected $apiKey = 'ruwfrrvzrkt4kzewxjuphm8u';
	protected $secret = 'pD9T8qct';
	protected $currency = "EUR";
	protected $lastRequest = 0;
	const  DEFAULT_SHOW_RESULTS = 10;
	protected $minorRev = 20;
	protected $countryLocale = 'el_GR';
	protected $currencyCode = 'EUR';
	
	
	protected $client;
	
	public function __construct(){

		//session_start();
		
		$this->CI = &get_instance();
		
		$this->CI->load->helper('array');
		
		$this->CI->load->library('SrvEanApi');
		/*
		$this->lastRequest = 0;
		
		$this->client = new HttpClient();
		$this->client->setAdapter('Zend\Http\Client\Adapter\Curl');
		*/
	}
	
	/**
	 * 
	 * @param unknown $rid
	 * @param unknown $request_params
	 * <code>
	 * 
	 * </code>
	 * @param number $page
	 * @return unknown
	 */
	public function find_hotels_by_geo_info($rid, $request_params = array(), $page = 1){
		
		$EAN_region_center_coordinates_list = Doctrine::getTable("EanRegionCenterCoordinatesList");
		$region_center_coordinates = $EAN_region_center_coordinates_list->findOneByRegion_id($rid);
		
		$response = $this->CI->srveanapi->find_hotels_by_geo_info(
				$region_center_coordinates->center_latitude,
				$region_center_coordinates->center_longitude,
				@($request_params['radius'])?:0,
				@($request_params['radius_unit'])?:"KM",
				$request_params,
				$request_params,
				$page
		);

		return $response;
	}
	
	/**
	 * 
	 * @param int $did
	 * @param unknown $request_params
	 * @param number $page
	 * @return unknown
	 */
	public function find_hotels_by_dest_id($did, $request_params = array(), $page = 1){
		
		$response = $this->CI->srveanapi->find_hotels_by_dest_id(
				$did,
				$request_params,
				$request_params,
				$page
		);
		
		return $response;
	}
	
	/**
	 * 
	 * @param unknown $rid
	 * @param unknown $request_params
	 * @param number $page
	 * @return unknown
	 */
	public function getHotelsIdList($rid, $page = 1){
		
		$EanRegionHotelMapping = Doctrine::getTable('EanRegionEanHotelIdMapping');
		$hotelIds = $EanRegionHotelMapping->findByRegion_id($rid);

		$ids = array();

		foreach ($hotelIds as $hotels){
			$ids[] = $hotels['ean_hotel_id'];
		}

		$hotelIdList = implode(",", $ids);
		
		return $hotelIdList;
		
		/*
		$response = $this->CI->srveanapi->find_hotels_by_id_list(
				$hotelIdList,
				$request_params,
				$request_params,
				$page
		);

		return $response;
		*/
	}
	
	public function get_hotels_from_db_by_geo_info($rid, $page = 1){
		
	}
	
	
	//--------------------------------------------------- 
	
	

}