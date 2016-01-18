<?php

if(!isset($_SESSION)) session_start();
require_once('../../classes/tasks.php');
require_once('../../classes/authentification.php');

$tasks=new Tasks();
$auth=new Authentification();

if(!$auth->is_connected())
	return;

$params = json_decode(file_get_contents('php://input'),true);
switch($params['action']) {
	//--------------- GET_TASKS -------------------------------
	case 'get_tasks':
		$tasks=$tasks->get_tasks();
		foreach ($tasks as $key => $value){
		  $tasks[$key]['id']=$key;
		}
		echo json_encode(array_values($tasks));
		break;
		//--------------- ADD_TASKS --------------
	case 'add_task':
		echo json_encode($tasks->add_task($params['task']['title'], $params['task']['description'], $params['task']['user'], $params['task']['state']));
		break;
	//--------------- EDIT_TASKS --------------
	case 'edit_task':
		echo json_encode($tasks->edit_task($params['index'], $params['task']['title'], $params['task']['description'], $params['task']['user'], $params['task']['state']));
		break;
	//--------------- DELETE_TASK -----------------------------
	case 'delete_task':
		echo json_encode($tasks->remove_task($params['index']));
		break;
}

?>
