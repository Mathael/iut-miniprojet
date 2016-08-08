<?php
/**
* @author Hugo Sereni, Leboc Philippe
* @version 1.0
*/
//////////////////////////////////////
//		CONTROLER REGISTER MEMBER	//
//////////////////////////////////////

if(!defined("FRONT_CONTROLER"))
{
	throw new Exception();
}

if(!empty($_SESSION['online'])){
	if($_SESSION['type'] === UserType::Secretary){
		if (!isset($_POST['submitted'])){
			require_once(VIEW_DIR.'register.html');
		}else{
			$group_type = htmlspecialchars($_POST['type']);
			$password = htmlspecialchars($_POST['password']);
			$lastname = htmlspecialchars($_POST['nom']);
			$firstname = htmlspecialchars($_POST['prenom']);
			$date = htmlspecialchars($_POST['date']);
			$group_name = htmlspecialchars($_POST['group']);

			if (!isset($_POST['submitted'])){
					require_once(VIEW_DIR.'register.html');
			}else{
				$user = NULL;
				
				if($group_type == UserType::Student){
					$user = StudentDAO::create($password, $lastname, $firstname, $date, $group_name);
				}elseif($group_type == UserType::Teacher){
					$user = TeacherDAO::create($password,$lastname,$firstname,$date);
				}elseif($group_type == UserType::Secretary){
					$user = SecretaryDAO::create($password,$lastname,$firstname,$date);
				}

				if(!empty($user)){
					$id = $user->getId();
					require_once(VIEW_DIR.'user_creation_ok.html');
				}else{
					require_once VIEW_DIR.'user_creation_fail.html';
				}
			}
		}
	}else{
		require_once(VIEW_DIR.'access_denied.html');
	}
}else{
	require_once VIEW_DIR.'not_connected.html';
}
?>

