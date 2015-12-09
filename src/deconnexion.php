<?php include('classes/authentification.php');
      $auth=new Authentification();
	  $auth->deconnect();
	  header('Location: ./login.php');
?>
