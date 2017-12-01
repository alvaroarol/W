<?php

namespace W;

/**
 * Manages the config and executes the router
 */
class App{

	/** @var array Contains the complete config table */
	protected $config;
	/** @var \AltoRouter The router */
	protected $router;
	/** @var string URL sub-folder from which the application is accessed */
	protected $basePath;


	/**
	 * Constructor
	 * @param array $w_routes Routing table
	 * @param array $w_config Optional config table
	 */
	public function __construct(array $w_routes, array $w_config = array()){

		session_start();
		$this->setConfig($w_config);
		$this->routingSetup($w_routes);

	}


	/**
	 * Configures routing
	 * @param array $w_routes Routing table
	 */
	private function routingSetup(array $w_routes){

		$this->router = new \AltoRouter();

		// See .htaccess
		$this->basePath = (empty($_SERVER['W_BASE'])) ? '' : $_SERVER['W_BASE'];

		$this->router->setBasePath($this->basePath);
		$this->router->addRoutes($w_routes);

	}

	/**
	 * Gets the config given by the application
	 * @param array $w_config Config table
	 */
	private function setConfig(array $w_config){

		$defaultConfig = [
		   	// DB connexion info
			'db_host' => 'localhost',
		    'db_user' => 'root',
		    'db_pass' => '',
		    'db_name' => '',
		    'db_table_prefix' => '',

			// Authentification, autorisation
			'security_user_table' => 'users',
			'security_id_property' => 'id',
			'security_username_property' => 'username',
			'security_email_property' => 'email',
			'security_password_property' => 'password',
			'security_role_property' => 'role',

			'security_login_route_name' => 'login',

			// Global config
			'site_name'	=> '',
		];

		// Merges user config with default config
		$this->config = array_merge($defaultConfig, $w_config);

	}


	/**
	 * Gets a config entry
	 * @param string $key Config table key
	 * @return mixed Config value
	 */
	public function getConfig($key){

		return (isset($this->config[$key])) ? $this->config[$key] : null;

	}


	/**
	 * Launches router
	 */
	public function run(){

		$matcher = new \W\Router\AltoRouter\Matcher($this->router);
		$matcher->match();

	}


	/**
	 * Gets router
	 * @return \AltoRouter The router
	 */
	public function getRouter(){

		return $this->router;

	}


	/**
	 * Gets base path
	 * @return string base path
	 */
	public function getBasePath(){

		return $this->basePath;

	}


	/**
	 * Returns the current route name
	 * @return mixed The route name from \AltoRouter or false
	 */
	public function getCurrentRoute(){

		$route = $this->getRouter()->match();
		if($route){
			return $route['name'];
		}
		else {
			return false;
		}

	}

}
