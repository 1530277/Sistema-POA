<?php
	session_start();
	if(!session_destroy()){
		echo "aqui ando aun";
	}
	else
		include'valida_sesion.php';
?>