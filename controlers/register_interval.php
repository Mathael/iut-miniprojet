<?php
/**
* @author Leboc Philippe
* @version 1.0
*/
//////////////////////////////////////
//	REGISTER INTERVAL PLANNING		//
//////////////////////////////////////

if(!defined("FRONT_CONTROLER"))
{
	throw new Exception();
}
if(!empty($_SESSION['online'])){
	if($_SESSION['type'] == UserType::Secretary){
		if(isset($_POST['module']) && isset($_POST['startHour']) && isset($_POST['endHour']) && isset($_POST['teacher']) && isset($_POST['group']) && isset($_POST['day'])){
			$module = htmlspecialchars($_POST['module']);
			$startHour = htmlspecialchars($_POST['startHour']);
			$endHour = htmlspecialchars($_POST['endHour']);
			$teacher = htmlspecialchars($_POST['teacher']);
			$group = htmlspecialchars($_POST['group']);
			$day = htmlspecialchars($_POST['day']);

			// On vérifie bien que les données entrées sont exacte
			$check_teacher = TeacherDAO::exist($teacher);
			$check_group = GroupDAO::exist($group);
			$check_module = IntervalDAO::isFree($day, $startHour, $endHour, $group);

			if($check_module && $check_group && $check_teacher){

				// Il y a de la place, on peut alors créer un cours sur l'interval donné
				$interval = IntervalDAO::create($module, $startHour, $endHour, $day, $teacher, $group);
				if(!empty($interval)){
					// Tout s'est bien passé.
					require_once(VIEW_DIR.'interval_creation_ok.html');
				}else{
					require_once(VIEW_DIR.'interval_creation_fail.html');
				}
			}else{
				require_once VIEW_DIR.'interval_creation_fail.html';
			}
		}else{
			require_once(VIEW_DIR.'register_interval.html');
		}
	}else{
		require_once(VIEW_DIR.'access_denied.html');
	}
}
else
{
	require_once VIEW_DIR.'not_connected.html';
}