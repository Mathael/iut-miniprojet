<?php
/**
* @author Sereni Hugo
* @version 1.0
*/
//////////////////////////////////////
//		CONTROLER DELETE INTERVAL	//
//////////////////////////////////////

if(!defined("FRONT_CONTROLER"))
{
	throw new Exception();
}
if(!empty($_SESSION['online'])){
	if($_SESSION['type'] == UserType::Secretary){
		// La secretaire doit sélectionner le planing du groupe qu'elle veut voir.
		if(isset($_POST['group'])){
			$user = NULL;
			$group_name = htmlspecialchars($_POST['group']);
			$group = GroupDAO::getGroupByName($group_name);
			$user = SecretaryDAO::getSecretaryById($_SESSION['id']);
			
			if(!empty($user) && !empty($group)){
				$planing = $group->getIntervals();

				if(!empty($planing)&&!isset($_POST['submitted'])){
					require_once(VIEW_DIR.'delete_interval_select.html');
				}else{
					require_once VIEW_DIR.'interval_doesnt_exist.html';
				}
			}else{
				echo "L'utilisateur (ou le groupe) qui tente d'accéder à ces informations n'existe pas...";
			}
		}elseif(isset($_POST['submitted'])){
			foreach ($_POST as $key => $value){
				if ($key !== "submitted"){
					IntervalDAO::delete($value);
				}
				require_once(VIEW_DIR.'delete_interval_ok.html');
			}
		}else{
			$result=GroupDAO::getAllNotEmptyGroups();
			require_once(VIEW_DIR.'delete_interval.html');
		}
	}else{
		require_once VIEW_DIR.'access_denied.html';
	}
}
else
{
	require_once VIEW_DIR.'not_connected.html';
}
?>