<?php
if(!defined("FRONT_CONTROLER"))
{
	throw new Exception();
}
/**
* @author Leboc Philippe
* @version 1.0
*/
class SecretaryDAO{
	/**
	* @return l'objet secretaire créé avec les paramètres donnés
	*/
	public static function create($password, $lastname, $firstname, $birthdate)
	{
		$secretary = new Secretary(self::getNextId(), $password, $lastname, $firstname, $birthdate);

		if(!empty($secretary)){
			self::save($secretary);
		}

		return $secretary;
	}
	
	/**
	* @return true si l'utilisateur est trouvé, false sinon
	*/
	public static function exist($id){
		$count = 0;

		$stmt = Database::getInstance()->prepare('SELECT count(*) as nbr FROM secretaries WHERE id=? LIMIT 1');
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
		$stmt = Database::getInstance()->prepare('SELECT id FROM secretaries ORDER BY id DESC LIMIT 1');
		$stmt->execute();

		if($result = $stmt->fetch())
		{
			$value = $result['id']+1;
		}

		return $value;
	}

	/**
	* @return l'objet secretary dont l'id est $value
	*/
	public static function getSecretaryById($value)
	{
		$secretary = NULL;
		$stmt = Database::getInstance()->prepare('SELECT * FROM secretaries WHERE id=:id');
		$stmt->bindValue(':id', $value);
		$stmt->execute();

		if($result = $stmt->fetch())
		{
			$secretary = new Secretary($result['id'], $result['password'], $result['last_name'], $result['first_name'], $result['birth_date']);
		}

		return $secretary;
	}

	/**
	* @return array() contenant toutes les secretaires
	*/
	public static function getAllSecretaries()
	{
		$data = array();
		$stmt = Database::getInstance()->prepare('SELECT * FROM secretaries ORDER BY last_name ASC');
		$stmt->execute();

		while($result = $stmt->fetch())
		{
			$data[] = new Secretary($result['id'], $result['password'], $result['last_name'], $result['first_name'], $result['birth_date']);
		}
		
		return $data;
	}

	/**
	* @return void
	*/
	public static function update($id, $lastname, $firstname, $birthdate)
	{
		$stmt = Database::getInstance()->prepare("UPDATE secretaries SET last_name=?, first_name=?, birth_date=? WHERE id=?");
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
			$stmt = Database::getInstance()->prepare("DELETE FROM secretaries WHERE id=?");
			$stmt->bindValue(1, $id, PDO::PARAM_INT);
			$stmt->execute();
		}
	}

	/**
	* @return void
	*/
	public static function insert($secretary)
	{
		$stmt = Database::getInstance()->prepare("INSERT INTO secretaries VALUES(?, ?, ?, ?, ?)");
		$stmt->bindValue(1, $secretary->getId(), PDO::PARAM_INT);
		$stmt->bindValue(2, $secretary->getLastname(), PDO::PARAM_STR);
		$stmt->bindValue(3, $secretary->getFirstname(), PDO::PARAM_STR);
		$stmt->bindValue(4, $secretary->getPassword(), PDO::PARAM_STR);
		$stmt->bindValue(5, $secretary->getBirthdate(), PDO::PARAM_STR);
		$stmt->execute();
	}

	/**
	* @desc Sauvegarde l'étudiant :
	*		Update l'étudiant s'il existe déjà.
	*		Insert l'étudiant s'il n'existait pas déjà.
	*/
	public static function save($secretary)
	{
		if(!empty($secretary)){
			if(self::exist($secretary->getId()))
				self::update($secretary);
			else
				self::insert($secretary);
		}
	}
}
?>