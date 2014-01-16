<?php
if (!defined('BASEPATH')) {exit('No direct script access allowed');}

use Zend\Http\Client as HttpClient;

/**
 * @package libraries\servives\api\Expedia
 */

class SrvEanApi {

	private $CI;
	
	//Common Request Parameters
	protected $cid = 55505;
	protected $apiKey = 'ruwfrrvzrkt4kzewxjuphm8u';
	protected $secret = 'pD9T8qct';
	protected $currency = "EUR";
	protected $lastRequest = 0;
	const  DEFAULT_SHOW_RESULTS = 10;
	protected $minorRev = 99;
	protected $countryLocale = 'el_GR';
	protected $currencyCode = 'EUR';
	
	
	protected $client;
	
	public function __construct(){

		session_start();
		
		$this->CI = &get_instance();
		
		$this->CI->load->helper('array');
		
		$this->lastRequest = 0;
		
		$this->client = new HttpClient();
		$this->client->setAdapter('Zend\Http\Client\Adapter\Curl');
	}
	
	public function make_rest_request($service, $json, $method = "GET", $timestamp = ""){
		
		$url = "http://api.ean.com/ean-services/rs/hotel/v3/" . $service . '?';
		
		$requestData = array(
				'cid' => $this->cid,
				'apiKey' => $this->apiKey,
				//'secret' => $this->secret,
				'minorRev' => $this->minorRev,
				'locale' => $this->countryLocale,
				'currencyCode' => $this->currency,
				'customerUserAgent' => $_SERVER['HTTP_USER_AGENT'],
				'customerIpAddress' => $_SERVER['REMOTE_ADDR']
				//'supplierCacheTolerance'=> "MIN"
		);
		
		$postData = array_merge($requestData, $json);
	
		$this->client->setUri($url);
			
		$this->client->setMethod($method);
			
		if ($method == "GET"){
			$this->client->setParameterGET($postData);
		}
		elseif ($method == "POST"){
			$this->client->setParameterPost($postData);
		}
		else{
			$this->client->setParameterPost($postData);
		}
		
		
		//$this->client->setHeaders(array('Accept-encoding' => 'gzip, json'));

		$curl_attempts = 0;                                        
		$MAXIMUM_CURL_ATTEMPTS = 5;
		
		//do
		{
			$response = $this->client->send();
		} 
		//while (strlen($response) == 0 && ++$curl_attempts < $MAXIMUM_CURL_ATTEMPTS);
		
        $responseBody = $response->getBody(); 
        $responseBody = str_replace("@", "", $responseBody);
        
        $responseJson = json_decode($responseBody);
		
		return $responseJson;
	}
	
	/**
	 * 
	 * @param unknown $lat
	 * @param unknown $lng
	 * @param number $radius
	 * @param string $radius_unit
	 * @param unknown $base_params
	 * @param unknown $filter_params
	 * @param number $page
	 * @return multitype:unknown NULL multitype:NULL
	 */
	public function find_hotels_by_geo_info($lat, 
											$lng, 
											$radius = 10, 
											$radius_unit = "KM", 
											$base_params = array(), 
											$filter_params = array(),
											$page = 1){

		$requestParams = array();

		if ($page == 0) {
			$page = 1;
			//$origin_params['page'] = 1;
		}

		if ($page == 1 || $page == 0)
			$_SESSION['EAN_hotel_results'] = array();

		if(isset($_SESSION['EAN_hotel_results'][$page])){
			$requestParams['cacheKey'] = $_SESSION['EAN_hotel_results'][$page]['cacheKey'];
			$requestParams['cacheLocation'] = $_SESSION['EAN_hotel_results'][$page]['cacheLocation'];
		}
		else {
			$request_geoinfo_params = array();
			$request_geoinfo_params['latitude'] = $lat;
			$request_geoinfo_params['longitude'] = $lng;
			$request_geoinfo_params['searchRadius'] = $radius;
			$request_geoinfo_params['searchRadiusUnit'] = $radius_unit;
			$request_geoinfo_params['sort'] = "PROXIMITY";

			$request_base_params 	= $this->buildSearchAvailRequestParams($base_params);

			$request_filter_params 	= $this->buildSearchFilterRequestParams($filter_params);

			$requestParams = array_merge($request_base_params, $request_geoinfo_params, $request_filter_params);
		}
		//Zend\Debug\Debug::dump($requestParams);exit;
		$response = $this->make_rest_request('list', $requestParams, "POST");
		//return $response;

		$parsed_response = $this->parseHotelListResponse($response, $requestParams, $base_params, $page);

		$this->update_hotel_list_session($response, $page);

		return $parsed_response;
	}
	
