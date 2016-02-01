<?php

/**
 * class used to manage tasks
 */
class Tasks {
	/**
	 * return the list of tasks saved in the json file
	 */
	public function get_tasks() {
		$tasks=json_decode(file_get_contents(__dir__."/../private/tasks.json"), true);
		return $tasks;
	}

	/**
	 * save the list of tasks in the json file
	 */
	private function _save_tasks($tasks) {
		file_put_contents(__dir__."/../private/tasks.json", json_encode($tasks));
		return true;
	}
	
	/**
	 * add a task in the list of tasks saved in the json file
	 */
	public function add_task($title, $description, $user, $state=0) {
		if(!$title || !$description || !$user || $state<0 || $state>2)
			return false;
		$tasks=$this->get_tasks();
		$tasks[]=array('title' => $title, 'description' => $description, 'user' => $user, 'state' => $state);
		$this->_save_tasks($tasks);
		return true;
	}

	/**
	 * remove a task in the list of tasks saved in the json file
	 */
	public function remove_task($id) {
		$tasks=$this->get_tasks();
		if(array_key_exists($id, $tasks)) {
			unset($tasks[$id]);
			$this->_save_tasks($tasks);
			return true;
		}
		return false;
	}

	/**
	 * edit a task from the list of tasks saved in the json file
	 */
	public function edit_task($id, $title, $description, $user, $state) {
		if(!$title || !$description || !$user || $state<0 || $state>2)
			return false;
		$tasks=$this->get_tasks();
		$tasks[$id]=array('title' => $title, 'description' => $description, 'user' => $user, 'state' => $state);
		$this->_save_tasks($tasks);
		return true;
	}
};
?>
