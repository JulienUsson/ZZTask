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
		echo $this->_hash_password($password)."          ";
		echo $users[$login];
		if($users[$login]==$this->_hash_password($password)) {
			session_start();
			$_SESSION['login']=$login;
			return true;
		}
		return false;
	}

	public function is_connected() {
		return isset($_SESSION['login']);
	}

	public function deconnect() {
		session_start();
		unset($_SESSION['login']);
	}

	public function add_user($login, $password) {
		$users=$this->get_users();
		if(!isset($users[$login])) {
			$users[$login]=$this->_hash_password($password);
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

	private function _hash_password($password) {
		return password_hash($password, PASSWORD_BCRYPT, "SaulasUsson");
	}
}
