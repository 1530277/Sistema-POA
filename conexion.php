<?php
	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "sistema_poa";
	try {
    	$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    	//$stmt = $conn->prepare("SELECT codigo as '1',
    	//nombre_producto as '2', cantidad_stock as '3', precio_venta as '4' FROM productos"); 
    	//$stmt->execute();
    	//$result=$stmt->fetchAll();
    }catch(PDOException $e) {
    	echo "Mensaje-Error: " . $e->getMessage();
	}
		//<form action="" method="post" name="Login_Form" class="form-signin">
?>