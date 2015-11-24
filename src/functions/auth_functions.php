<?php

function get_login() {
	if(isset($_POST['login'])) {
		$login=trim($_POST['login']);
	} else {
		$login=null;
	}
	return $login;
}

function get_password() {
	if(isset($_POST['password'])) {
		$password=trim($_POST['password']);
	} else {
		$password=null;
	}
	return $password;
}

function get_users() {
	return json_decode(file_get_contents(__dir__."/../private/users.json"), true);
}

function save_users($users) {
	file_put_contents(__DIR__."/../private/users.json", json_encode($users));
}

function connect($login, $password) {
	$users=get_users();
	if($users[$login]==$password) {
		session_start();
		$_SESSION['login']=$login;
		return true;
	}
	return false;
}

function is_connected() {
	return isset($_SESSION['login']);
}

function deconnect() {
	session_start();
	unset($_SESSION['login']);
}

function add_user($login, $password) {
	$users=get_users();
	if(!isset($users[$login])) {
		$users[$login]=$password;
		save_users($users);
		return true;
	}
	return false;
}

function remove_user($login) {
	$users=get_users();
	if(isset($users[$login])) {
		unset($users[$login]);
		save_users($users);
		return true;
	}
	return false;
}

function hash_password($password) {
	return password_hash("RomainSaulas".$password."JulienUsson");
}

?>
