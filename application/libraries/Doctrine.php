<?php

use Doctrine\Common\ClassLoader,
	Doctrine\ORM\Tools\Setup,
	Doctrine\ORM\EntityManager;

class Doctrine
{
	public $em = null;

    public function __construct()
    {
        // include our CodeIgniter application's database configuration
        require_once APPPATH.'config/database.php';
        
        // load the entities
        $entityClassLoader = new \Doctrine\Common\ClassLoader('Entities', APPPATH.'models');
        $entityClassLoader->register();

        // load the proxy entities
        $proxyClassLoader = new \Doctrine\Common\ClassLoader('Proxies', APPPATH.'models');
        $proxyClassLoader->register();

        // load the repo entities
        $repoClassLoader = new \Doctrine\Common\ClassLoader('Repositories', APPPATH.'models');
        $repoClassLoader->register();
        
        // set up the configuration 
        $config = new \Doctrine\ORM\Configuration;

        if(ENVIRONMENT == 'development')
            $cache = new \Doctrine\Common\Cache\ArrayCache;
        else
            $cache = new \Doctrine\Common\Cache\ApcCache;
        
        $config->setMetadataCacheImpl($cache);
        $config->setQueryCacheImpl($cache);
        

        // set up proxy configuration
        $config->setProxyDir(APPPATH.'models/Proxies');
        $config->setProxyNamespace('Proxies');
        
        // auto-generate proxy classes if we are in development mode
        $config->setAutoGenerateProxyClasses(ENVIRONMENT == 'development');

        // set up annotation driver
        $yamlDriver = new \Doctrine\ORM\Mapping\Driver\YamlDriver(APPPATH.'models/Mappings');
        $config->setMetadataDriverImpl($yamlDriver);

        // Database connection information
        $connectionOptions = array(
            'driver' => 'pdo_mysql',
            'user' => $db['default']['username'],
            'password' => $db['default']['password'],
            'host' => $db['default']['hostname'],
            'dbname' => $db['default']['database']
        );
        
        // create the EntityManager
        $em = \Doctrine\ORM\EntityManager::create($connectionOptions, $config);
        
        // store it as a member, for use in our CodeIgniter controllers.
        $this->em = $em;
    }
}