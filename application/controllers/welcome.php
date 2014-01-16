<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		header('Content-Type: text/html; charset=utf-8');
		
		/*
		$r = $this->doctrine->em->getRepository('Entities\Hotel')->getHotelAmenities();
		
		var_dump($r);
		
		exit;
		*/
		
		$r = $this->doctrine->em->getRepository('Entities\Hotel')->getHotels();
		
		var_dump($r);
		
		exit;
		
		$r = $this->doctrine->em->getRepository('Entities\Hotel')->helloWorld();
		
		//echo count($r->getAttributes());
		foreach ($r->getAttributes() as $at){
			
			echo get_class($at->getAttribute());
			echo "<br/>"; 
		}
		
		
		
		exit;
		
		// region overview
		
		$region = $this->doctrine->em->find('Entities\Region', 181255);
		
		echo count($region->getHotels());
		
		//hotel overview
		
		$hotel = $this->doctrine->em->find('Entities\Hotel', 348403);
		
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