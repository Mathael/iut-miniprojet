<?php
if(!defined("FRONT_CONTROLER"))
{
	throw new Exception();
}
/**
* @author Leboc Philippe
* @version 1.0
* @desc Sert à la gestion de la base de donnée, c'est une classe statique.
* 
* Utilisation :
* $statement = Database::getInstance()->prepare("SELECT * FROM users WHERE id=? AND ville=? LIMIT ?");
* if($statement) cette ligne est un simple check mais vous pouvez l'omettre.
* {
*   // Il n'est imposé de traiter le bindValue de cette manière.
*	// Le PDO::PARAM_ est optionel mais je vous invite fortement à le mettre.
*	$statement->bindValue(1, 10, PDO::PARAM_INT);			// premier "?"
* 	$statement->bindValue(2, "Grenoble", PDO::PARAM_STR);	// second "?"
*	$statement->bindValue(3, 100, PDO::PARAM_INT);			// dernier "?"
*	$statement->execute();
* }
* Ensuite traité le retour grace à while($resultat = $statement->fetch())
*/
class Database{
	/**
	* Attributs privés
	*/
	private static $_instance = null;

	/**
	* Permet d'avoir une instance UNIQUE pour la connexion à la base de données.
	*/
	public static function getInstance(){
		if(is_null(self::$_instance)){
			try{
				self::$_instance = new PDO('sqlite:database.bd');
				self::$_instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
			}catch(PDOException $e){
				die('Une erreur est survenue lors de l\'initialisation à la base de données : '.$e->getMessage());
			}
		}
		return self::$_instance;
	}
}