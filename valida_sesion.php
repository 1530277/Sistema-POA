<?php
	//if(!isset($_SESSION))
		session_start();
	if(!isset($_SESSION['nombre']) and !isset($_SESSION['fb_access_token'])){
		header("Location: login.php");
	}
?>