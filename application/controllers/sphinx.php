<?php

if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );



class Sphinx extends CI_Controller {

	public function __construct() {

		parent::__construct ();

		$this->load->helper('url');
		

		$this->load->library('SrvEAN');
		$this->load->library('SrvEanApi');

		
	}
	
	public function test(){
		
		header('Content-Type: text/html; charset=utf-8');
		
		//$this->sphinxclient->SetArrayResult( true );
		$this->sphinxclient->SetLimits(0,5);
		$this->sphinxclient->SetMatchMode ( SPH_MATCH_EXTENDED2 );
		$this->sphinxclient->SetFilter( 'RegionType', 'City' );
		
		$results = $this->sphinxclient->Query("paris","idx_regions");
		
		//$result_array = $this->sphinxclient->runQueries();
		//Zend\Debug\Debug::dump($results);
		
		foreach($results['matches'] as $id=>$info){
			
			$region = $this->doctrine->em->find('Entities\Region', $id);
			echo $region->getName()."/".$region->getNameLong()."/". $region->getType() ."<br>";
		}
		
		
		
		exit;
		
		header('Content-Type: text/html; charset=utf-8');
		
		
		
		$response = $this->srveanapi->find_hotels_by_geo_info(
				"37.881165",
				"23.754358",
				0,
				"KM",
				array(
						'arrival_date'=>'02/25/2014',
						'departure_date' => '02/28/2014',
						'room1' => "2,5,12",
						'room2' => "2",
						
				),
				array(
						'arrival_date'=>'02/25/2014',
						'departure_date' => '02/28/2014',
						'room1' => "2,5,12",
						'room2' => "2",
						
				),
				1
		);
		
		Zend\Debug\Debug::dump($response);
		
		exit;
		
		/*
		$response = $this->srvean->find_hotels_by_dest_id(
				"0B5A074C-2566-41A3-B466-02796757A7D5",
				array(
						'arrival_date'=>'11/25/2013',
						'departure_date' => '11/28/2013',
						'room1' => "2,5,12",
						'room2' => "2",
						'include_surrounding' => true,
						'sort' => 'CITY_VALUE'
				),
				1
		);
		*/

		/*
		$response = $this->srvean->find_hotels_by_id_list(
				181255,
				array(
						'arrival_date'=>'11/25/2013',
						'departure_date' => '11/28/2013',
						'room1' => "2,2,3"
				),
				$_GET['page']
		);
		*/
		//exit;
		
		/*
		$response = $this->srveanapi->find_hotels_by_geo_info(
				37.881165,
				23.754358,
				5,
				"KM",
				array(
					'arrival_date'=>'11/25/2013',
					'departure_date' => '11/28/2013',
					'room1' => "2,5,12",
					'room2' => "2,2,5"
				),
				array(),
				1
		);

		*/
		
		
		
		
		
		/*
		$EAN_region_hotel_mapping = Doctrine::getTable('EanRegionEanHotelIdMapping');
		
		$hotelIds = $EAN_region_hotel_mapping->get_hotel_id_list(181255);
		
		$ids = array();
		
		foreach ($hotelIds as $hotels){
			$ids[] = $hotels['ean_hotel_id'];
		}
		
		$hotelIdList = implode(",", $ids);
		
		$response = $this->srveanapi->find_hotels_by_id_list(
				$hotelIdList,
				array(
						'arrival_date'=>'11/25/2013',
						'departure_date' => '11/28/2013',
						'room1' => "2,5,12"
				),
				array(),
				1
		);
		*/
		
		
		
		
		/*
		$response = $this->srveanapi->find_hotels_by_dest_id(
				"0B5A074C-2566-41A3-B466-02796757A7D5",
				array(
						'arrival_date'=>'11/25/2013',
						'departure_date' => '11/28/2013',
						'room1' => "2,5,12"
				),
				array(
					'include_surrounding' => true,
					'sort' => 'CITY_VALUE'
				),
				1
		);
		
		*/
		
		
		
		Zend\Debug\Debug::dump($response);
		exit;

		/*
		
		$se = $this->srveanapi->get_hotel_rooms(
				"210240",
				null,
				array(
					'arrivalDate'=>'11/25/2013',
					'departureDate' => '11/28/2013',
					'room1' => "2,5,12"
				)
		);
		*/
		
		
		exit;
		echo "<pre>";
		foreach($response['hotels'] as $hot){
			echo $hot->name;
			echo "&nbsp;\t\t\t\t\t\t\t";
			echo $hot->parsed_data['total'];
			echo "\n";
		}
		echo "</pre>";
		
	}
	
	
	
