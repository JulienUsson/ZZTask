<?php

if(!isset($_SESSION)) session_start();
require_once('../../classes/tasks.php');
require_once('../../classes/authentification.php');

$tasks=new Tasks();
$auth=new Authentification();
$id_connected=$auth->is_connected();
if(!$id_connected['loggedIn'])
	return;

$params = json_decode(file_get_contents('php://input'),true);
switch($params['action']) {
	//--------------- ADD_TASKS --------------
	case 'add_task':
		$tasks->add_task($params['task']['title'], strip_tags($params['task']['description']), $params['task']['user'], $params['task']['state']);
		break;
	//--------------- EDIT_TASKS --------------
	case 'edit_task':
		$tasks->edit_task($params['id'], $params['task']['title'], strip_tags($params['task']['description']), $params['task']['user'], $params['task']['state']);
		break;
	//--------------- DELETE_TASK -----------------------------
	case 'delete_task':
		$tasks->remove_task($params['id']);
		break;
}

$tasks=$tasks->get_tasks();
$todo=array();
$inprogress=array();
$done=array();
foreach ($tasks as $key => $value){
	$value['id']=$key;
	switch($value['state']) {
		case 0:
			$todo[]=$value;
			break;
		case 1:
			$inprogress[]=$value;
			break;
		case 2:
			$done[]=$value;
			break;
	}
}
echo json_encode(array('0' => $todo, '1' => $inprogress, "2" => $done));

?>