	/**
	 * 
	 * @param unknown $id_list
	 * @param unknown $base_params
	 * @param unknown $filter_params
	 * @param number $page
	 * @return multitype:unknown NULL multitype:NULL
	 */
	public function findHotelsByIdList( $idList,	
										$baseParams = array(),
										$filterParams = array(),
										$page = 1){
	
		$requestParams = array();
	
		if ($page == 0) {
			$page = 1;
			//$origin_params['page'] = 1;
		}
	
		if ($page == 1 || $page == 0)
			$_SESSION['EAN_hotel_results'] = array();
	
		if(isset($_SESSION['EAN_hotel_results'][$page])){
			$requestParams['cacheKey'] = $_SESSION['EAN_hotel_results'][$page]['cacheKey'];
			$requestParams['cacheLocation'] = $_SESSION['EAN_hotel_results'][$page]['cacheLocation'];
		}
		else {
			$requestIdListParams = array();
			$requestIdListParams['hotelIdList'] = $idList;
	
			$requestBaseParams 	= $this->buildSearchAvailRequestParams($baseParams);
	
			$requestFilterParams 	= $this->buildSearchFilterRequestParams($filterParams);
	
			$requestParams = array_merge($requestBaseParams, $requestIdListParams, $requestFilterParams);
		}
		
		//Zend\Debug\Debug::dump($baseParams);
	
		$response = $this->make_rest_request('list', $requestParams, "POST");
	
		$parsed_response = $this->parseHotelListResponse($response, $requestParams, $requestBaseParams, $page);
	
		$this->update_hotel_list_session($response, $page);
	
		return $parsed_response;
	}
	
	/**
	 * 
	 * @param unknown $dest_id
	 * @param unknown $base_params
	 * @param unknown $filter_params
	 * @param number $page
	 * @return multitype:unknown NULL multitype:NULL
	 */
	public function find_hotels_by_dest_id( $dest_id,
											$base_params = array(),
											$filter_params = array(),
											$page = 1){
	
		$requestParams = array();
	
		if ($page == 0) {
			$page = 1;
			//$origin_params['page'] = 1;
		}
	
		if ($page == 1 || $page == 0)
			$_SESSION['EAN_hotel_results'] = array();
	
		if(isset($_SESSION['EAN_hotel_results'][$page])){
			$requestParams['cacheKey'] = $_SESSION['EAN_hotel_results'][$page]['cacheKey'];
			$requestParams['cacheLocation'] = $_SESSION['EAN_hotel_results'][$page]['cacheLocation'];
		}
		else {
			$request_dest_params = array();
			$request_dest_params['destinationId'] = $dest_id;
	
			$request_base_params 	= $this->buildSearchBaseRequestParams($base_params);
	
			$request_filter_params 	= $this->build_search_filter_request_params($filter_params);
	
			$requestParams = array_merge($request_base_params, $request_dest_params, $request_filter_params);
		}
		//Zend\Debug\Debug::dump($requestParams);exit;
		$response = $this->make_rest_request('list', $requestParams, "POST");
	
		$parsed_response = $this->parseHotelListResponse($response, $requestParams, $request_base_params, $page);

		$this->update_hotel_list_session($response, $page);
	
		return $parsed_response;
	}	