	public function index() {
		
		$this->dataView['main']['markup']['frm_search'] = $this->loadView("hotel/frm_search");
		
		$this->setView('hotel/index');
		
		$this->loadLayout ();
	}
	
	
	
	public function search(){
		
		$availSearchParams = null;
		
		// if search is for availability, prepare avail params
		if (isset($_GET['arrivalDate']) && isset($_GET['departureDate'])){
			
			// format date request params according to expedia MM/DD/YYYY format.
			$formatedArrivalDate 	= DateTime::createFromFormat('d-m-Y', $_GET['arrivalDate'])->format('m/d/Y');
			$formatedDepartureDate 	= DateTime::createFromFormat('d-m-Y', $_GET['departureDate'])->format('m/d/Y');	
			
			// format rooms request param according to expedia &room[room number, starting with 1]=[number of adults],[comma-delimited list of children's ages] format 
			$formatedRoomGroups 	= $this->buildRoomGroupsParam($_GET);

			
			$availSearchParams = array(
									'arrivalDate'	=> $formatedArrivalDate,
									'departureDate'	=> $formatedDepartureDate
								) + $formatedRoomGroups;
			
		}
		
		// get hotel id list from db, mapping with region id
		$hotelIdList = $this->srvean->getHotelsIdList(
			$_GET['regionId']
		);
		
		// call expedia api to get hotels
		$response = $this->srveanapi->findHotelsByIdList(
				$hotelIdList,
				$availSearchParams,
				$availSearchParams,
				@($_GET['page'])?:1
		);

		//header('content-type application/json charset=utf-8');	echo json_encode($response); exit;
		//Zend\Debug\Debug::dump($response); exit;
		
		$this->dataView['main']['searchResults'] = $response;
		$this->dataView['main']['searchCriteria'] = $_SERVER['QUERY_STRING'];
		
		$this->setView('hotel/list_hotel');
		
		$this->loadLayout();
	}
	
	public function xhr_list_hotel(){
		
		$response = $this->srvean->request_list($_GET, @ (int) $_GET['page'] );
		
		return array(
			
		);
	}
	
	private function buildRoomGroupsParam($data) {
		
		$infoArray = array();
		
		//if (is_array( $data )) {
			
			//if (isset( $data['rooms'] )) {
				
				for($i = 1; $i <= $data['rooms']; $i++) {
				//for($i = 1; $i <= $data; $i++) {
					
					$rm = array ();
					$adults = $data['adults' . $i];
					$rm [] = $adults;
					
					for($j = 1; $j <= $data['child' . $i]; $j++) {
						$rm [] = $data['childAge' . $i . $j];
					}
					
					$infoArray['room' . $i] = implode( ',', $rm );
				}
			//}
			
			return $infoArray;
		//}
	}
		
	public function overview(){

		if (isset($_GET['arrivalDate']) && isset($_GET['departureDate'])){
			
			$formatedArrivalDate = DateTime::createFromFormat('d-m-Y', $_GET['arrivalDate'])->format('m/d/Y');
			$formatedDepartureDate = DateTime::createFromFormat('d-m-Y', $_GET['departureDate'])->format('m/d/Y');
			$formatedRooms = array_intersect_key($_GET, array_flip(preg_grep('/room[1-9]$/', array_keys($_GET), 0)));
			
			$response = $this->srveanapi->getAvailHotelRooms(
					$_GET['hotelId'],
					array(
						'arrivalDate'	=> $formatedArrivalDate,
						'departureDate'	=> $formatedDepartureDate
					) + $formatedRooms
			);
		}
		else{
			$response = $this->srveanapi->getHotelInfos($_GET['hotelId']);
		}
		
		
		

		//header('content-type application/json charset=utf-8');	echo json_encode($response); exit;
		//Zend\Debug\Debug::dump($response); exit;

		$this->dataView['main']['hotelOverview'] = $response;
		
		$this->setView('hotel/overview');

		$this->loadLayout ();
	}
	
	public function search_region(){
		
		//$EAN_region_mapper = Doctrine::getTable('EanParentRegionList');
		$EAN_region_mapper = Doctrine::getTable('EanCityCoordinatesList');

		$term = $_GET['term'];

		$results = $EAN_region_mapper->search($term);

		$response =	array(
							"responseStatus" => 1,
							"messages" => array(
									"message" => "dasdsa"
							),
							"regions"=>$results
					);

		echo Zend\Json\Json::encode(($response));
	}
}
