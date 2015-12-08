<?php include('classes/authentification.php');
      session_start();
      $auth=new Authentification();
			$auth->deconnect();
			header('Location: ./login.php'); ?>
