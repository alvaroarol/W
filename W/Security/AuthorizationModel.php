<?php

namespace W\Security;

use \W\Session\SessionModel;
use \W\Security\AuthentificationModel;

/**
 * Manages access to pages from user rights
 */
class AuthorizationModel{

	/**
	 * Checks access rights from user role
	 * @param string $role role needed for access
	 * @return boolean true if access granted, false if not
	 */
	public function isGranted($role){

		$app = getApp();
		$roleProperty = $app->getConfig('security_role_property');

		// Gets user infos in $_SESSION
		$authentificationModel = new AuthentificationModel();
		$loggedUser = $authentificationModel->getLoggedUser();

		// If user is not connected, redirect to login page
		if (!$loggedUser){
			$this->redirectToLogin();
		}

		if (!empty($loggedUser[$roleProperty]) && $loggedUser[$roleProperty] === $role){
			return true;
		}

		return false;

	}

	/**
	 * Redirect to login page
	 */
	public function redirectToLogin(){

		$app = getApp();

		$controller = new \W\Controller\Controller();
		$controller->redirectToRoute($app->getConfig('security_login_route_name'));
		
	}

}
