<?php

class Authentification {
	public function format_login($l) {
		if(isset($l)) {
			$login=trim($l);
		} else {
			$login=null;
		}
		return $login;
	}

	public function format_password($p) {
		if(isset($p)) {
			$password=trim($p);
		} else {
			$password=null;
		}
		return $password;
	}

	public function get_users() {
		return json_decode(file_get_contents(__dir__."/../private/users.json"), true);
	}

	private function _save_users($users) {
		file_put_contents(__DIR__."/../private/users.json", json_encode($users));
	}

	public function connect($login, $password) {
		$admin=new Admin();
		$users=$this->get_users();
		if($this->_password_verify($password, $users[$login])) {
			$_SESSION['login']=$login;
			$_SESSION['loggedIn']=true;
			$_SESSION['admin']=$admin->is_admin($login);
		}
		else {
			$_SESSION['loggedIn']=false;
			$_SESSION['admin']=false;
		}
		return array('loggedIn' => $_SESSION['loggedIn'], 'admin' => $_SESSION['admin']);
	}

	public function is_connected() {
		return array('loggedIn' => (isset($_SESSION['loggedIn']))?$_SESSION['loggedIn']:false, 'admin' => (isset($_SESSION['admin']))?$_SESSION['admin']:false);
	}

	public function deconnect() {
		unset($_SESSION['login']);
		$_SESSION['login']=false;
		$_SESSION['loggedIn']=false;
		$_SESSION['admin']=false;
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

	public function change_password($login, $oldPassword, $newPassword) {
		$users=$this->get_users();
		if($this->_password_verify($oldPassword, $users[$login])) {
			$users[$login]=$this->_password_hash($newPassword);
			$this->_save_users($users);
			return true;
		}
		return false;
	}

	private function _password_hash($password) {
		return crypt("SaulasRomain".$password."UssonJulien",'$6$rounds=10000$OnOpQps6zF5fMApytNkv6YshxTIWQ5FI$');
	}

	private function _password_verify($password, $hash) {
		$hashed_password=$this->_password_hash($password);
		return ($hashed_password==$hash);
	}
}