	/**
	 * 
	 * @param unknown $hotel_list_response
	 * @param unknown $page
	 */
	public function update_hotel_list_session($hotel_list_response, $page){
		
		$response = $hotel_list_response->HotelListResponse;
		
		if(isset($response->cacheKey)){
			$cacheKey = (string)$response->cacheKey;
			$cacheLoc = (string)$response->cacheLocation;
				
			if (!isset($_SESSION['EAN_hotel_results'][$page + 1])) {
				$_SESSION['EAN_hotel_results'][$page + 1] = array(
						'cacheKey' => $cacheKey,
						'cacheLocation' => $cacheLoc
				);
			}
		}
	}
	
	/**
	 * 
	 * @param unknown $hotel_list_response
	 * @param unknown $page
	 * @return multitype:unknown NULL multitype:NULL
	 */
	public function parseHotelListResponse($hotelListResponse, $requestParams, $availParams, $page){
		
		$response = $hotelListResponse->HotelListResponse;
		$results = array();
		$hotels = array();
		
		$results['searchCriteria'] =  $requestParams;
		
		if ($response->HotelList->size > 0){
			
			if ($response->HotelList->size == 1){
				$hotelList = array(0=>$response->HotelList->HotelSummary);
			} else{
				$hotelList = $response->HotelList->HotelSummary;
			}
			
			foreach ($hotelList as $hotel){
			
				//if (!isset($hotel->RoomRateDetailsList)) continue;
				
			
				if (true){

					$objHotel = new stdClass();
					
					if (isset($hotel->RoomRateDetailsList)){
						$rateInfo = 			$hotel->RoomRateDetailsList->RoomRateDetails->RateInfos->RateInfo;
						$chargeableRateInfo = $rateInfo->ChargeableRateInfo;
						$numberOfRoomsRequested = count($rateInfo->RoomGroup->Room);
					}
					
					$objHotel = new stdClass();
					
					$objHotel->id = $hotel->hotelId;
					
					$objHotel->name = $hotel->name;
					
					$objHotel->address = $hotel->address1;
					
					$objHotel->city = $hotel->city;
					
					$objHotel->rating = $hotel->hotelRating;
					
					$objHotel->highRate = $hotel->highRate;
					
					$objHotel->lowRate = $hotel->lowRate;
					
					$objHotel->latitude = $hotel->latitude;
					
					$objHotel->longitude = $hotel->longitude;
					
					if (isset($hotel->airportCode)){
						$objHotel->airportCode = $hotel->airportCode;
					}

					$objHotel->category = $hotel->propertyCategory;
					
					$objHotel->shortDescription = $hotel->shortDescription;
					
					$objHotel->amenityMask = $hotel->amenityMask;
					
					$objHotel->maskedAmenities = '';
					
					$objHotel->currency = (string) $hotel->rateCurrencyCode;

					if (isset($hotel->locationDescription)){
						$objHotel->locationDescription = $hotel->locationDescription;
					}

					/*
					if (isset($chargeableRateInfo)) { 
						
						$hotel->parsed_info->promo 					= $rateInfo->promo;
						
						$hotel->parsed_info->total_price 			= $chargeableRateInfo->total? $chargeableRateInfo->total :'';
						
						$hotel->parsed_info->average_nightly_rate 	= number_format($chargeableRateInfo->averageRate, 2, '.', '');
					
						$hotel->parsed_info->max_nightly_rate 		= number_format($chargeableRateInfo->maxNightlyRate, 2, '.', '');
			
						$hotel->parsed_info->nightly_rate_total 	= number_format($chargeableRateInfo->nightlyRateTotal, 2, '.', '');
			
						$hotel->parsed_info->surcharge_total 		= number_format(isset($chargeableRateInfo->surchargeTotal)?$chargeableRateInfo->surchargeTotal:0, 2, '.', '');			
					}
					*/
					
					
					if (isset($chargeableRateInfo)){
					
						$objPromoRoom = new stdClass();
						$objPromoRoom->ratesInfo = new stdClass();
						$objPromoRoom->ratesInfo->isPromo = false;
						
						$objPromoRoom->ratesInfo->allRoomsAllDays = new stdClass();
						
						if (isset($rateInfo) && isset($rateInfo->promo) && $rateInfo->promo === "true"){
								
							$objPromoRoom->ratesInfo->isPromo = true;
							$objPromoRoom->ratesInfo->promoDescription = $rateInfo->promoDescription;
						}
												
						$objPromoRoom->ratesInfo->surchargeTotal = @ $chargeableRateInfo->surchargeTotal;
					
											
						if (isset($chargeableRateInfo->NightlyRatesPerRoom) && isset($chargeableRateInfo->NightlyRatesPerRoom->NightlyRate)){
							
							if (is_array($chargeableRateInfo->NightlyRatesPerRoom->NightlyRate)){
								$numberOfNights = count($chargeableRateInfo->NightlyRatesPerRoom->NightlyRate);
							}
							elseif (is_object($chargeableRateInfo->NightlyRatesPerRoom->NightlyRate)){
								$numberOfNights = 1;
							}
							
							$surchargeAvg =  $objPromoRoom->ratesInfo->surchargeTotal / $numberOfNights;
							
							foreach($chargeableRateInfo->NightlyRatesPerRoom->NightlyRate as $nightlyRate  ) {
					
								
								$objPromoRoom->ratesInfo->allRoomsAllDays->totalPriceBreakdownPerDay[] = (object) array(
										"promo" => $nightlyRate->promo,
										"rate" => ($nightlyRate->rate * $numberOfRoomsRequested) + $surchargeAvg,
										"baseRate" =>  ($nightlyRate->baseRate * $numberOfRoomsRequested) + $surchargeAvg );
									
								$objPromoRoom->ratesInfo->allRoomsAllDays->totalBasePrice += $nightlyRate->baseRate;
					
								$objPromoRoom->ratesInfo->allRoomsAllDays->totalPrice += $nightlyRate->rate;
							}
						}
						else {
							continue;
						}

						$objPromoRoom->ratesInfo->allRoomsAllDays->totalBasePrice *= $response->numberOfRoomsRequested;
						$objPromoRoom->ratesInfo->allRoomsAllDays->totalBasePrice += $objPromoRoom->ratesInfo->surchargeTotal;
					
						$objPromoRoom->ratesInfo->allRoomsAllDays->totalPrice *= $response->numberOfRoomsRequested;
						$objPromoRoom->ratesInfo->allRoomsAllDays->totalPrice += $objPromoRoom->ratesInfo->surchargeTotal;
						
						$objHotel->promoRoom = $objPromoRoom;
					}
					
					if ( preg_match('/_t|b\.jpg$/', $hotel->thumbNailUrl) ){
						
						$objHotel->thumbUrl = 'http://images.travelnow.com' . (string) $hotel->thumbNailUrl;
						
						$objHotel->thumbTypes = new stdClass();
						$objHotel->thumbTypes->big 		= preg_replace('/_t|b/', '_b', $objHotel->thumbUrl);
						$objHotel->thumbTypes->landscape 	= preg_replace('/_t|b/', '_l', $objHotel->thumbUrl);
						$objHotel->thumbTypes->small 		= preg_replace('/_t|b/', '_s', $objHotel->thumbUrl);
						$objHotel->thumbTypes->f90 		= preg_replace('/_t|b/', '_n', $objHotel->thumbUrl);
						$objHotel->thumbTypes->f140 		= preg_replace('/_t|b/', '_g', $objHotel->thumbUrl);
						$objHotel->thumbTypes->f180 		= preg_replace('/_t|b/', '_d', $objHotel->thumbUrl);
						$objHotel->thumbTypes->f500 		= preg_replace('/_t|b/', '_y', $objHotel->thumbUrl);
					}
					
					$objHotel->url_avail_query_params = http_build_query( array('hotel_id'=>$hotel->hotelId) + $availParams );
					
					$hotels[] = $objHotel;
				}
			}
		}
		
		
		
		$results['hotels'] = $hotels;
		$results['more_results_available'] = $response->moreResultsAvailable;
		$results['size'] = $response->HotelList->size;
		$results['active_property_count'] = $response->HotelList->activePropertyCount;
		$results['current_page'] = $page;
		
		return $results;
	}
	
