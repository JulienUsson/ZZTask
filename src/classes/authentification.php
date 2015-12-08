<?php

class Authentification {
	public function get_login() {
		if(isset($_POST['login'])) {
			$login=trim($_POST['login']);
		} else {
			$login=null;
		}
		return $login;
	}

	public function get_password() {
		if(isset($_POST['password'])) {
			$password=trim($_POST['password']);
		} else {
			$password=null;
		}
		return $password;
	}

	public function get_users() {
		return json_decode(file_get_contents(__dir__."/../private/users.json"), true);
	}

	private function _save_users($users) {
		file_put_contents(__DIR__."/../private/users.json", json_encode($users, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
	}

	public function connect($login, $password) {
		$users=$this->get_users();
		if($this->_password_verify($password, $users[$login])) {
			$_SESSION['login']=$login;
			return true;
		}
		return false;
	}

	public function is_connected() {
		return isset($_SESSION['login']);
	}

	public function deconnect() {
		unset($_SESSION['login']);
	}

	public function add_user($login, $password) {
		$users=$this->get_users();
		if(!isset($users[$login])) {
			$users[$login]=$this->_password_hash($password);
			$this->_save_users($users);
			return true;
		}
		return false;
	}

	public function remove_user($login) {
		$users=$this->get_users();
		if(isset($users[$login])) {
			unset($users[$login]);
			$this->_save_users($users);
			return true;
		}
		return false;
	}

	private function _password_hash($password) {
		return password_hash("SaulasRomain".$password."UssonJulien", PASSWORD_BCRYPT);
	}

	private function _password_verify($password, $hash) {
		return password_verify("SaulasRomain".$password."UssonJulien", $hash);
	}
}
