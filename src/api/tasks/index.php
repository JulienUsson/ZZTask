<?php

include('../../classes/tasks.php');

$tasks=new Tasks();
$params = json_decode(file_get_contents('php://input'),true);

switch($params['action']) {
	//--------------- GET_TASKS ------------------
	case 'get_tasks':
		echo json_encode($tasks->get_tasks($_SESSION['login']));
		break;
}

?>
