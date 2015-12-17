<?php

class Tasks {
	public function __construct() {}
	
	public function get_tasks($login) {
		return json_decode(file_get_contents(__dir__."/../private/tasks/".$login.".json"), true);
	}

	private function _save_tasks($login, $tasks) {
		file_put_contents(__dir__."/../private/tasks/".$login.".json", json_encode($tasks));
	}


	public function add_task($login, $title, $description) {
		$tasks=$this->get_tasks();
		if(!isset($tasks[0][$title])) {
			$tasks[0][$title]=$description;
			$this->_save_tasks($login, $tasks);
			return true;
		}
		return false;
	}

	public function remove_task($login, $source, $title) {
		$tasks=$this->get_tasks($login);
		if(!isset($tasks[$source][$title])) {
			unset($tasks[$source][$title]);
			$this->_save_tasks($tasks, $login);
			return true;
		}
		return false;
	}

	public function move_task($login, $source, $title) {
		$tasks=$this->get_tasks($login);
		if(!isset($tasks[$source][$title])) {
			$tasks[$source+1][$title]=$tasks[$source][$title];
		}
		$this->remove_task($login, $source, $title);
		$this->_save_tasks($tasks, $login);
		return true;
	}
};
?>
