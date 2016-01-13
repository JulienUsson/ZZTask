<?php

class Tasks {
	public function _construct() {}
	
	public function get_tasks($login) {
		$tasks=json_decode(file_get_contents(__dir__."/../private/tasks/".$login.".json"), true);
		if(!$tasks)
			$tasks=array(array(), array(), array());
			
		return $tasks;
	}

	private function _save_tasks($login, $tasks) {
		file_put_contents(__dir__."/../private/tasks/".$login.".json", json_encode($tasks));
	}


	public function add_task($login, $title, $description) {
		$tasks=$this->get_tasks($login);
		$tasks[0][]=array('title' => $title, 'description' => $description, 'user' => $login);
		$this->_save_tasks($login, $tasks);
		return true;
	}

	public function remove_task($login, $source, $index) {
		$tasks=$this->get_tasks($login);
		if(isset($tasks[$source][$index])) {
			unset($tasks[$source][$index]);
			$this->_save_tasks($login, $tasks);
			return true;
		}
		return false;
	}

	public function move_task($login, $source, $index) {
		$tasks=$this->get_tasks($login);
		if(isset($tasks[$source][$index])) {
			printf("lol");
			$tasks[$source+1][]=$tasks[$source][$index];
		}
		$this->remove_task($login, $source, $index);
		$this->_save_tasks($login, $tasks);
		return true;
	}
	
	//public function edit_task($login, $source)
};
?>
