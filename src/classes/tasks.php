<?php

class Tasks {
	public function get_tasks() {
		$tasks=json_decode(file_get_contents(__dir__."/../private/tasks.json"), true);
		return $tasks;
	}

	private function _save_tasks($tasks) {
		file_put_contents(__dir__."/../private/tasks.json", json_encode($tasks));
		return true;
	}

	public function add_task($title, $description, $user, $state=0) {
		$tasks=$this->get_tasks();
		$tasks[]=array('title' => $title, 'description' => $description, 'user' => $user, 'state' => $state);
		$this->_save_tasks($tasks);
		return true;
	}

	public function remove_task($id) {
		$tasks=$this->get_tasks();
		unset($tasks[$id]);	
		$this->_save_tasks($tasks);
		return true;
	}

	public function edit_task($id, $title, $description, $user, $state) {
		$this->remove_task($id);
		$this->add_task($title, $description, $user, $state);
		return true;
	}
};
?>