	/**
	 * 
	 * @param unknown $base_params
	 * @return multitype:string unknown
	 */
	public function buildSearchAvailRequestParams($baseParams){

		//return $base_params;
		
		$requestParams = array();
		$rooms = array();
		
		$requestParams['numberOfResults'] = self::DEFAULT_SHOW_RESULTS;
		
		if (isset($baseParams['arrivalDate']) && isset($baseParams['departureDate'])){

			if (true){

				function preg_grep_keys($pattern, $input, $flags = 0) {
					return array_intersect_key($input, array_flip(preg_grep($pattern, array_keys($input), $flags)));
				}
								
				$requestParams['arrivalDate'] = $baseParams['arrivalDate'];
				$requestParams['departureDate'] = $baseParams['departureDate'];
			
				
				$rooms = preg_grep_keys('/room[1-9]$/', $baseParams);
				
				
				/*
				if (isset( $base_params['rooms'] )) {
			
					for($i = 1; $i <= $base_params['rooms']; $i ++) {
						
						$rm = array ();
						$adults = $base_params['adults' . $i];
						$rm [] = $adults;
						
						for($j = 1; $j <= $base_params['child' . $i]; $j ++) {
							$rm [] = $base_params['childage' . $i . $j];
						}
						
						$requestParams['room' . $i] = implode ( ',', $rm );
					}
				}
				else {
					// error rooms
				}
				*/
			}
			else {
				//error date format
			}
		}
		else {
			// dateless searching
		}
		
		return $requestParams + $rooms;
	}
	
