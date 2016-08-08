<?php
if(!defined("FRONT_CONTROLER"))
{
	throw new Exception();
}

/**
* @author Leboc Philippe
* @version 1.0
*/
abstract class DayOfWeek
{
    const Monday = 0;
    const Tuesday = 1;
    const Wednesday = 2;
    const Thursday = 3;
    const Friday = 4;

    public static function toString($DayOfWeek){
    	$name = NULL;
    	switch ($DayOfWeek) {
    		case 0:
    			$name = "Lundi";
    			break;
    		case 1:
    			$name = "Mardi";
    			break;
    		case 2:
    			$name = "Mercredi";
    			break;
    		case 3:
    			$name = "Jeudi";
    			break;
    		case 4:
    			$name = "Vendredi";
    			break;
    		default:
    			$name = "Error";
    			break;
    	}
    	return $name;
    }
}