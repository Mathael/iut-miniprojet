<?php
if(!defined("FRONT_CONTROLER"))
{
	throw new Exception();
}
/**
* @author Leboc Philippe
* @version 1.0
*/
class TeacherDAO{
	/**
	* @return l'objet Teacher créé avec les paramètres donnés
	*/
	public static function create($password, $lastname, $firstname, $birthdate)
	{
		$teacher = new Teacher(self::getNextId(), $password, $lastname, $firstname, $birthdate);

		if(!empty($teacher)){
			self::save($teacher);
		}

		return $teacher;
	}

	/**
	* @return true si l'utilisateur est trouvé, false sinon
	*/
	public static function exist($id){
		$count = 0;

		$stmt = Database::getInstance()->prepare('SELECT count(*) as nbr FROM teachers WHERE id=? LIMIT 1');
		$stmt->bindValue(1, $id);
		$stmt->execute();

		if($result = $stmt->fetch())
		{
			$count = $result['nbr'];
		}

		return $count > 0;
	}

	/**
	* @return le prochain id utilisatable
	*/
	public static function getNextId()
	{
		$res = -1;
		$stmt = Database::getInstance()->prepare('SELECT id FROM teachers ORDER BY id DESC LIMIT 1');
		$stmt->execute();

		if($result = $stmt->fetch())
		{
			$res = $result['id']+1;
		}

		return $res;
	}

	/**
	* @return l'objet Teacher dont l'id est $value
	*/
	public static function getTeacherById($value)
	{
		$teacher = NULL;
		$stmt = Database::getInstance()->prepare('SELECT * FROM teachers WHERE id=:id');
		$stmt->bindValue(':id', $value);
		$stmt->execute();

		if($result = $stmt->fetch())
		{
			$teacher = new Teacher($result['id'], $result['password'], $result['last_name'], $result['first_name'], $result['birth_date']);
		}

		return $teacher;
	}

	/**
	* @return void
	*/
	public static function update($id, $lastname, $firstname, $birthdate)
	{
		$stmt = Database::getInstance()->prepare("UPDATE teachers SET last_name=?, first_name=?, birth_date=? WHERE id=?");
		$stmt->bindValue(1, $lastname, PDO::PARAM_STR);
		$stmt->bindValue(2, $firstname, PDO::PARAM_STR);
		$stmt->bindValue(3, $birthdate, PDO::PARAM_STR);
		$stmt->bindValue(4, $id, PDO::PARAM_INT);
		$stmt->execute();
	}

	/**
	* @return void
	*/
	public static function delete($id){
		if(!empty($id)){
			$stmt = Database::getInstance()->prepare("DELETE FROM teachers WHERE id=?");
			$stmt->bindValue(1, $id, PDO::PARAM_INT);
			$stmt->execute();
		}
	}

	/**
	* @return void
	*/
	public static function insert($Teacher)
	{
		if(!empty($Teacher)){
			$stmt = Database::getInstance()->prepare("INSERT INTO teachers VALUES(?, ?, ?, ?, ?)");
			$stmt->bindValue(1, $Teacher->getId(), PDO::PARAM_INT);
			$stmt->bindValue(2, $Teacher->getLastname(), PDO::PARAM_STR);
			$stmt->bindValue(3, $Teacher->getFirstname(), PDO::PARAM_STR);
			$stmt->bindValue(4, $Teacher->getPassword(), PDO::PARAM_STR);
			$stmt->bindValue(5, $Teacher->getBirthdate(), PDO::PARAM_STR);
			$stmt->execute();
		}
	}

	/**
	* @desc Sauvegarde l'étudiant :
	*		Update l'étudiant s'il existe déjà.
	*		Insert l'étudiant s'il n'existait pas déjà.
	* @return void
	*/
	public static function save($Teacher)
	{
		if(!empty($Teacher)){
			if(self::exist($Teacher->getId()))
				self::update($Teacher);
			else
				self::insert($Teacher);
		}
	}

	public static function getAllteachers(){
		$stmt = Database::getInstance()->prepare("SELECT * FROM teachers");
		$stmt->execute();
		$result=$stmt->fetchALL(PDO::FETCH_ASSOC);
		return $result;
	}

	/**
	* @return array() contenant tout les professeur
	* @descr La fonction getAllteachers pose un soucis
	*/
	public static function getAllTeachersDebug()
	{
		$data = array();
		$stmt = Database::getInstance()->prepare('SELECT * FROM teachers ORDER BY last_name ASC');
		$stmt->execute();

		while($result = $stmt->fetch())
		{
			$data[] = new Teacher($result['id'], $result['password'], $result['last_name'], $result['first_name'], $result['birth_date']);
		}
		
		return $data;
	}
}
?>