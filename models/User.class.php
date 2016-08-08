<?php
if(!defined("FRONT_CONTROLER"))
{
	throw new Exception();
}
/**
* @author Leboc Philippe
* @version 1.0
*/
abstract class User
{
	// Attributs
	private $_id;			// Integer
	private $_password;		// String
	private $_lastname;		// String (nom)
	private $_firstname;	// String (prénom)
	private $_birthdate;	// Date

	// Constructeur
	public function __construct($id, $password, $lastname, $firstname, $birthdate, $group)
	{
		setId($id);
		setPassword($password);
		setLastname($lastname);
		setFirstName($firstname);
		setBirthdate($birthdate);
	}

	// Getters
	public function getId(){
		return $this->_id;
	}

	public function getPassword()
	{
		return $this->_password;
	}

	public function getLastname()
	{
		return $this->_lastname;
	}

	public function getFirstname()
	{
		return $this->_firstname;
	}

	public function getBirthdate()
	{
		return $this->_birthdate;
	}

	// Setters
	protected function setId($value){
		$this->_id = $value;
	}

	protected function setPassword($value)
	{
		$this->_password = $value;
	}

	protected function setLastname($value)
	{
		$this->_lastname = $value;
	}

	protected function setFirstname($value)
	{
		$this->_firstname = $value;
	}

	protected function setBirthdate($value)
	{
		$this->_birthdate = $value;
	}
}
?>