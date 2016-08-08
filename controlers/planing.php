<?php
/**
* @author Leboc Philippe
* @version 1.0
*/
//////////////////////////////////////
//		CONTROLER PLANNING			//
//////////////////////////////////////

if(!defined("FRONT_CONTROLER"))
{
	throw new Exception();
}

if(!empty($_SESSION['online'])){
	//////////////////////////////////////////
	//			Function utilitaire			//
	//////////////////////////////////////////
	function organise($planing){
		// Construction du planing d'une semaine complète (VIDE)
		$semaine = array(
		    DayOfWeek::Monday => array("8" => NULL, "9" => NULL, "10" => NULL, "11" => NULL, "12" => NULL, "13" => NULL, "14" => NULL, "15" => NULL, "16" => NULL, "17" => NULL),
		    DayOfWeek::Tuesday => array("8" => NULL, "9" => NULL, "10" => NULL, "11" => NULL, "12" => NULL, "13" => NULL, "14" => NULL, "15" => NULL, "16" => NULL, "17" => NULL),
		    DayOfWeek::Wednesday => array("8" => NULL, "9" => NULL, "10" => NULL, "11" => NULL, "12" => NULL, "13" => NULL, "14" => NULL, "15" => NULL, "16" => NULL, "17" => NULL),
		    DayOfWeek::Thursday => array("8" => NULL, "9" => NULL, "10" => NULL, "11" => NULL, "12" => NULL, "13" => NULL, "14" => NULL, "15" => NULL, "16" => NULL, "17" => NULL),
		    DayOfWeek::Friday => array("8" => NULL, "9" => NULL, "10" => NULL, "11" => NULL, "12" => NULL, "13" => NULL, "14" => NULL, "15" => NULL, "16" => NULL, "17" => NULL)
		);

		// Remplissage du planing en fonction du jour et de l'heure du cours
		foreach ($planing as $interval) {
			for ($i=$interval->getStartHour(); $i < $interval->getEndHour() ; $i++) { 
				$semaine[$interval->getDay()][$i] = $interval;
			}
		}

		// Affichage de la vue et traitement pour affichage
		require_once(VIEW_DIR.'planing.html');
	}
	//////////////////////////////////////////

	if(!empty($_SESSION['type']) && $_SESSION['type'] !== UserType::Student)
	{
		// La secretaire doit sélectionner le planing du groupe qu'elle veut voir.
		if(isset($_POST['groupname'])){
			$user = NULL;
			$group_name = htmlspecialchars($_POST['groupname']);
			$group = GroupDAO::getGroupByName($group_name);

			
			if($_SESSION['type'] == UserType::Secretary){
				$user = SecretaryDAO::getSecretaryById($_SESSION['id']);
			}else{
				$user = TeacherDAO::getTeacherById($_SESSION['id']);
			}

			if(!empty($user) && !empty($group)){
				
				$planing = $group->getIntervals();
				if(!empty($planing)){
					organise($planing);
				}else{
					require_once VIEW_DIR.'planing_creation_fail.html';
				}
			}else{
				// User == null
				require_once VIEW_DIR.'planing_creation_fail.html';
			}
		}else{
			require_once(VIEW_DIR.'planing_form.html');
		}
	}else{
		// I'm a Student
		// L'étudiant voit le planing de sont groupe directement
		$user = StudentDAO::getStudentById($_SESSION['id']);
		if(!empty($user)){
			$group_name = $user->getGroup();
			$group = GroupDAO::getGroupByName($group_name);
			$planing = $group->getIntervals();
			
			organise($planing);
		}else{
			require_once VIEW_DIR.'fake_user.html';
		}
	}
}
else
{
	require_once VIEW_DIR.'not_connected.html';
}
?>