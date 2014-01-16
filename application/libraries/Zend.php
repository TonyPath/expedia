<?php if (!defined('BASEPATH')) {exit('No direct script access allowed');}

/**
 * Zend Framework Loader
 *
 * Put the 'Zend' folder (unpacked from the Zend Framework package, under 'Library')
 * in CI installation's 'application/libraries' folder
 * You can put it elsewhere but remember to alter the script accordingly
 *
 * Usage:
 *   1) $this->load->library('zend', 'Zend/Package/Name');
 *   or
 *   2) $this->load->library('zend');
 *      then $this->zend->load('Zend/Package/Name');
 *
 * * the second usage is useful for autoloading the Zend Framework library
 * * Zend/Package/Name does not need the '.php' at the end
 */
class Zend
{
	/**
	 * Constructor
	 *
	 * @param	string $class class name
	 */
	function __construct($class = NULL)
	{
		
		
		Zend\Loader\AutoloaderFactory::factory(
			array(
				'Zend\Loader\StandardAutoloader' => array(
					'autoregister_zf' => true,
					'namespaces'=>array(
						
					)
				)
		));
	}

	
}

?>
