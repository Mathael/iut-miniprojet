<?php
if(!defined("FRONT_CONTROLER"))
{
	throw new Exception();
}
/**
* @author Leboc Philippe
* @version 1.0
*/

class Student extends User
{
	// Attributs
	private $_group;

	// Constructeur
	public function __construct($id, $password, $lastname, $firstname, $birthdate, $group)
	{
		parent::setId($id);
		parent::setLastname($lastname);
		parent::setFirstname($firstname);
		parent::setPassword($password);
		parent::setBirthdate($birthdate);
		
		self::setGroup($group);
	}

	// Getters
	public function getGroup(){
		return $this->_group;
	}

	// Setters
	private function setGroup($group){
		$this->_group = $group;
	}
}
?>