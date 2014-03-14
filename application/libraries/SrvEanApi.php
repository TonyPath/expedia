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
	
	public static $TYPES = array( 
		"unknown"=> "UNKNOWN", 
		"unrecoverable"=> "UNRECOVERABLE", 
		"recoverable"=> "RECOVERABLE", 
		"agent_attention"=> "AGENT_ATTENTION"
	);
	
	public static $MONEY_SIGNS = array(
			"USD" => "$",
			"EUR" => "&euro;",
			"AUD" => "A$",
			"GBP" => "&pound;"
	);
	const DEFAUL_CURRENCY = 'EUR';
	
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
	
	public function processResponse($response, $element){
		
		if (is_object($response)){
			
			
			// error code from EAN service APIs
			if (property_exists($response->{$element}, "EanWsError")) {
				
				$error = $response->{$element}->EanWsError;
				
				$values = array();
				$values["type"] = $error->handling;
				$values["category"] = $error->category;
				$values["message"] = $error->presentationMessage;
				$values["detail_message"] = $error->verboseMessage;
				$values["itinerary_id"] = $error->itineraryId;
				$values["other_info"] = null;
				$values["error_code"] = $error->category;
				$values["user_message"] = null;
				
				if ($values["type"] == self::$TYPES["unrecoverable"] ){
					
					if ($values["category"] == "UNKNOWN"){
						$values["other_info"] = $error->ErrorAttributes;
						$values["error_code"] = "Invalid Confirmation Number";
					}
				}
				else if ($values["type"] == self::$TYPES["recoverable"] ){
					
					if ($values["category"] == "PRICE_MISMATCH"){
						$values["other_info"] = $error->ErrorAttributes;
					}
					else if ($values["category"] == "DATA_VALIDATION"){
						
						if (property_exists($response->{$element}, "LocationInfos")) {

							$values["error_code"] = "MULTIPLE_lOCATIONS";

							$values["other_info"] = $response->{$element}->LocationInfos->LocationInfo;
							$values["user_message"] = "Multiple Locations";
						}
					}
				}
				else if ($values["type"] == self::$TYPES["agent_attention"] ){
					
					if ($values["category"] == "UNKNOWN"){

						$values["other_info"] = "Please wait for an agent to follow up on the final status of the booking";
						$values["error_code"] = "Confirmed Booking";
					}
					else if ($values["category"] == "SUPPLIER_COMMUNICATION"){
						$values["error_code"] = "Pending Process";
					}
				}

				return $this->returnErrors($values);
			}
			else {
				return $this->returnSuccess($response);
			}
		}
		else { //other HTTP error codes: 403, 404,...
			$values = array();
			$values["type"] = "UNKNOW";
			$values["category"] = "UNKNOW";
			$values["message"] = strip_tags($response);
			$values["detail_message"] = null;
			$values["itinerary_id"] = null;
			$values["other_info"] = null;
			$values["error_code"] = null;
			$values["user_message"] = null;
			
			return $this->returnErrors($values);
		}
	}
	
	public function returnSuccess($response){
		
		$success = array(
				"status"=> true,
				"response"=> $response
		);
		
		return (object) $success;
	}
	
	public function returnErrors($values){
		
		$error = array(
			"status"=> false,
			"error"=> $values
		);
		
		return (object) $error;
	}
	
	public function searchHotels($criteriaObject){
	
		//print_r($criteriaObject); exit;
		
		$requestParams = array();
		
		if ($criteriaObject->searchMethod == "more"){
			
			$requestParams += $criteriaObject->pagingParams;
		}
		else if ($criteriaObject->searchMethod == "destinationString"){
			
			$requestParams["destinationString"] = $criteriaObject->primaryParams["destinationString"];
			
			if (!$criteriaObject->dateless){
				$requestParams += $criteriaObject->availabilityParams;
			}
			
			$requestParams += $criteriaObject->filteringParams;
			$requestParams += $criteriaObject->otherParams;
		}
		else if ($criteriaObject->searchMethod == "coordinates"){
			
			$requestParams["latitude"] = $criteriaObject->primaryParams["latitude"];
			$requestParams["longitude"] = $criteriaObject->primaryParams["longitude"];
			
			if (!$criteriaObject->dateless){
				$requestParams += $criteriaObject->availabilityParams;
			}
			
			$requestParams += $criteriaObject->filteringParams;
			$requestParams += $criteriaObject->otherParams;
			
			$requestParams['searchRadius'] = "10";
			$requestParams['searchRadiusUnit'] = "KM";
			$requestParams['sort'] = "PROXIMITY";
		}
		else if ($criteriaObject->searchMethod == "hotelIds"){
			//TODO
			$regionID =  $criteriaObject->rawData["region_id"];
			$hotelsIDList = $this->CI->doctrine->em->getRepository('Entities\Hotel')->getHotelsIDList( $regionID );
			//echo $hotelsIDList; exit;
			
			$requestParams['hotelIdList'] = $hotelsIDList;
			
			$requestParams += $criteriaObject->filteringParams;
			$requestParams += $criteriaObject->otherParams;

			$requestParams['sort'] = "NO_SORT";
		}

		
		//print_r($requestParams); exit;
		
		$serviceResponse = $this->make_rest_request('list', $requestParams, "POST");
		
		//print_r($serviceResponse); exit;

		$listResponse = $this->processResponse($serviceResponse, "HotelListResponse");

		if (!$listResponse->status){

			$error = $listResponse->error;
			
			if ($error["error_code"] == "MULTIPLE_lOCATIONS"){

				$regionID =  $criteriaObject->rawData["region_id"];
				//TODO
			}
		}
		
		return $listResponse;
	} 

	
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
	
	
	public function processListResponce($listResponse){
		
		$response = $listResponse->HotelListResponse;
		$results = array();
		$hotels = array();
		
		//$results['searchCriteria'] =  $requestParams;
		
		if ($response->HotelList->size > 0){
				
			if ($response->HotelList->size == 1){
				$hotelList = array(0=>$response->HotelList->HotelSummary);
			} else{
				$hotelList = $response->HotelList->HotelSummary;
			}
				
			foreach ($hotelList as $hotel){
					
				if (true){
		
					$objHotel = new stdClass();
						
					if (isset($hotel->RoomRateDetailsList)){
						
						$rateInfo = $hotel->RoomRateDetailsList->RoomRateDetails->RateInfos->RateInfo;
						$chargeableRateInfo = $rateInfo->ChargeableRateInfo;
						$numberOfRoomsRequested = count($rateInfo->RoomGroup->Room);
						
						$objHotel->rateCode = $hotel->RoomRateDetailsList->RoomRateDetails->rateCode;
					}
						
					$objHotel->id = $hotel->hotelId;
						
					$objHotel->name = $hotel->name;
						
					$objHotel->address = $hotel->address1;
						
					$objHotel->city = $hotel->city;
						
					$objHotel->rating = $hotel->hotelRating;
						
					$objHotel->highRate = $hotel->highRate;
						
					$objHotel->lowRate = $hotel->lowRate;
					
					$objHotel->sortedPrice = $hotel->lowRate;
						
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

					if (isset($chargeableRateInfo)){
							
						$objPromoRoom = new stdClass();
						$objPromoRoom->ratesInfo = new stdClass();
						$objPromoRoom->ratesInfo->isPromo = false;
		
						$objPromoRoom->ratesInfo->allRoomsAllDays = new stdClass();
		
						if (isset($rateInfo) && isset($rateInfo->promo) && $rateInfo->promo === "true"){
		
							$objPromoRoom->ratesInfo->isPromo = true;
							$objPromoRoom->ratesInfo->promoDescription = (isset($rateInfo->promoDescription)) ? $rateInfo->promoDescription : "";
							//$objPromoRoom->ratesInfo->promoDescription = "";
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
						
						$objHotel->sortedPrice = $objPromoRoom->ratesInfo->allRoomsAllDays->totalPrice;
					}
						
					if ( preg_match('/_t|b\.jpg$/', $hotel->thumbNailUrl) ){
		
						$objHotel->thumbUrl = 'http://images.travelnow.com' . (string) $hotel->thumbNailUrl;
		
						$objHotel->thumbTypes = new stdClass();
						$objHotel->thumbTypes->big 			= preg_replace('/_t|b/', '_b', $objHotel->thumbUrl);
						$objHotel->thumbTypes->landscape 	= preg_replace('/_t|b/', '_l', $objHotel->thumbUrl);
						$objHotel->thumbTypes->small 		= preg_replace('/_t|b/', '_s', $objHotel->thumbUrl);
						$objHotel->thumbTypes->f90 			= preg_replace('/_t|b/', '_n', $objHotel->thumbUrl);
						$objHotel->thumbTypes->f140 		= preg_replace('/_t|b/', '_g', $objHotel->thumbUrl);
						$objHotel->thumbTypes->f180 		= preg_replace('/_t|b/', '_d', $objHotel->thumbUrl);
						$objHotel->thumbTypes->f500 		= preg_replace('/_t|b/', '_y', $objHotel->thumbUrl);
					}
						
					$hotels[] = $objHotel;
				}
			}
		}
		
		
		
		$results['hotels'] = $hotels;
		$results['more_results_available'] = $response->moreResultsAvailable;
		$results['size'] = $response->HotelList->size;
		$results['active_property_count'] = $response->HotelList->activePropertyCount;
		
		$results['cache_key'] = (isset($response->cacheKey)) ? $response->cacheKey : "";
		$results['cache_location'] = (isset($response->cacheLocation)) ? $response->cacheLocation : "";
		//$results['current_page'] = $page;
		$results["rate_key"] = (isset($response->rateKey)) ? $response->rateKey : "";
		
		return $results;
		
	}
	
	
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
	
	public function getHotelAvailability($availabilityParams){
		
		$originServiceResponse = $this->make_rest_request('avail', $availabilityParams, "GET");
		
		$response = $this->processResponse($originServiceResponse, "HotelRoomAvailabilityResponse");
		
		if ($response->status == true){
				
			$fixedResponse = $this->processHotelAvailResponse($response->response);
		
			return (object) array("status"=> true, "response"=> $fixedResponse);
		}
		else {
			return $response;
		}
	}
		
	public function getAvailHotelRooms($hotelId, $availParams = array(), $rateKey = null) {

		//$requestAvailParams = $this->buildSearchAvailRequestParams($availParams);
		$requestAvailParams = $availParams;
		//$requestAvailParams['options'] = "HOTEL_DETAILS,ROOM_TYPES,ROOM_AMENITIES,PROPERTY_AMENITIES,HOTEL_IMAGES";
		
		$requestAvailParams['hotelId'] = $hotelId;
		
		if ($rateKey !== null){
			$requestAvailParams['rateKey'] = $rateKey;
		}
		
		$originServiceResponse = $this->make_rest_request('avail', $requestAvailParams, "GET");
		
		$response = $this->processResponse($originServiceResponse, "HotelRoomAvailabilityResponse");
		
		if ($response->status == true){	
			
			$fixedResponse = $this->processHotelAvailResponse($response->response);

			return (object) array("status"=> true, "response"=> $fixedResponse);
		}
		else {
			return $response;
		}
	}
	
	public function getHotelDetails($hotelId){
		
		//$requestParams['options'] = "HOTEL_SUMMARY";
		
		$requestParams['hotelId'] = $hotelId;
				
		$originServiceResponse = $this->make_rest_request('info', $requestParams, "GET");
		
		$response = $this->processResponse($originServiceResponse, "HotelInformationResponse");
		
		if ($response->status == true){
			
			$fixedResponse = $this->processHotelInfoResponse($response->response);
			
			return (object) array("status"=> true, "response"=> $fixedResponse);
		}
		else {
			
			return $response;
		}
		
	}
	
	public function processHotelInfoResponse($hotelInfoResponse){
	
		$response = $hotelInfoResponse->HotelInformationResponse;
	
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
		
	
		$responseInfo = new stdClass();
		$responseInfo->hotel = $objHotel;
	
		return $responseInfo;
	}
	
	public function processHotelAvailResponse($hotelAvailResponse){
		
		//return $hotel_avail_response;
		
		$response = $hotelAvailResponse->HotelRoomAvailabilityResponse;
		
		//print_r($response); exit;
		
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
			//$objRoom->rateKey = $rateInfo->RoomGroup->Room->rateKey;
			//Zend\Debug\Debug::dump($room->RateInfos->RateInfo->RoomGroup);
			
			
			$objRoom->description = $room->rateDescription;
			
			if (isset($room->roomTypeDescription))
			$objRoom->description = $room->roomTypeDescription;
			
			if (isset($room->RateInfos)){
				$rateInfo = 			$room->RateInfos->RateInfo;
				$chargeableRateInfo = $rateInfo->ChargeableRateInfo;
				
				$objRoom->rateKey = @ $rateInfo->RoomGroup->Room->rateKey;
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