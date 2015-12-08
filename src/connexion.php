<?php
	include('classes/authentification.php');
	$auth=new Authentification();
	$auth->add_user("test","test");
	$login=$auth->get_login();
	$password=$auth->get_password();
	if($login AND $password)
	{
		if($auth->connect($login, $password))
			header('Location: /index.php');
	}
	header('Location: /login.php');
?>
