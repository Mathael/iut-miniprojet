<?php
/**
* @author Leboc Philippe
* @version 1.0
*/
//////////////////////////////////////
//		CONTROLER MODIFY USER		//
//////////////////////////////////////

if(!defined("FRONT_CONTROLER"))
{
	throw new Exception();
}

if(!empty($_SESSION['online'])){
	if($_SESSION['type'] == UserType::Secretary){

		if(isset($_POST['type']) && isset($_POST['login'])){
			// traitement des données reçues
			$type = htmlspecialchars($_POST['type']);
			$id = htmlspecialchars($_POST['login']);
			$user = NULL;

			switch($type){
				case UserType::Student:
					$user = StudentDAO::getStudentById($id);
					break;
				case UserType::Teacher:
					$user = TeacherDAO::getTeacherById($id);
					break;
				case UserType::Secretary:
					$user = SecretaryDAO::getSecretaryById($id);
					break;
				default:
					$user = NULL;
					break;
			}

			if(!empty($user)){
				require_once VIEW_DIR.'form_user_modify.html';
			}else{
				require_once VIEW_DIR.'user_doesnt_exist.html';
			}
		}elseif(isset($_POST['submitted'])){
			if(!empty($_POST['id']) && !empty($_POST['lastname']) && !empty($_POST['firstname']) && !empty($_POST['date']) && !empty($_POST['type']))
			{
				// traitement des données reçues (traitement non complet évidement...)
				$id = htmlspecialchars($_POST['id']);
				$lastname = htmlspecialchars($_POST['lastname']);
				$firstname = htmlspecialchars($_POST['firstname']);
				$birthdate = htmlspecialchars($_POST['date']);
				$type = htmlspecialchars($_POST['type']);

				$success = FALSE;
				
				switch(UserType::enumerate($type)){
					case UserType::Student:
					{
						$group = htmlspecialchars($_POST['group']);
						// TODO: Check de l'existance du groupe
						StudentDAO::update($id, $lastname, $firstname, $birthdate, $group);
						$success = TRUE;
						break;
					}
					case UserType::Secretary:
					{
						SecretaryDAO::update($id, $lastname, $firstname, $birthdate);
						$success = TRUE;
						break;
					}
					case UserType::Teacher:
					{
						TeacherDAO::update($id, $lastname, $firstname, $birthdate);
						$success = TRUE;
						break;
					}
					default:
						break;
				}
				
				if($success){
					require_once VIEW_DIR.'modify_user_ok.html';
				}else{
					require_once VIEW_DIR.'modify_user_fail.html';
				}
			}
			else
			{
				require_once VIEW_DIR.'modify_user_data_missing.html';
			}
		}else{
			require_once VIEW_DIR.'form_select_user_to_modify.html';
		}
	}else{
		require_once VIEW_DIR.'access_denied.html';
	}
}
else
{
	require_once VIEW_DIR.'access_denied.html';
}