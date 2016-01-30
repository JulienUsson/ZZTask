<?php

if(!isset($_SESSION)) session_start();
require_once('../../classes/admin.php');
require_once('../../classes/authentification.php');
require_once('../../classes/tasks.php');

$auth=new Authentification();
$admin=new Admin();
$params = json_decode(file_get_contents('php://input'),true);

if(!$auth->is_connected()['admin'])
	return;

switch($params['action']) {
	//--------------- ADD_USER ------------------
	case 'add_user':
    echo json_encode($auth->add_user($params['login'],"password"));
		if($params['isAdmin']=='true')
			$admin->add_admin($params['login']);
		break;
	//--------------- SET_ADMIN ------------------
	case 'set_admin':
		if($params['isAdmin']=='true')
			echo json_encode($admin->add_admin($params['login']));
		else
			echo json_encode($admin->remove_admin($params['login']));
		break;
	//--------------- GET_USERS ------------------
	case 'get_users':
		foreach ($auth->get_users() as $login => $pass){
			$users[] = array('login' => $login, 'isAdmin' => $admin->is_admin($login));
		}
		unset($login);
		unset($pass);
    echo json_encode($users);
		break;
	//--------------- REMOVE_USER ------------------
	case 'remove_user':
		echo json_encode($auth->remove_user($params['login']));
		break;
	//--------------- RESET_USER ------------------
	case 'reset_user':
		echo json_encode($auth->reset_password($params['login']));
		break;
}

?>
