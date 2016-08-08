<?php
if(!defined("FRONT_CONTROLER"))
{
	throw new Exception();
}
/**
* @author Leboc Philippe
* @version 1.0
*/
class Secretary extends User
{
	// Constructeur
	public function __construct($id, $password, $lastname, $firstname, $birthdate)
	{
		parent::setId($id);
		parent::setLastname($lastname);
		parent::setFirstname($firstname);
		parent::setPassword($password);
		parent::setBirthdate($birthdate);
	}
}
?>