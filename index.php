<?php session_start(); ?>
<!DOCTYPE html>
<html lang="fr">
	<head>
		<title>Mini Projet - PHP</title>
		<meta charset="utf-8"/>
		<link href="css/default.css" rel="stylesheet" type="text/css" />
	</head>
	<body>
		<?php
		//////////////////////////////////////
		//			FRONT CONTROLER			//
		//////////////////////////////////////

		// Affichage des erreurs
		ini_set('display_errors',1);
		ini_set('display_startup_errors',1);
		error_reporting(E_ALL | E_STRICT);

		// Définitions
		define('PROJECT_DIR', realpath('./'));
		define("FRONT_CONTROLER", "Yes I'm coming from front controler !");
		define("CONTROLER_DIR", PROJECT_DIR."/controlers/");
		define("MODEL_DIR", PROJECT_DIR."/models/");
		define("ENUM_DIR", PROJECT_DIR."/models/enums/");
		define("VIEW_DIR", PROJECT_DIR."/views/");

		// Enum
		require_once ENUM_DIR.'DayOfWeek.enum.php';
		require_once ENUM_DIR.'UserType.enum.php';

		// Objects
		require_once MODEL_DIR.'Database.class.php';
		require_once MODEL_DIR.'User.class.php';
		require_once MODEL_DIR.'Student.class.php';
		require_once MODEL_DIR.'Secretary.class.php';
		require_once MODEL_DIR.'Teacher.class.php';
		require_once MODEL_DIR.'Group.class.php';
		require_once MODEL_DIR.'Interval.class.php';

		// DAO
		require_once MODEL_DIR.'StudentDAO.php';
		require_once MODEL_DIR.'TeacherDAO.php';
		require_once MODEL_DIR.'SecretaryDAO.php';
		require_once MODEL_DIR.'GroupDAO.php';
		require_once MODEL_DIR.'IntervalDAO.php';
		
		// Vue constante sur le menu
		require_once VIEW_DIR.'menu.html';

		isset($_GET['action']) ? $action = htmlspecialchars($_GET['action']) : $action = 'index';

		switch($action){
			case 'index':
				require_once(CONTROLER_DIR.'index.php');
				break;
			case 'login':
				require_once(CONTROLER_DIR.'login.php');
				break;
			case 'planing':
				require_once(CONTROLER_DIR.'planing.php');
				break;
			case 'disconnect':
				require_once(CONTROLER_DIR.'disconnect.php');
				break;
			case 'register':
				require_once(CONTROLER_DIR.'register.php');
				break;
			case 'register-interval':
				require_once(CONTROLER_DIR.'register_interval.php');
				break;
			case 'delete_interval':
				require_once(CONTROLER_DIR.'delete_interval.php');
				break;
			case 'register_group':
				require_once(CONTROLER_DIR.'register_group.php');
				break;
			case 'delete_group':
				require_once(CONTROLER_DIR.'delete_group.php');
				break;
			case 'modify-user':
				require_once(CONTROLER_DIR.'modify_user.php');
				break;
			default:
				require_once(CONTROLER_DIR.'index.php');
				break;
		}
		?>
	</body>
</html>