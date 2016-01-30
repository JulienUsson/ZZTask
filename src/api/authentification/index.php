<?php

if(!isset($_SESSION)) session_start();
require_once('../../classes/admin.php');
require_once('../../classes/authentification.php');

$auth=new Authentification();
$params = json_decode(file_get_contents('php://input'),true);

switch($params['action']) {
	//--------------- LOGIN ------------------
	case 'login':
		$login=$auth->format_login($params['login']);
		$password=$auth->format_password($params['password']);
		echo json_encode($auth->connect($login, $password));
		break;
	//--------------- LOGOUT ------------------
	case 'logout':
		if(!$auth->is_connected()['loggedIn'])
			return;
		$auth->deconnect();
		echo "true";
		break;
	//--------------- ISCONNECTED ------------------
	case 'isconnected':
		echo json_encode($auth->is_connected());
		break;
		//--------------- CHANGEPASSWORD ------------------
		case 'changePassword':
			if(!$auth->is_connected()['loggedIn'])
				return;
			echo json_encode($auth->change_password($_SESSION['login'], $params['oldPassword'], $params['newPassword']));
			break;
		case 'get_users':
			if(!$auth->is_connected()['loggedIn'])
				return;
			foreach ($auth->get_users() as $login => $pass){
				$users[] = $login;
			}
			echo json_encode($users);
			break;
}

?>
