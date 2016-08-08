<?php
/**
* @author Sereni Hugo
* @version 1.0
*/
//////////////////////////////////////
//		CONTROLER DELETE Group		//
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
			
			if(!empty($group)){
				GroupDAO::delete($group->getName());
				if (!GroupDAO::exist($group_name)){
					require_once VIEW_DIR.'delete_group_ok.html';
				}
				else {
					require_once VIEW_DIR.'delete_group_fail.html';
				}
			}else{
				require_once VIEW_DIR.'delete_group_doesnt_exist.html';
			}
		}else{
			$result=GroupDAO::getAllGroups();
			require_once(VIEW_DIR.'delete_group.html');
		}
	}else{
		require_once(VIEW_DIR.'access_denied.html');
	}
}
else
{
	require_once VIEW_DIR.'not_connected.html';
}
?>