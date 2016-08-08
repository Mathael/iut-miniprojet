<?php
if(!defined("FRONT_CONTROLER"))
{
	throw new Exception();
}
/**
* @author Leboc Philippe
* @version 1.0
*/
class Group{

	// Attributs privés
	private $_name;			// String
	private $_members;		// Array de Class User
	private $_intervals;	// Array de Class Interval

	// Constructeur
	public function __construct($name)
	{
		self::setName($name);
		self::setMembers(array());
		self::setIntervals(array());
	}

	// Getters & Setters
	public function getName(){
		return $this->_name;
	}

	public function getMembers(){
		return $this->_members;
	}

	public function getIntervals(){
		return $this->_intervals;
	}

	private function setName($value){
		$this->_name = $value;
	}

	public function setMembers($array){
		$this->_members = $array;
	}

	public function setIntervals($array){
		$this->_intervals = $array;
	}

	// Methodes

	/**
	* @return true si l'operation s'est bien passée, false sinon
	*/
	public function addMember($member){
		$success = false;

		if(!empty($member) && !in_array($member, $this->getMembers())){
			$array = self::getMembers(); // copie des membres existants
			array_push($array, $member); // ajouts du nouveau à la fin
			self::setMembers($array);	 // modification des membres existants
			$success = true;
		}
		return $success;
	}

	/**
	* @return true si l'operation s'est bien passée, false sinon
	*/
	public function addInterval($interval){
		$success = false;

		if(!empty($interval) && !in_array($interval, $this->getMembers())){
			$intervals = $this->getIntervals();
			array_push($intervals, $interval);
			self::setIntervals($intervals);
			$success = true;
		}
		return $success;
	}

	/**
	* @return void
	*/
	public function removeMember($member){
		$success = false;
		if(!empty($member)){
			
			$updatedArray = array();

			foreach ($this->getMembers() as $currentMember) {
				if($currentMember !== $member)
				{
					array_push($updatedArray, $currentMember);
				}
			}

			$this->setMembers($updatedArray);
			$success = true;
		}
		return $success;
	}
}
?>