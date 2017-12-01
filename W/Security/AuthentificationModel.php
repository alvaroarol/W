<?php

namespace W\Security;

use W\Security\StringUtils;
use W\Model\UsersModel;

class AuthentificationModel
{

	/**
	 * Checks if the pair email/username corresponds to the password in the DB
	 * @param string $usernameOrEmail Username or E-mail
	 * @param string $plainPassword Password
	 * @return integer 0 if invalid, the user id if valid
	 */
	public function isValidLoginInfo($usernameOrEmail, $plainPassword){

		$app = getApp();

		$usersModel = new UsersModel();
		$usernameOrEmail = strip_tags(trim($usernameOrEmail));
		$foundUser = $usersModel->getUserByUsernameOrEmail($usernameOrEmail);
		if(!$foundUser){
			return 0;
		}

		if(password_verify($plainPassword, $foundUser[$app->getConfig('security_password_property')])){
			return (int) $foundUser[$app->getConfig('security_id_property')];
		}

		return 0;

	}


	/**
	 * Logs a user in
	 * @param array $user Table with logged in user's infos (except password)
	 */
	public function logUserIn($user){

		$app = getApp();

		// Removes password from infos in $_SESSION
		unset($user[$app->getConfig('security_password_property')]);

		$_SESSION['user'] = $user;

	}


	/**
	 * Logs a user out
	 */
	public function logUserOut(){

		unset($_SESSION['user']);

	}


	/**
	 * Returns data from logged in user
	 * @return mixed Array with user's info, null if not logged in
	 */
	public function getLoggedUser(){

		return (isset($_SESSION['user'])) ? $_SESSION['user'] : null;

	}


	/**
	 * Refreshes user's infos in $_SESSION from DB infos
	 * @return boolean
	 */
	public function refreshUser(){

		$app = getApp();
		$usersModel = new UsersModel();
		$userFromSession = $this->getLoggedUser();
		if ($userFromSession){
			$userFromDb = $usersModel->find($userFromSession[$app->getConfig('security_id_property')]);
			if($userFromDb){
				$this->logUserIn($userFromDb);
				return true;
			}
		}

		return false;

	}


	/**
	 * Hashes password with default algorithm
	 * @param string $plainPassword Password
	 * @return string Hashed password
	 */
	public function hashPassword($plainPassword){

		return password_hash($plainPassword, PASSWORD_DEFAULT);

	}

}
