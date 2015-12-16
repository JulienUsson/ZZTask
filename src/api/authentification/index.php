<?php

//session_start();
include('../../classes/authentification.php');

$auth=new Authentification();
$params = json_decode(file_get_contents('php://input'),true);

switch($params['action']) {
	//--------------- LOGIN ------------------
	case 'login':
		$login=$auth->format_login($params['login']);
		$password=$auth->format_password($params['password']);
		if($login AND $password)
		{
			if($auth->connect($login, $password)) {
				echo "true";
			}
			else {
				echo "false";
			}
		}
		else {
			echo "false";
		}
		break;
	//--------------- LOGOUT ------------------
	case 'logout':
		$auth->deconnect();
		echo "true";
		break;
	//--------------- ISCONNECTED ------------------
	case 'isconnected':
		echo ($auth->is_connected())?"true":"false";
		break;
}

?>
