<?php

/**
 * Class used to manage Admin
 *
 */
class Admin {
	/**
	 * return the list of admins save in the json file
	 */
	public function get_admins() {
		return json_decode(file_get_contents(__dir__."/../private/admins.json"), true);
	}
	
	/**
	 * save the list of admin in a json file
	 */
	private function _save_admins($admins) {
		file_put_contents(__DIR__."/../private/admins.json", json_encode($admins));
	}
	
	/**
	 * return true if $login is admin, false if he isn't
	 */
	public function is_admin($login) {
		$admins=$this->get_admins();
		return in_array($login, $admins);
	}

	/**
	 * add an admin to the list of admin saved in the json file
	 */
	public function add_admin($login) {
		$admins=$this->get_admins();
		if(!$this->is_admin($login)) {
			$admins[]=$login;
			$this->_save_admins($admins);
			return true;
		}
		return false;
	}
	
	/**
	 * remove an admin of the list saved in the json file
	 */
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
