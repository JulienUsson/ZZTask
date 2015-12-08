<?php
	include('classes/authentification.php');
	session_start();
	$auth=new Authentification();
	$login=$auth->get_login();
	$password=$auth->get_password();
	if($login AND $password)
	{
		if($auth->connect($login, $password))
			header('Location: ./index.php');
	}
	header('Location: ./login.php');
?>
