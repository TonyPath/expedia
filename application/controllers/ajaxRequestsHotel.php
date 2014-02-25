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
		
		$this->load->library('SrvEanApi');
		
		$params = $_POST;
		
		$MONEY_SIGNS = array(
			"USD" => "$",
			"EUR" => "&euro;",
			"AUD" => "A$",
			"GBP" => "&pound;"
		);
		$DEFAUL_CURRENCY = 'EUR';

		$money_sign = $MONEY_SIGNS[isset($params["currencyCode"]) ? $params["currencyCode"] : $DEFAUL_CURRENCY];
		
		$rate_filters = array(
			array("name" => "Any Rate", "value" => "-1", "selected" => 'selected'),
			array("name" => sprintf("%s 1  - %s 100", $money_sign, $money_sign), "value" => "1-100", "selected" => ''),
			array("name" => sprintf("%s 100 - %s 200", $money_sign, $money_sign), "value" => "100-200", "selected" => ''),
			array("name" => sprintf("%s 200 - %s 300", $money_sign, $money_sign), "value" => "200-300", "selected" => ''),
			array("name" => sprintf("%s 300 - %s 500", $money_sign, $money_sign), "value" => "300-500", "selected" => ''),
			array("name" => sprintf("%s 500 - %s 1000", $money_sign, $money_sign), "value" => "500-1000", "selected" => ''),
			array("name" => sprintf("%s 1000+", $money_sign), "value" => "1000-999999999", "selected" => '')
		);
		
	
		
		
		
		parse_str($params["rooms"], $rooms);
		
		$requestListParams = array("numberOfResults" => 100);
		
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
						"destinationString" => $params["destination_string"],
						"minStarRating" => $params["minStarRating"],
						"sort" => $params["sort"],
						"currencyCode" => $params["currencyCode"],
						"minRate" => $params["minRate"],
						"maxRate" => $params["maxRate"]
				);
			}
			
			
		}
		
		
		
		$responseList = $this->srveanapi->make_rest_request("list", $requestListParams, "POST");
		
		//print_r($responseList); exit;
		
		$processedData = $this->srveanapi->processListResponce($responseList);
		
		$processedData["rate_filters"] = $rate_filters;
		
		
		$data = array();
		$data["hotelList"] = $this->loadView("hotel/_tmpl_list", $processedData);
		
		return
		array(
				"responseStatus" => 1,
				"data"  => $data
		);
	}	
	

}
