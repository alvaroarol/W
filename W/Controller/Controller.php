<?php

namespace W\Controller;

use W\Security\AuthentificationModel;
use W\Security\AuthorizationModel;

/**
 * Base controller
 */
class Controller{

	/**
	 * Views path
	 */
	const PATH_VIEWS = '../app/Views';

	/**
	 * Creates URL corresponding to an existing route
	 * @param string $routeName Route name
	 * @param mixed  $params Parameters array
	 * @param boolean $absolute If true, returns an absolute URL
	 * @return string Route URL
	 */
	public static function generateUrl($routeName, $params = array(), $absolute = false){

		$params = (empty($params)) ? array() : $params;

		$app = getApp();
    	$router = $app->getRouter();
    	$routeUrl = $router->generate($routeName, $params);
		$url = $routeUrl;
		if($absolute){
	    	$u = \League\Url\Url::createFromServer($_SERVER);
			$url = $u->getBaseUrl() . $routeUrl;
		}
		return $url;

	}


	/**
	 * Redirect tp a URI
	 * @param string $uri URI
	 */
	public function redirect($uri){

		header("Location: $uri");
		die();

	}


	/**
	 * Redirects to an existing route
	 * @param string $routeName Route name
	 * @param array $params Parameter table
	 */
	public function redirectToRoute($routeName, array $params = array()){

		$uri = $this->generateUrl($routeName, $params);
    	$this->redirect($uri);

	}


	/**
	 * Shows a flash message
	 * @param string $message Message
	 * @param string $level Message level (default, info, success, danger, warning)
	 */
	public function flash($message, $level = 'info'){

		$allowLevel = ['default', 'info', 'success', 'danger', 'warning'];

		if(!in_array($level, $allowLevel)){
			$level = 'info';
		}

		$_SESSION['flash'] = [
			'message' 	=> (!isset($message) || empty($message)) ? 'No message defined' : ucfirst($message),
			'level'	 	=> $level,
		];

		return;

	}


	/**
	 * Displays a view
	 * @param string $file Path to view relative to app/Views/
	 * @param array $data Data array to send to view
	 */
	public function show($file, array $data = array()){

		$engine = new \League\Plates\Engine(self::PATH_VIEWS);

		$engine->loadExtension(new \W\View\Plates\PlatesExtensions());

		// Flash message
		$flash_message = (isset($_SESSION['flash']) && !empty($_SESSION['flash'])) ? (object) $_SESSION['flash'] : null;

		$app = getApp();

		// Data sent to all views
		$engine->addData(
			[
				'w_user' 		  => $this->getUser(),
				'w_current_route' => $app->getCurrentRoute(),
				'w_site_name'	  => $app->getConfig('site_name'),
				'w_flash_message' => $flash_message,
			]
		);

		// Removes ".php" extension
		$file = str_replace('.php', '', $file);

		// Displays view
		echo $engine->render($file, $data);

		// Deletes flash messages after displaying them
		if(isset($_SESSION['flash'])) {
			unset($_SESSION['flash']);
		}
		die();

	}


	/**
	 * Display 403
	 */
	public function showForbidden(){

		header('HTTP/1.0 403 Forbidden');

		$file = self::PATH_VIEWS.'/w_errors/403.php';
		if(file_exists($file)){
			$this->show('w_errors/403');
		}
		else {
			die('403');
		}

	}


	/**
	 * Display 404
	 */
	public function showNotFound(){

		header('HTTP/1.0 404 Not Found');

		$file = self::PATH_VIEWS.'/w_errors/404.php';
		if(file_exists($file)){
			$this->show('w_errors/404');
		}
		else {
			die('404');
		}

	}


	/**
	 * Gets currently connected user
	 */
	public function getUser(){

		$authenticationModel = new AuthentificationModel();
		$user = $authenticationModel->getLoggedUser();
		return $user;

	}


	/**
	 * Authorises access to one or more roles
	 * @param mixed $roles roles array, or string if only one role
	 */
	public function allowTo($roles){

		if (!is_array($roles)){
			$roles = [$roles];
		}
		$authorizationModel = new AuthorizationModel();
		foreach($roles as $role){
			if ($authorizationModel->isGranted($role)){
				return true;
			}
		}

		$this->showForbidden();

	}


	/**
	 * Returns a JSON response to client
	 * @param mixed $data values to return
	 * @return string data in JSON format
	 */
	public function showJson($data){
		
		header('Content-type: application/json');
		$json = json_encode($data, JSON_PRETTY_PRINT);
		if($json){
			die($json);
		}
		else {
			die('Error in json encoding');
		}
	}

}
