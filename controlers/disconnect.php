<?php
/**
* @author Leboc Philippe
* @version 1.0
*/
//////////////////////////////////////
//		CONTROLER DISCONNECT		//
//////////////////////////////////////

if(!defined("FRONT_CONTROLER"))
{
	throw new Exception();
}

if(!empty($_SESSION['online']))
{
	session_destroy();
	require_once('views/disconnect.html');
}
else
{
	require_once('views/not_connected.html');
}
?>