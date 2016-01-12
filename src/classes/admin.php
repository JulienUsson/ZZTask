<?php

class Admin {
	public function get_admins() {
		return json_decode(file_get_contents(__dir__."/../private/admins.json"), true);
	}

	private function _save_admins($admins) {
		file_put_contents(__DIR__."/../private/admins.json", json_encode($admins));
	}

	public function is_admin($login) {
		$admins=$this->get_admins();
		return in_array($login, $admins);
	}

	public function add_admin($login) {
		$admins=$this->get_admins();
		if(!$this->is_admin($login)) {
			$admins[]=$login;
			$this->_save_admins($admins);
			return true;
		}
		return false;
	}

	public function remove_admin($login) {
		$admins=$this->get_admins();
		if($this->is_admin($login)) {
			unset($admins[array_search($login, $admins)]);
			$this->_save_admins($admins);
			return true;
		}
		return false;
	}
}