	public function buildAvailBaseRequestParams($availParams){
		
		$params = $this->buildSearchBaseRequestParams($availParams);
		
		unset($params['numberOfResults']);
		
		return $params;
	} 
	
	/**
	 * 
	 * @param unknown $filter_params
	 * @return multitype:unknown
	 */
	public function buildSearchFilterRequestParams($filter_params){
		
		//return $filter_params;
		
		$requestParams = array();
		
		if (isset($filter_params['min_rate'])){
			$requestParams['minRate'] = $filter_params['min_rate']; 
		}
		
		if (isset($filter_params['max_rate'])){
			$requestParams['maxRate'] = $filter_params['max_rate'];
		}
		
		if (isset($filter_params['min_star'])){
			$requestParams['minStarRating'] = $filter_params['min_star'];
		}
		
		if (isset($filter_params['max_star'])){
			$requestParams['maxStarRating'] = $filter_params['max_star'];
		}
		
		if (isset($filter_params['sort'])){
			$requestParams['sort'] = $filter_params['sort'];
		}
		
		if (isset($filter_params['include_surrounding'])){
			$requestParams['includeSurrounding'] = $filter_params['include_surrounding'];
		}
		
		return $requestParams;
	}
		
	public function getAvailHotelRooms($hotelId, $availParams = array(), $rateKey = null) {

		$requestAvailParams = $this->buildSearchAvailRequestParams($availParams);
		$requestAvailParams['options'] = "HOTEL_DETAILS,ROOM_TYPES,ROOM_AMENITIES,PROPERTY_AMENITIES,HOTEL_IMAGES";
		
		$requestAvailParams['hotelId'] = $hotelId;
		
		if ($rateKey !== null){
			$requestAvailParams['rateKey'] = $rateKey;
		}
		
		$response = $this->make_rest_request('avail', $requestAvailParams, "GET");
		
		//$hotelRoomAvailabilityResponse = $response->HotelRoomAvailabilityResponse;
		
		$parsed_response = $this->parseHotelAvailResponse($response, $requestAvailParams);
		
		return $parsed_response;
	}
	
