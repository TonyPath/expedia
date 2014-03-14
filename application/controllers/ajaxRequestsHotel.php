<?php
use MyProject\Proxies\__CG__\OtherProject\Proxies\__CG__\stdClass;
use Doctrine\Tests\Common\Annotations\False;
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );

require_once(APPPATH . "controllers/ajaxRequests.php");

class AjaxRequestsHotel extends AjaxRequests
{
	
	/**
	 * Handles the AJAX Request for Hotel
	 *
	 */
	public function searchDestination()
	{
		$params = $_GET;
		$data = array();
		
		$limit_result = 5;

		$em = $this->doctrine->em;

		/*
		$this->sphinxclient->SetLimits(0,15);
		$this->sphinxclient->SetMatchMode ( SPH_MATCH_ANY );
		$this->sphinxclient->SetRankingMode ( SPH_RANK_SPH04 );
		*/
		
		/*
		$cities = $this->sphinxclient->Query( $params['s'] , "idx_cities");
		
		foreach($cities['matches'] as $id=>$info){

			$data[] = array(
					'no' => $id,
					'id' => $id,
					'label' => $info['attrs']['elgr_name'],
					'value' => 	$info['attrs']['elgr_name'],
					'category' => "City"
			);
		}
		
		$poi = $this->sphinxclient->Query( $params['s'] , "idx_poi");
		
		foreach($poi['matches'] as $id=>$info){
		
			$data[] = array(
					'no' => $id,
					'id' => $id,
					'label' => $info['attrs']['elgr_name'],
					'value' => 	$info['attrs']['elgr_name'],
					'category' => "Point of interest"
			);
		}
		*/

		/*
		$cities = $this->sphinxclient->Query( $params['s'] , "idx_elgr_regions");
		
		foreach($cities['matches'] as $id=>$info){
		
			$data[] = array(
					'no' => $id,
					'id' => $id,
					'label' => $info['attrs']['origin_name'],
					'value' => 	$info['attrs']['origin_name'],
					'category' => "City"
			);
		}
		*/
		
		
		$ln_sph = new PDO("mysql:host=127.0.0.1;port=9306");
		
		/*		
		$stmt = $ln_sph->prepare("SELECT * FROM idx_destinations WHERE MATCH(:match) AND region_type= :region_type  LIMIT 0,5 OPTION ranker=sph04, field_weights=(lower_name=1)");
		$stmt->bindValue(':match', $params['s'] . "*", PDO::PARAM_STR);
		$stmt->bindValue(':region_type', crc32("city") , PDO::PARAM_INT);
		$stmt->execute();
		$rows = $stmt->fetchAll();
		
		foreach($rows as $idx=>$info){
			$data[] = array(
					'no' => $idx,
					'id' => $info['id'],
					'label' => $info['locale_name'],
					'value' => 	$info['origin_name'],
					'category' => "City"
			);
		}
		*/
		
		$stmt = $ln_sph->prepare("SELECT * FROM idx_cities WHERE MATCH(:match) LIMIT 0, 10 OPTION ranker=sph04, field_weights=(lower_name=1)");
		$stmt->bindValue(':match', $params['s'] . "*", PDO::PARAM_STR);
		//$stmt->bindValue(':region_type', crc32( strtolower( str_replace(" ", "", "Point of Interest") ) ), PDO::PARAM_INT);
		$stmt->execute();
		$rows = $stmt->fetchAll();
		
		foreach($rows as $idx=>$info){
			
			$label = mb_convert_case( $info['locale_name'], MB_CASE_LOWER, 'UTF-8');
			$label = mb_convert_case( $label, MB_CASE_TITLE, 'UTF-8');
			
			$data[] = array(
					'no' => $idx,
					'id' => $info['id'],
					'label' => $label,
					'value' => 	$info['origin_name'],
					'category' => "Cities"
			);
		}
		
		$stmt = $ln_sph->prepare("SELECT * FROM idx_poi WHERE MATCH(:match) LIMIT 0, 10 OPTION ranker=sph04, field_weights=(lower_name=1)");
		$stmt->bindValue(':match', $params['s'] . "*", PDO::PARAM_STR);
		//$stmt->bindValue(':region_type', crc32( strtolower( str_replace(" ", "", "Point of Interest") ) ), PDO::PARAM_INT);
		$stmt->execute();
		$rows = $stmt->fetchAll();
		
		foreach($rows as $idx=>$info){
				
			$label = mb_convert_case( $info['locale_name'], MB_CASE_LOWER, 'UTF-8');
			$label = mb_convert_case( $label, MB_CASE_TITLE, 'UTF-8');
				
			$data[] = array(
					'no' => $idx,
					'id' => $info['id'],
					'label' => $label,
					'value' => 	$info['origin_name'],
					'category' => "Poi"
			);
		}
		
		
		
		
		
		
		/*
		 $cities = $em->getRepository('Entities\CityCoordinates')
		->createQueryBuilder('c')
		->where('c.name LIKE :city_name')
		->setParameter('city_name', '%' . $params['s'] . '%')
		->setMaxResults($limit_result)
		->getQuery()
		->getResult();
		
		
		foreach($cities as $idx => $city){
			
			$data[] = array(
				'no' => $idx,
				'id' => $city->getId(),
				'label' => $city->getName(),
				'value' => 	$city->getName(),
				'category' => "City"
			);
		}
		
		$poi = $em->getRepository('Entities\PointOfInterest')
		->createQueryBuilder('p')
		->where('p.name LIKE :poi_name')
		->setParameter('poi_name', '%' . $params['s'] . '%')
		->setMaxResults($limit_result)
		->getQuery()
		->getResult();
		
		
		foreach($poi as $idx => $pi){
				
			$data[] = array(
					'no' => $idx,
					'id' => $pi->getId(),
					'label' => $pi->getName(),
					'value' => 	$pi->getName(),
					'category' => "Point Of Interset"
			);
		}
		*/
		
		
		return 
		array(
			"responseStatus" => 1,
			"data"  => $data
		);
	}

