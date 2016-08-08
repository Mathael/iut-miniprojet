<?php
if(!defined("FRONT_CONTROLER"))
{
	throw new Exception();
}

/**
* @author Leboc Philippe
* @version 1.0
*/
class IntervalDAO{

	/**
	* @return l'objet Interval (crénaux horaire) créé avec les paramètres donnés
	*/
	public static function create($name, $start, $end, $day, $teacher, $group)
	{
		$interval = new Interval(self::getNextId(), $name, $start, $end, $day, $teacher, $group);
		
		if(!empty($interval)){
			self::save($interval);
		}

		return $interval;
	}
	
	/**
	* @return true si l'interval est trouvé, false sinon
	*/
	public static function exist($id){
		$count = 0;

		$stmt = Database::getInstance()->prepare('SELECT count(*) as nbr FROM intervals WHERE id=? LIMIT 1');
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
		$stmt = Database::getInstance()->prepare('SELECT id FROM intervals ORDER BY id DESC LIMIT 1');
		$stmt->execute();

		if($result = $stmt->fetch())
		{
			$value = $result['id']+1;
		}

		return $value;
	}

	/**
	* @return true s'il n'y a pas d'interférence pour placer un nouveau cours sur une tranche horaire du planing du groupe $group le jour $day
	*/
	public static function isFree($day, $start, $end, $group){
		$count = 0;

		$stmt = Database::getInstance()->prepare('SELECT count(*) as nbr FROM intervals WHERE (start_hour=:start AND end_hour=:end AND day=:day AND group_name=:group) OR (start_hour <= :start AND start_hour < :end AND end_hour > :start AND end_hour >= :end AND day=:day AND group_name=:group) OR (start_hour >= :start AND start_hour < :end AND end_hour > :start AND end_hour >= :end AND day=:day AND group_name=:group) OR (start_hour <= :start AND start_hour < :end AND end_hour > :start  AND end_hour <= :end AND day=:day AND group_name=:group) OR (start_hour >= :start AND start_hour < :end AND end_hour > :start AND end_hour <= :end AND day=:day AND group_name=:group) LIMIT 1');
		$stmt->bindValue(":start", $start);
		$stmt->bindValue(":end", $end);
		$stmt->bindValue(":day", $day);
		$stmt->bindValue(":group", $group);
		$stmt->execute();

		if($result = $stmt->fetch())
		{
			$count = $result['nbr'];
		}

		return $count == 0;
	}

	/**
	* @return l'objet Interval
	*/
	public static function getInterval($id)
	{
		$interval = NULL;

		$stmt = Database::getInstance()->prepare('SELECT * FROM intervals WHERE id=:id LIMIT 1');
		$stmt->bindValue(':id', $id);
		$stmt->execute();

		if($result = $stmt->fetch())
		{
			$interval = new Interval($result['id'], $result['name'], $result['start_hour'], $result['end_hour'], $result['day'], $result['teacher_id'], $result['group_name']);
		}

		return $interval;
	}

	/**
	* @return un array contenant tout les objets Interval du groupe $name
	*/
	public static function getAllIntervalFromGroup($name){
		$data = array();

		if(!empty($name)){
			$stmt = Database::getInstance()->prepare('SELECT * FROM intervals WHERE group_name=?');
			$stmt->bindValue(1, $name);
			$stmt->execute();

			while($result = $stmt->fetch()){
				$interval = new Interval($result['id'], $result['name'], $result['start_hour'], $result['end_hour'], $result['day'], $result['teacher_id'], $result['group_name']);
				array_push($data, $interval);
			}
		}

		return $data;
	}

	/**
	* @return l'objet Interval
	* @deprecated Cette méthode n'est pas à utiliser. Elle sert uniquement de test.
	*/
	public static function getAllPlaning()
	{
		$data = array();
		$stmt = Database::getInstance()->prepare('SELECT * FROM intervals ORDER BY day, start_hour ASC');
		$stmt->execute();
		
		while($result = $stmt->fetch())
		{
			$interval = new Interval($result['id'], $result['name'], $result['start_hour'], $result['end_hour'], $result['day'], $result['teacher_id'], $result['group_name']);
			if(!empty($interval)){
				array_push($data, $interval);
			}
		}

		return $data;
	}

	/**
	* @return void
	*/
	public static function update($interval)
	{
		if(!empty($interval)){
			$stmt = Database::getInstance()->prepare("UPDATE intervals SET name=?, start=?, end=?, day=? teacher_id=?, group_name=? WHERE id=?");
			$stmt->bindValue(1, $interval->getName(), PDO::PARAM_STR);
			$stmt->bindValue(2, $interval->getStartHour(), PDO::PARAM_INT);
			$stmt->bindValue(3, $interval->getEndHour(), PDO::PARAM_INT);
			$stmt->bindValue(4, $interval->getDay(), PDO::PARAM_INT);
			$stmt->bindValue(5, $interval->getTeacher(), PDO::PARAM_INT);
			$stmt->bindValue(6, $interval->getGroup(), PDO::PARAM_STR);
			$stmt->bindValue(7, $interval->getId(), PDO::PARAM_INT);
			$stmt->execute();
		}
	}

	/**
	* @return void
	*/
	public static function delete($interval){
		if(!empty($interval)){
			$stmt = Database::getInstance()->prepare("DELETE FROM intervals WHERE id=?");
			$stmt->bindValue(1, $interval);
			$stmt->execute();
		}
	}

	/**
	* @return void
	*/
	public static function insert($interval)
	{
		if(!empty($interval)){
			$stmt = Database::getInstance()->prepare("INSERT INTO intervals VALUES(?, ?, ?, ?, ?, ?, ?)");
			$stmt->bindValue(1, $interval->getId(), PDO::PARAM_INT);
			$stmt->bindValue(2, $interval->getName(), PDO::PARAM_STR);
			$stmt->bindValue(3, $interval->getStartHour(), PDO::PARAM_INT);
			$stmt->bindValue(4, $interval->getEndHour(), PDO::PARAM_INT);
			$stmt->bindValue(5, $interval->getDay(), PDO::PARAM_INT);
			$stmt->bindValue(6, $interval->getTeacher(), PDO::PARAM_INT);
			$stmt->bindValue(7, $interval->getGroup(), PDO::PARAM_STR);
			$stmt->execute();
		}
	}

	/**
	* @desc Sauvegarde le groupe :
	*		Update le groupe s'il existe déjà.
	*		Insert le groupe s'il n'existait pas déjà.
	* @return void
	*/
	public static function save($interval)
	{
		if(!empty($interval)){
			if(self::exist($interval->getId()))
				self::update($interval);
			else
				self::insert($interval);
		}
	}
}
?>