<!DOCTYPE html>
<html>
<head>
	
<!------ Include the above in your HEAD tag ---------->

	<link rel="stylesheet" href="css/bootstrap.min.css">
	<meta charset="utf-8">
	<style type="text/css">
		.wrapper {    
			margin-top: 80px;
			margin-bottom: 20px;
		}

		.form-signin {
		  max-width: 420px;
		  padding: 30px 38px 66px;
		  margin: 0 auto;
		  background-color: #eee;
		  border: 3px dotted rgba(0,0,0,0.1);  
		  }

		.form-signin-heading {
		  text-align:center;
		  margin-bottom: 30px;
		}

		.form-control {
		  position: relative;
		  font-size: 16px;
		  height: auto;
		  padding: 10px;
		}

		input[type="text"] {
		  margin-bottom: 0px;
		  border-bottom-left-radius: 0;
		  border-bottom-right-radius: 0;
		}

		input[type="password"] {
		  margin-bottom: 20px;
		  border-top-left-radius: 0;
		  border-top-right-radius: 0;
		}

		.colorgraph {
		  height: 7px;
		  border-top: 0;
		  background: #c4e17f;
		  border-radius: 5px;
		  background-image: -webkit-linear-gradient(left, #c4e17f, #c4e17f 12.5%, #f7fdca 12.5%, #f7fdca 25%, #fecf71 25%, #fecf71 37.5%, #f0776c 37.5%, #f0776c 50%, #db9dbe 50%, #db9dbe 62.5%, #c49cde 62.5%, #c49cde 75%, #669ae1 75%, #669ae1 87.5%, #62c2e4 87.5%, #62c2e4);
		  background-image: -moz-linear-gradient(left, #c4e17f, #c4e17f 12.5%, #f7fdca 12.5%, #f7fdca 25%, #fecf71 25%, #fecf71 37.5%, #f0776c 37.5%, #f0776c 50%, #db9dbe 50%, #db9dbe 62.5%, #c49cde 62.5%, #c49cde 75%, #669ae1 75%, #669ae1 87.5%, #62c2e4 87.5%, #62c2e4);
		  background-image: -o-linear-gradient(left, #c4e17f, #c4e17f 12.5%, #f7fdca 12.5%, #f7fdca 25%, #fecf71 25%, #fecf71 37.5%, #f0776c 37.5%, #f0776c 50%, #db9dbe 50%, #db9dbe 62.5%, #c49cde 62.5%, #c49cde 75%, #669ae1 75%, #669ae1 87.5%, #62c2e4 87.5%, #62c2e4);
		  background-image: linear-gradient(to right, #c4e17f, #c4e17f 12.5%, #f7fdca 12.5%, #f7fdca 25%, #fecf71 25%, #fecf71 37.5%, #f0776c 37.5%, #f0776c 50%, #db9dbe 50%, #db9dbe 62.5%, #c49cde 62.5%, #c49cde 75%, #669ae1 75%, #669ae1 87.5%, #62c2e4 87.5%, #62c2e4);
		}
	</style>
</head>
<?php
	require_once("/facebook/fb-login.php");
?>
<body>
<div class = "container">
	<div class="wrapper">
		<form class="form-signin" method="post">
		    <h2 class="form-signin-heading">Sistema POA</h2>
		    <h4 class="form-signin-heading">Universidad Politécnica de Victoria</h4>
			  <hr class="colorgraph"><br>
			  
			  <input type="text" class="form-control" id=usuario name="usuario" value="" required="" autocomplete="off" />
			  <input type="password" class="form-control" id=contrasena name="contrasena" value="" required="" autocomplete="off"/>     		  
			 
			  <button class="btn btn-lg btn-primary btn-block" name="Login" >Login</button>
			  <a href="<?php echo $loginUrl;?>" class="btn btn-lg btn-primary btn-block" name="fb-login" >Iniciar sesión con Facebook</a>		
		</form>
	</div>
</div>
<?php
		//echo "array: ".print_r($array_consulta);
	if(isset($_REQUEST['fb-login'])){
		//header("Location: facebook/fb-callback.php");
		if(!isset($_SESSION['facebook']))
			echo "No hay sesión de fb ON";
		else
			echo "hay sesión";

	}
	if(isset($_REQUEST['Login'])){
		$user=$_REQUEST['usuario'];
		$pass=$_REQUEST['contrasena'];
		$servername = "localhost";
		$username = "root";
		$password = "";
		$dbname = "sistema_poa";
		try {
    		$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    		$query=$conn->prepare("SELECT * FROM usuarios WHERE nombre=:user AND password=:pass");//WHERE (nombre='".$user."') AND (password='".$pass."')
			$query->bindParam(':user',$user,PDO::PARAM_STR);
			$query->bindParam(':pass',$pass,PDO::PARAM_STR);
			$query->execute();
			$array_consulta=$query->fetchAll();
    	}catch(PDOException $e) {
    		echo "Mensaje-Error: " . $e->getMessage();
		}
		echo "array:".print_r($array_consulta);
		if(count($array_consulta)==1){
			if(!isset($_SESSION))
				session_start();
			echo "entre";sleep(3);
			$_SESSION["nombre"]=$array_consulta[0][3];
			//}
			header("Location: agregar_area.php");
		}else{
			header("Location: ");

			echo"
				<script>
					alert('Sistema: El usuario o contraseña ingresados son incorrectos.');
				</script>
			";
		}
	}
?>	
</body>
</html>