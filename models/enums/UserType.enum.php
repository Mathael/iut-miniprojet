<?php
if(!defined("FRONT_CONTROLER"))
{
	throw new Exception();
}

/**
* @author Leboc Philippe
* @version 1.0
*/
abstract class UserType
{
    const Secretary = "Secretarie";
    const Teacher = "Teacher";
    const Student = "Student";

    public static function toString($UserType){
		$name = NULL;
		switch ($UserType) {
			case 'Secretarie':
				$name = "Secretaire";
				break;
			case 'Teacher':
				$name = "Professeur";
				break;
			case 'Student':
				$name = "Étudiant";
				break;
			default:
				$name = "Error";
				break;
		}
		return $name;
    }

    public static function enumerate($var){
    	$res = NULL;
    	switch ($var) {
    		case 'Secretaire':
    			$res = UserType::Secretary;
    			break;
    		case 'Étudiant':
    			$res = UserType::Student;
    			break;
    		case 'Professeur':
    			$res = UserType::Teacher;
    			break;
    		default:
    			break;
    	}
    	return $res;
    }
}