	public function listHotels(){
		
		$this->load->library('SrvEanApi');
		
		$params = $_POST;
		$dateLess = true;
		
		$pagingParams = array();
		$primarySearchParams = array();
		$availabilitySearchParams = array();
		$filteringSearchParams = array();
		$otherSearchParams = array();
		
		if ( isset($params['cacheKey']) && isset($params['cacheLocation']) ){
		
			$searchMethod = "more";
			
			$pagingParams['cacheKey'] = $params['cacheKey'];
			$pagingParams['cacheLocation'] = $params['cacheLocation'];
		}
		else {

			$searchMethod = "coordinates";
			$dateLess = true;
			$latitude = "";
			$longitude = "";
			
			$destination = $this->doctrine->em->find('Entities\Region', $params["region_id"]);
			
			if ($destination != null){ // IS REGION
	
				$type = $destination->getType();
				
				$primarySearchParams["destinationString"] = $destination->getNameLong();

				$coordinates = $destination->getCoordinates();
					
				if ($coordinates != null){
						
					$latitude = $destination->getCoordinates()->getLatitude();
					$longitude = $destination->getCoordinates()->getLongitude();
					
					$primarySearchParams["latitude"] = $latitude;
					$primarySearchParams["longitude"] = $longitude;
				}

				if ($type == "Point of Interest" || $type == "Point of Interest Shadow"){
					
					$poi = $destination->getPoi();
						
					if ($poi != null){ //IS VALID POINT OF INTEREST
					
						$searchMethod = "coordinates";
					
						$latitude = $poi->getLatitude();
						$longitude = $poi->getLongitude();
					
						$primarySearchParams["latitude"] = $latitude;
						$primarySearchParams["longitude"] = $longitude;
					}

				}
				else if ($type == "City"){
					
					$searchMethod = "destinationString";

				}
				else if ($type == "Neighborhood"){

					$searchMethod = "coordinates";
					
				}
				else if ($type == "Multi-City (Vicinity)" || $type == "Multi-Region (within a country)"){ // IS ANY OTHER TYPE
					
					$searchMethod = "destinationString";
				}
			}
			else{
				
				$destination = $this->doctrine->em->find('Entities\Airport', $params["region_id"]);
				
				if ($destination != null){ // IS AIRPORT
					
					$searchMethod = "coordinates";
					
					$latitude = $destination->getLatitude();
					$longitude = $destination->getLongitude();
					
					$primarySearchParams["latitude"] = $latitude;
					$primarySearchParams["longitude"] = $longitude;
				}
			}

					
			if (isset($params['arrival_date']) && isset($params['departure_date'])){ // for room availability
				
				$dateLess = false;
				
				$availabilitySearchParams["arrivalDate"] = DateTime::createFromFormat('d-m-Y', $params['arrival_date'])->format('m/d/Y');
				$availabilitySearchParams["departureDate"] = DateTime::createFromFormat('d-m-Y', $params['departure_date'])->format('m/d/Y');
				
				if (isset($params["rooms"])){
					
					parse_str($params["rooms"], $rooms);
					
					$availabilitySearchParams += $rooms;
				}
				else {
					$availabilitySearchParams += array("room1"=>"2");
				}
			}

			if (isset($params["minRate"]) && isset($params["maxRate"])){
				$filteringSearchParams["minRate"] = $params["minRate"];
				$filteringSearchParams["maxRate"] = $params["maxRate"];
			}
			
			if (isset($params["minStarRating"]) && isset($params["maxStarRating"])){
				$filteringSearchParams["minStarRating"] = $params["minStarRating"];
				$filteringSearchParams["maxStarRating"] = $params["maxStarRating"];
			}

			$otherSearchParams["sort"] = $params["sort"];
		}
		
		$filteringSearchParams["includeSurrounding"] = false;
		
		$otherSearchParams["numberOfResults"] = 50;
		$otherSearchParams["currencyCode"] = $params["currencyCode"];
		$otherSearchParams["includeDetails"] = true;
		
		$criteriaObject = new \stdClass();
		$criteriaObject->pagingParams 		= $pagingParams;
		$criteriaObject->primaryParams 		= $primarySearchParams;
		$criteriaObject->availabilityParams = $availabilitySearchParams;
		$criteriaObject->filteringParams 	= $filteringSearchParams;
		$criteriaObject->otherParams 		= $otherSearchParams;
		$criteriaObject->dateless 			= $dateLess;
		$criteriaObject->searchMethod		= $searchMethod;
		//$criteriaObject->searchMethod		= "hotelIds";
		$criteriaObject->rawData			= $params;

		$searchResponse = $this->srveanapi->searchHotels($criteriaObject);

		//print_r($searchResponse); exit;

		if ($searchResponse->status){
			
			$viewData = $this->srveanapi->processListResponce($searchResponse->response);
			
			$viewData["currencySign"] = SrvEanApi::$MONEY_SIGNS[$otherSearchParams["currencyCode"]];
			$viewData["currencyCode"] = $otherSearchParams["currencyCode"];
			
			$availabilityQueryParams = array();
			
			if (!$dateLess){
				
				//TODO
				$availabilityQueryParams["arrival_date"] = $params["arrival_date"];
				$availabilityQueryParams["departure_date"] = $params["departure_date"];
				
				if (isset($params["rooms"])){
						
					//parse_str($params["rooms"], $roomss);
						
					$availabilityQueryParams += array("rooms"=>  http_build_query($rooms) );
				}
				else {
					$availabilityQueryParams += array("rooms"=> "room1=2");
				}
				
				$viewData["availabilityParams"] = $availabilityQueryParams;
			}
			
			$responseData = array();
			$responseData["hotelList"] = $this->loadView("hotel/_tmpl_list", $viewData);
		}
		else {
			
		}
		
		return
		array(
				"responseStatus" => 1,
				"data"  => $responseData
		);
		
	}	
	

}
