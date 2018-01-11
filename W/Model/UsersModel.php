<?php

namespace W\Model;

/**
 * Users model, needed in AuthentificationModel
 */
class UsersModel extends Model{

	/**
	 * Constructor
	 */
	public function __construct(){

		$app = getApp();

		$this->setTable($app->getConfig('security_user_table'));

		$this->setPrimaryKey($app->getConfig('security_id_property'));

		$this->dbh = ConnectionModel::getDbh();

	}


	/**
	 * Get user from e-mail or username
	 * @param string $usernameOrEmail e-mail or username
	 * @return mixed user, false if not found
	 */
	public function getUserByUsernameOrEmail($usernameOrEmail){

		$app = getApp();

		$sql = 'SELECT * FROM ' . $this->table .
			   ' WHERE ' . $app->getConfig('security_username_property') . ' = :username' .
			   ' OR ' . $app->getConfig('security_email_property') . ' = :email LIMIT 1';

		$dbh = ConnectionModel::getDbh();
		$sth = $dbh->prepare($sql);
		$sth->bindValue(':username', $usernameOrEmail);
		$sth->bindValue(':email', $usernameOrEmail);

		if($sth->execute()){
			$foundUser = $sth->fetch();
			if($foundUser){
				return $foundUser;
			}
		}

		return false;

	}


	/**
	* Checks if e-mail is in the DB
	* @param string $email e-mail
	* @return boolean true if in DB, false otherwise
	*/
	public function emailExists($email){

	   $app = getApp();

	   $sql = 'SELECT ' . $app->getConfig('security_email_property') . ' FROM ' . $this->table .
	          ' WHERE ' . $app->getConfig('security_email_property') . ' = :email LIMIT 1';

	   $dbh = ConnectionModel::getDbh();
	   $sth = $dbh->prepare($sql);
	   $sth->bindValue(':email', $email);
	   if($sth->execute()){
	       $foundUser = $sth->fetch();
	       if($foundUser){
	           return true;
	       }
	   }

	   return false;

	}


	/**
	 * Checks if username is in DB
	 * @param string $username username
	 * @return boolean true if in DB, false otherwise
	 */
	public function usernameExists($username){

	    $app = getApp();

	    $sql = 'SELECT ' . $app->getConfig('security_username_property') . ' FROM ' . $this->table .
	           ' WHERE ' . $app->getConfig('security_username_property') . ' = :username LIMIT 1';

	    $dbh = ConnectionModel::getDbh();
	    $sth = $dbh->prepare($sql);
	    $sth->bindValue(':username', $username);
	    if($sth->execute()){
	        $foundUser = $sth->fetch();
	        if($foundUser){
	            return true;
	        }
	    }

	    return false;

	}

}
