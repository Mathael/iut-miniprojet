<?php
if(!defined("FRONT_CONTROLER"))
{
	throw new Exception();
}
/**
* @author Leboc Philippe
* @version 1.0
*/
class StudentDAO{

	/**
	* @return l'objet secretaire créé avec les paramètres donnés
	*/
	public static function create($password, $lastname, $firstname, $birthdate, $group)
	{
		$student = new Student(self::getNextId(), $password, $lastname, $firstname, $birthdate, $group);
		
		if(!empty($student)){
			self::save($student);
		}
		return $student;
	}
	
	/**
	* @return true si l'utilisateur est trouvé, false sinon
	*/
	public static function exist($id){
		$count = 0;

		$stmt = Database::getInstance()->prepare('SELECT count(*) as nbr FROM students WHERE id=? LIMIT 1');
		$stmt->bindValue(1, $id);
		$stmt->execute();

		if($result = $stmt->fetch())
		{
			$count = $result['nbr'];
		}

		return $count > 0;
	}

	/**
	* @return le prochain id utilisatable.
	*/
	public static function getNextId()
	{
		$value = -1;

		$stmt = Database::getInstance()->prepare('SELECT id FROM students ORDER BY id DESC LIMIT 1');
		$stmt->execute();

		if($result = $stmt->fetch())
		{
			$value = $result['id']+1;
		}
		return $value;
	}

	/**
	* @return l'objet étudiant dont l'id est $value
	*/
	public static function getStudentById($value)
	{
		$student = NULL;

		$stmt = Database::getInstance()->prepare('SELECT * FROM students WHERE id=:id');
		$stmt->bindValue(':id', $value);
		$stmt->execute();

		if($result = $stmt->fetch())
		{
			$student = new Student($result['id'], $result['password'], $result['last_name'], $result['first_name'], $result['birth_date'], $result['group_name']);
		}

		return $student;
	}

	/**
	* @return tous les étudiants du groupe dont le nom est donné en paramètre
	*/
	public static function getAllStudentsFromGroup($groupName){

		$data = array();

		if(!empty($groupName)){
			$stmt = Database::getInstance()->prepare('SELECT id FROM students WHERE group_name=?');
			$stmt->bindValue(1, $groupName);
			$stmt->execute();

			while($res = $stmt->fetch()){
				$student = self::getStudentById($res['id']);
				array_push($data, $student);
			}
		}

		return $data;
	}

	/**
	* @return tous les étudiants du groupe dont le nom est donné en paramètre
	*/
	public static function getAllStudents(){

		$data = array();

		$stmt = Database::getInstance()->prepare('SELECT * FROM students ORDER BY last_name ASC');
		$stmt->execute();

		while($res = $stmt->fetch()){
			$data[] = new Student($res['id'], $res['password'], $res['last_name'], $res['first_name'], $res['birth_date'], $res['group_name']);
		}

		return $data;
	}
	
	/**
	* @return void
	*/
	public static function update($id, $lastname, $firstname, $birthdate, $group)
	{
		$stmt = Database::getInstance()->prepare('UPDATE students SET last_name=?, first_name=?, birth_date=?, group_name=? WHERE id=?');
		$stmt->bindValue(1, $lastname, PDO::PARAM_STR);
		$stmt->bindValue(2, $firstname, PDO::PARAM_STR);
		$stmt->bindValue(3, $birthdate, PDO::PARAM_STR);
		$stmt->bindValue(4, $group, PDO::PARAM_STR);
		$stmt->bindValue(5, $id, PDO::PARAM_INT);
		$stmt->execute();
	}

	/**
	* @return void
	*/
	public static function delete($id){
		if(!empty($id)){
			$stmt = Database::getInstance()->prepare("DELETE FROM students WHERE id=?");
			$stmt->bindValue(1, $id, PDO::PARAM_INT);
			$stmt->execute();
		}
	}

	/**
	* @return void
	*/
	public static function insert($student)
	{
		if(!empty($student)){
			$stmt = Database::getInstance()->prepare("INSERT INTO students VALUES(?, ?, ?, ?, ?, ?)");
			$stmt->bindValue(1, $student->getId(), PDO::PARAM_INT);
			$stmt->bindValue(2, $student->getLastname(), PDO::PARAM_STR);
			$stmt->bindValue(3, $student->getFirstname(), PDO::PARAM_STR);
			$stmt->bindValue(4, $student->getPassword(), PDO::PARAM_STR);
			$stmt->bindValue(5, $student->getBirthdate(), PDO::PARAM_STR);
			$stmt->bindValue(6, $student->getGroup(), PDO::PARAM_STR);
			$stmt->execute();
		}
	}

	/**
	* @desc Sauvegarde l'étudiant :
	*		Update l'étudiant s'il existe déjà.
	*		Insert l'étudiant s'il n'existait pas déjà.
	* @return void
	*/
	public static function save($student)
	{
		if(!empty($student)){
			if(self::exist($student->getId()))
				self::update($student);
			else
				self::insert($student);
		}
	}
}
?>