	public function getHotelInfos($hotelId){
		
		$requestParams['hotelId'] = $hotelId;
				
		$response = $this->make_rest_request('info', $requestParams, "GET");
		
		$parsedResponse = $this->parseHotelInfoResponse($response, $requestParams);
		
		return $parsedResponse;
	}
	
	public function parseHotelInfoResponse($hotelInfoResponse, $requestParams){
	
		//return $hotel_avail_response;
	
		$response = $hotelInfoResponse->HotelInformationResponse;
	
	
		//if ($response->size == 0){
		//	return (object) array();
		//}
	
		
		
		/*
		 * Request Infos
		*/
		$requestInfo = new stdClass();
	
		/*
		 * Hotel Infos
		*/
		$objHotel = new stdClass();
	
		$objHotel->id = $response->HotelSummary->hotelId;
	
		$objHotel->name = $response->HotelSummary->name;
	
		$objHotel->countryCode = $response->HotelSummary->countryCode;
	
		$objHotel->city = $response->HotelSummary->city;
	
		$objHotel->address = $response->HotelSummary->address1;
			
		if (isset($response->HotelImages)){

			$objHotel->images = array();

			$_images = $response->HotelImages->HotelImage;

			if (is_array($_images)){

				foreach( $_images as $image){
					$objHotel->images[] = (object) array(
							"caption" => @ $image->caption,
							"thumbUrl" => $image->thumbnailUrl,
							"bigUrl" => $image->url );
				}
			}
			elseif (is_object($_images)){
				$objHotel->images[] = (object) array(
						"caption" => $_images->caption,
						"thumbUrl" => $_images->thumbnailUrl,
						"bigUrl" => $_images->url );
			}
		}
	
		if (isset($response->PropertyAmenities)) {
	
			$objHotel->amenities = array();
	
			if (is_array($response->PropertyAmenities->PropertyAmenity)){
	
				foreach($response->PropertyAmenities->PropertyAmenity as $hotel_amenity){
					$objHotel->amenities[] = $hotel_amenity->amenity;
				}
			}
		}
	
		if (isset($response->HotelDetails)) {
			$objHotel->description = $response->HotelDetails->propertyDescription;
		}
		
	
		$requestInfo->hotel = $objHotel;
	
		return $requestInfo;
	}
	
