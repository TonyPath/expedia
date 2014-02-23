<?php
use MyProject\Proxies\__CG__\OtherProject\Proxies\__CG__\stdClass;
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
		
		
		return 
		array(
			"responseStatus" => 1,
			"data"  => $data
		);
	}

	public function listHotels(){
		
		$params = $_POST;
		$data = array();
		
		$this->load->library('SrvEanApi');
		
		parse_str($params["rooms"], $rooms);
		
		$requestListParams = array("numberOfResults" => 50);
		
		if ($params['item_category'] == "City"){

			$requestListParams = array_merge($requestListParams, $rooms);
				
			if (isset($params['cacheKey'])){
				$requestListParams['cacheKey'] = $params['cacheKey'];
			}
				
			if (isset($params['cacheLocation'])){
				$requestListParams['cacheLocation'] = $params['cacheLocation'];
			}
			else {
				$requestListParams = array(
						
						"arrivalDate" => DateTime::createFromFormat('d-m-Y', $params['arrival_date'])->format('m/d/Y'),
						"departureDate" => DateTime::createFromFormat('d-m-Y', $params['departure_date'])->format('m/d/Y'),
						"destinationString" => $params["destination_string"]
				);
			}
			
			
		}
		
		
		
		$responseList = $this->srveanapi->make_rest_request("list", $requestListParams, "POST");
		
		//print_r($responseList); exit;
		
		$processedData = $this->srveanapi->processListResponce($responseList);
		
		$data = $this->loadView("hotel/_tmpl_list", $processedData);
		
		return
		array(
				"responseStatus" => 1,
				"data"  => $data
		);
	}	
	

}
