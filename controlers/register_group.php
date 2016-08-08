<?php
/**
* @author Hugo Sereni, Leboc Philippe
* @version 1.0
*/
//////////////////////////////////////
//		CONTROLER REGISTER GROUP	//
//////////////////////////////////////
if(!defined("FRONT_CONTROLER"))
{
	throw new Exception();
}
if(!empty($_SESSION['online'])){
	if($_SESSION['type'] == UserType::Secretary){
		// La secretaire doit sélectionner le planing du groupe qu'elle veut voir.
		if(isset($_POST['groupname'])){
			$group_request = htmlspecialchars($_POST['groupname']);
			$group=GroupDAO::create($group_request);
			
			if (!empty($group)){
				require_once VIEW_DIR.'register_group_ok.html';
			}
			else{
				require_once VIEW_DIR.'register_group_fail.html';
			}
		}else{
			require_once(VIEW_DIR.'register_group.html');
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