	public function parseHotelAvailResponse($hotel_avail_response, $request_avail_params){
		
		//return $hotel_avail_response;
		
		$response = $hotel_avail_response->HotelRoomAvailabilityResponse;
		
		
		if ($response->size == 0){
			return (object) array();
		}
		
		/*
		 * Request Infos
		*/
		$requestInfo = new stdClass();

		/*
		 * Booking Infos
		 */
		$bookRequestInfo = new stdClass();
		
		$formated_arrival_date = DateTime::createFromFormat('m/d/Y', $response->arrivalDate);
		$formated_departure_date = DateTime::createFromFormat('m/d/Y', $response->departureDate);	
		$interval = date_diff($formated_arrival_date, $formated_departure_date);
		
		$bookRequestInfo->arrivalDate = $response->arrivalDate;		
		$bookRequestInfo->departureDate = $response->departureDate;
		$bookRequestInfo->numberOfNights = (int) $interval->format('%a');
		$bookRequestInfo->numberOfRoomsRequested = $response->numberOfRoomsRequested;
		
		$bookRequestInfo->checkinInstructs = $response->checkInInstructions;
		
		$requestInfo->bookInfo = $bookRequestInfo;

		$hotel_room_res = is_array($response->HotelRoomResponse) ? $response->HotelRoomResponse : array($response->HotelRoomResponse);
		
		/*
		 * Hotel Infos
		 */
		$objHotel = new stdClass();

		$objHotel->id = $response->hotelId;
		
		$objHotel->name = $response->hotelName;
		
		$objHotel->countryCode = $response->hotelCountry;
		
		$objHotel->city = $response->hotelCity;
		
		$objHotel->address = $response->hotelAddress;
		
		if (isset($response->HotelImages)){
		
			$objHotel->images = array();
		
			$_images = $response->HotelImages->HotelImage;
		
			if (is_array($_images)) {
					
				foreach( $_images as $image){
					$objHotel->images[] = (object) array(
							"caption" => @ $image->caption,
							"thumbUrl" => $image->thumbnailUrl,
							"bigUrl" => $image->url );
				}
			}
			elseif (is_object($_images)) {
				$objHotel->images[] = (object) array(
						"caption" => $_images->caption,
						"thumbUrl" => $_images->thumbnailUrl,
						"bigUrl" => $_images->url );
			}
		}
		
		if (isset($response->PropertyAmenities)) {
		
			$objHotel->amenities = array();
		
			if (is_array($response->PropertyAmenities->PropertyAmenity)){
				
				foreach($response->PropertyAmenities->PropertyAmenity as $hotelAmenity){
					
					//$objHotel->hotel_amenities[] = (object) array("id" => $hotel_amenity->amenityId, "description" => $hotel_amenity->amenity );
					$objHotel->amenities[] = $hotelAmenity->amenity;
				}
			}
		}
		
		if (isset($response->HotelDetails)) {
			//$objHotel->hotel_details = $response->HotelDetails;
			$objHotel->description = $response->HotelDetails->propertyDescription;
		}
		

		/*
		 * process hotel rooms
		 */
		$objHotel->rooms = array();
		
		foreach($hotel_room_res as $idx=>$room){
			
			$objRoom = new stdClass();

			//$objRoom->price_total = 0;
			//$objRoom->rate_key = $rateInfo->RoomGroup->Room->rateKey;
			
			
			$objRoom->description = $room->rateDescription;
			
			if (isset($room->roomTypeDescription))
			$objRoom->description = $room->roomTypeDescription;
			
			if (isset($room->RateInfos)){
				$rateInfo = 			$room->RateInfos->RateInfo;
				$chargeableRateInfo = $rateInfo->ChargeableRateInfo;
			}
			
			$objRoom->ratesInfo = new stdClass();
			$objRoom->ratesInfo->isPromo = false;
			
			$objRoom->ratesInfo->allRoomsAllDays = new stdClass();
			
			if (isset($rateInfo) && isset($rateInfo->promo) && $rateInfo->promo === "true"){
				
				$objRoom->ratesInfo->isPromo = true;
				$objRoom->ratesInfo->rateChange = $rateInfo->rateChange;
				$objRoom->ratesInfo->promoDescription = $rateInfo->promoDescription;
			}

			if ($chargeableRateInfo){

				$objRoom->ratesInfo->surchargeTotal = @ $chargeableRateInfo->surchargeTotal;
				
				$surchargeAvg =  $objRoom->ratesInfo->surchargeTotal / $bookRequestInfo->numberOfNights;
				
				if (isset($chargeableRateInfo->NightlyRatesPerRoom) && isset($chargeableRateInfo->NightlyRatesPerRoom->NightlyRate)){
					
					foreach($chargeableRateInfo->NightlyRatesPerRoom->NightlyRate as $nightlyRate  ) {
						
						$objRoom->ratesInfo->allRoomsAllDays->totalPriceBreakdownPerDay[] = (object) array(
							"promo" => $nightlyRate->promo, 
							"rate" => ($nightlyRate->rate * $bookRequestInfo->numberOfRoomsRequested) + $surchargeAvg, 
							"base_rate" =>  ($nightlyRate->baseRate * $bookRequestInfo->numberOfRoomsRequested) + $surchargeAvg );
					
						$objRoom->ratesInfo->allRoomsAllDays->totalBasePrice += $nightlyRate->baseRate;

						$objRoom->ratesInfo->allRoomsAllDays->totalPrice += $nightlyRate->rate;
					}
				}
				else {
					continue;
				}
				
				$objRoom->ratesInfo->allRoomsAllDays->description = "Total Price for : " . $bookRequestInfo->numberOfRoomsRequested . " (". 
				$objRoom->description .") Rooms, " .  $bookRequestInfo->numberOfNights . " Nights." ;
				
				$objRoom->ratesInfo->allRoomsAllDays->totalBasePrice *= $response->numberOfRoomsRequested;
				$objRoom->ratesInfo->allRoomsAllDays->totalBasePrice += $objRoom->ratesInfo->surchargeTotal;
				
				$objRoom->ratesInfo->allRoomsAllDays->totalPrice *= $response->numberOfRoomsRequested;
				$objRoom->ratesInfo->allRoomsAllDays->totalPrice += $objRoom->ratesInfo->surchargeTotal;
			}
			
			if (isset($room->RoomType)){
				
				$objRoom->description = $room->RoomType->description;
				$objRoom->description_long = $room->RoomType->descriptionLong;
				
				if (isset($room->RoomType->roomAmenities)){
					
					$objRoom->amenities = array();
					
					$_roomAmenities = $room->RoomType->roomAmenities->RoomAmenity;

					if (is_array($_roomAmenities)) {
						
						foreach($_roomAmenities as $amenity){
							
							//$objRoom->amenities[] = (object) array("id" => $amenity->amenityId, "description" => $amenity->amenity );
							$objRoom->amenities[] = $amenity->amenity;
						}
					}
					else {
						//$objRoom->amenities[] = (object) array("id" => $_roomAmenities->amenityId, "description" => $_roomAmenities->amenity );
						$objRoom->amenities[] = $_roomAmenities->amenity;
					}
				}
			}
			
			
			if (isset($room->BedTypes)){
				
				$objRoom->bedTypes = array();
				
				$_bedTypes = $room->BedTypes->BedType;
				
				if (is_array($_bedTypes)) {
					
					foreach( $_bedTypes as $bed_type){
						//$objRoom->bedTypes[] = (object) array("id" => $bed_type->id, "description" => $bed_type->description );
						$objRoom->bedTypes[] = $bed_type->description;
					}
				}
				else{
					//$objRoom->room_bedTypes[] = (object) array("id" => $_bedTypes->id, "description" => $_bedTypes->description );
					$objRoom->bedTypes[] = $_bedTypes->description;
				}
			}
			
			if (isset($room->ValueAdds)){
			
				$objRoom->valueAdds = array();
				
				$_valueAdds = $room->ValueAdds->ValueAdd;
			
				if (is_array($_valueAdds)) {
						
					foreach( $_valueAdds as $value_add){
						//$objRoom->room_valueAdds[] = (object) array("id" => $value_add->id, "description" => $value_add->description );
						$objRoom->valueAdds[] = $value_add->description;
					}
				}
				else{
					$objRoom->valueAdds[] = $_valueAdds->description;
				}
			}
			
			if (true){
				
			}
			
			$objHotel->rooms[] = $objRoom;
		}
		
		$requestInfo->hotel = $objHotel;
				
		return $requestInfo;
	}
	
	
	public function geoSearch($destinationString, $type = "1"){
		
		$request = array(
			'LocationInfoRequest'=> array(
				'destinationString'=> $destinationString,
				'type'=> $type
			)
		);
		
		$response = $this->make_rest_request('geoSearch', $request['LocationInfoRequest']);
		
		return $response->LocationInfoResponse;
		
	}
	
	
	
}