<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Homepage extends MY_Controller  {

	public function __construct(){
		
		parent::__construct();
		
		$this->show_searchbar = false;
		
		$this->addMinifyStylesGroup('form_styles');
		$this->addMinifyScriptsGroup('form_scripts');
		
		$this->addMinifyStylesGroup('homepage_styles');
		$this->addMinifyScriptsGroup('homepage_scripts');
		
	}
	
	public function index()
	{

		$this->setView('homepage/homepage_main');

		$this->loadLayout();
	}
	
	public function sindex()
	{
		header('Content-Type: text/html; charset=utf-8');
		
		$r = $this->doctrine->em->getRepository('Entities\Hotel')->getHotelsIDList( 2734 );
		Zend\Debug\Debug::dump($r);
		//echo $r[0]['hotelIDList'];
		
		exit;
		
		
		$r = $this->doctrine->em->getRepository('Entities\Hotel')->getHotels( array(2734), "ElGr" );
		Zend\Debug\Debug::dump($r);
		//echo $r[0]['hotelIDList'];
		
		exit;
		$r = $this->doctrine->em->getRepository('Entities\Hotel')->getAmenitiesForHotel(182141);
		Zend\Debug\Debug::dump($r);
		
		exit;
		$r = $this->doctrine->em->getRepository('Entities\Hotel')->getPointsOfInterestsForHotel(182141);
		Zend\Debug\Debug::dump($r);
		exit;
		/*
		$region = $this->doctrine->em->find('Entities\Region', 181255);
		Zend\Debug\Debug::dump($region->getCoordinates());
		exit;
		*/
		/*
		$r = $this->doctrine->em->getRepository('Entities\Hotel')->getHotelAmenities();
		
		var_dump($r);
		
		exit;
		*/
		/*
		$r = $this->doctrine->em->getRepository('Entities\Hotel')->getHotels();
		
		Zend\Debug\Debug::dump($r);		
		exit;
		
		$r = $this->doctrine->em->getRepository('Entities\Hotel')->helloWorld();
		
		//echo count($r->getAttributes());
		foreach ($r->getAttributes() as $at){
			
			echo get_class($at->getAttribute());
			echo "<br/>"; 
		}
		exit;
		*/
		
		// region overview
		/*
		$region = $this->doctrine->em->find('Entities\Region', 181255);
		
		echo count($region->getHotels());
		
		//hotel overview
		*/
		$hotel = $this->doctrine->em->find('Entities\Hotel', 109460);
		echo $hotel->getChain()->getName();
		exit;
		echo count($hotel->getRegions());
		
		echo "<br/>";
		
		foreach($hotel->getImages() as $image ){
			echo $image->getUrl();
			echo "<br/>";
		}
		
		echo "<br/>";
		foreach($hotel->getAttributes() as $attribute ){
			
			
			echo $attribute->getAttribute()->getId();
			echo "/";
			echo $attribute->getAttribute()->getDescription();
			echo "/";
			echo $attribute->getAppendTxt();
			echo "<br/>";
		}
	}
	
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */