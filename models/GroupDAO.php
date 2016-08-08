<?php
if(!defined("FRONT_CONTROLER"))
{
	throw new Exception();
}
/**
* @author Leboc Philippe
* @version 1.0
*/
class GroupDAO{

	/**
	* @return l'objet secretaire créé avec les paramètres donnés
	*/
	public static function create($name)
	{
		$group = NULL;

		if(!self::exist($name)){
			$group = new Group($name);
			self::save($group);
		}

		return $group;
	}
	
	/**
	* @return true si l'utilisateur est trouvé, false sinon
	*/
	public static function exist($name){
		$count = 0;

		$stmt = Database::getInstance()->prepare('SELECT count(*) as nbr FROM groups WHERE name=? LIMIT 1');
		$stmt->bindValue(1, $name);
		$stmt->execute();

		if($result = $stmt->fetch())
		{
			$count = $result['nbr'];
		}

		return $count > 0;
	}

	/**
	* @return l'objet group s'il existe, NULL sinon.
	*/
	public static function getGroupByName($groupName)
	{
		$group = NULL;

		$stmt = Database::getInstance()->prepare('SELECT * FROM groups WHERE name=:name LIMIT 1');
		$stmt->bindValue(':name', $groupName);
		$stmt->execute();

		if($result = $stmt->fetch())
		{
			$group = new Group($result['name']);
		}

		if(!empty($group)){
			$intervals = IntervalDAO::getAllIntervalFromGroup($group->getName());
			$group->setIntervals($intervals);
		}
		return $group;
	}

	/**
	* @return void
	* @deprecated unused
	*/
	public static function update($group, $newname)
	{
		$stmt = Database::getInstance()->prepare("UPDATE groups SET name=? WHERE name=?");
		$stmt->bindValue(1, $newname, PDO::PARAM_STR);
		$stmt->bindValue(2, $group->getName(), PDO::PARAM_STR);
		$stmt->execute();
	}

	/**
	* @return void
	*/
	public static function delete($name){
		if(!empty($name)){
			$stmt = Database::getInstance()->prepare("DELETE FROM groups WHERE name=?");
			$stmt->bindValue(1, $name, PDO::PARAM_STR);
			$stmt->execute();
		}
	}

	/**
	* @return void
	*/
	public static function insert($group)
	{
		$stmt = Database::getInstance()->prepare("INSERT INTO groups VALUES(?)");
		$stmt->bindValue(1, $group->getName(), PDO::PARAM_STR);
		$stmt->execute();
	}

	/**
	* @desc Sauvegarde le groupe :
	*		Update le groupe s'il existe déjà.
	*		Insert le groupe s'il n'existait pas déjà.
	*/
	public static function save($group)
	{
		if(!empty($group)){
			if(self::exist($group->getName()))
				self::update($group);
			else
				self::insert($group);
		}
	}

	/**
	* @return array contenant tous les groupes ayants au moins 1 cours
	*/
	public static function getAllNotEmptyGroups(){

		$stmt = Database::getInstance()->prepare("SELECT groups.name FROM groups, intervals WHERE intervals.group_name = groups.name GROUP BY groups.name");
		$stmt->execute();
		$result=$stmt->fetchALL(PDO::FETCH_ASSOC);
		return $result;
	}

	/**
	* @return array contenant tous les groupes
	*/
	public static function getAllGroups(){

		$stmt = Database::getInstance()->prepare("SELECT name FROM groups");
		$stmt->execute();
		$result=$stmt->fetchALL(PDO::FETCH_ASSOC);
		return $result;
	}
}
?>