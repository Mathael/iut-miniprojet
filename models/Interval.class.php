<?php
if(!defined("FRONT_CONTROLER"))
{
	throw new Exception();
}
/**
* @author Leboc Philippe
* @version 1.0
*/
class Interval{

	// Attributs privés
	private $_id;
	private $_name;			// String
	private $_start_hour;	// Integer
	private $_end_hour;		// Integer
	private $_day;			// Enumeration (Integer)
	private $_teacher;		// Integer
	private $_group;		// String

	// Constructeur
	public function __construct($id, $name, $start, $end, $day, $teacher, $group){
		self::setId($id);
		self::setName($name);
		self::setStartHour($start);
		self::setEndHour($end);
		self::setDay($day);
		self::setTeacher($teacher);
		self::setGroup($group);
	}

	// Getters & Setters
	public function getId(){
		return $this->_id;
	}

	public function getName(){
		return $this->_name;
	}

	public function getStartHour(){
		return $this->_start_hour;
	}

	public function getEndHour(){
		return $this->_end_hour;
	}

	public function getDay(){
		return $this->_day;
	}

	public function getTeacher(){
		return $this->_teacher;
	}

	public function getGroup(){
		return $this->_group;
	}

	private function setId($value){
		$this->_id = $value;
	}

	private function setName($value){
		$this->_name = $value;
	}

	private function setStartHour($value){
		$this->_start_hour = $value;
	}

	private function setEndHour($value){
		$this->_end_hour = $value;
	}

	private function setDay($value){
		$this->_day = $value;
	}

	private function setTeacher($value){
		$this->_teacher = $value;
	}

	private function setGroup($value){
		$this->_group = $value;
	}
}
?>