<?php
/**
* @author Leboc Philippe
* @version 1.0
*/
//////////////////////////////////////
//			CONTROLER LOGIN			//
//////////////////////////////////////

if(!defined("FRONT_CONTROLER"))
{
	throw new Exception();
}

function queryBuilder($usertype){
	switch($usertype)
	{
		case UserType::Secretary: $table = 'secretaries'; break;
		case UserType::Teacher: $table = 'teachers'; break;
		case UserType::Student: $table = 'students'; break;
		default: $table = 'students'; break;
	}
	return 'SELECT * FROM ' . $table . ' WHERE id=? LIMIT 1';
}

if(empty($_SESSION['online'])){
	if(isset($_POST['id']) && isset($_POST['password']) && isset($_POST['type'])){

		$login = htmlspecialchars($_POST['id']);
		$password = htmlspecialchars($_POST['password']);
		$type = htmlspecialchars($_POST['type']);

		$stmt = Database::getInstance()->prepare(queryBuilder($type));
		$stmt->bindValue(1, $login);
		$stmt->execute();

		if($req = $stmt->fetch()){
			if($password == $req['password']){
				// démarrage de la session
				session_destroy();
				session_unset();
				session_start();

				// Attributs de session
				$_SESSION['online'] = true;

				// avoir l'id permettra de recupérer l'objet $user n'importe quand.
				$_SESSION['id'] = $login;
				$_SESSION['type'] = $type;
			}
		}

		if(isset($_SESSION['online'])){
			require_once VIEW_DIR.'account.html';
		}
		else
		{
			require_once VIEW_DIR.'bad_login.html';
		}
	}
	else
	{
		require_once VIEW_DIR.'missing_field.html';
	}
}
else
{
	require_once VIEW_DIR.'currently_connected.html';
}
?>