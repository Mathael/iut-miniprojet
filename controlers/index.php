<?php
/**
* @author Leboc Philippe
* @version 1.0
*/
//////////////////////////////////////
//			CONTROLER INDEX			//
//////////////////////////////////////

if(!defined("FRONT_CONTROLER"))
{
	throw new Exception();
}

if(empty($_SESSION['online']))
	require_once('views/index.html');
else
	require_once('views/account.html');
?>