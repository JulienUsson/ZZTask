<?php
	include('functions/auth_functions.php');

	$login=get_login();
	$password=get_password();
	if($login AND $password)
	{
		if(connect($login, $password))
			header('Location: /index.php');
	}
	header('Location: /login.php');
?>
