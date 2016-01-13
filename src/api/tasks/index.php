<?php

session_start();
require_once('../../classes/tasks.php');

$tasks=new Tasks();
$params = json_decode(file_get_contents('php://input'),true);

switch($params['action']) {
	//--------------- GET_TASKS -------------------------------
	case 'get_tasks':
		echo json_encode($tasks->get_tasks($_SESSION['login']));
		break;
	//--------------- MOVE_TASKS --------------
	case 'move_task_todo_inprogress':
		$tasks.move_task($_SESSION['login'],$params['source'],$params['title']);
		echo json_encode($tasks->get_tasks($_SESSION['login']));
		break;
	//--------------- REMOVE_TASK -----------------------------
	case 'remove_task':
		$tasks.remove_task($_SESSION['login'],$params['source'],$params['title']);
		echo json_encode($tasks->get_tasks($_SESSION['login']));
		break;
}

?>
