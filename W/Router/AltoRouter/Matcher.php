<?php

namespace W\Router\AltoRouter;

class Matcher{

	/**
	 * Looks for a correspondence between the URL and the routes, calls the appropriate page method declared in the route
	 */
	public function match(){

		$router = getApp()->getRouter();
		$match = $router->match();

		if ($match){

			$callableParts = explode('#', $match['target']);
			// Removes the "Controller" suffix
			$controllerName = ucfirst(str_replace('Controller', '', $callableParts[0]));
			$methodName = $callableParts[1];
			$controllerFullName = 'Controller\\'.$controllerName.'Controller';

			$controller = new $controllerFullName();

			// Calls the method with the parameters if any
			call_user_func_array(array($controller, $methodName), $match['params']);
		}
		// 404 if route doesn't exist
		else {
			$controller = new \W\Controller\Controller();
			$controller->showNotFound();
		}

	}

}
