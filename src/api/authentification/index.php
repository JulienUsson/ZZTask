<?php

session_start();
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
		$auth->deconnect();
		echo "true";
		break;
	//--------------- ISCONNECTED ------------------
	case 'isconnected':
		echo json_encode($auth->is_connected());
		break;
}

?>
