<?php
	include 'valida_sesion.php';
	include 'menu.php';
	require_once 'agregar_css.php';
?>
<?php
	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "sistema_poa";
	try {
		$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}catch(PDOException $e){
		echo "Mensaje-Error: ".$e->getMessage();
	}
?>

<div class = "container">
	<div class="wrapper">
		<form class="form-signin" method="post">
			<?php
				/*
					Muestra una pequeña notificación sobre el estado de la acción anteriormente realizada, si fue concluida exitosamente o huvo algún error.
				*/
				if(isset($_POST['btn_save'])){
					echo "<div class='alert alert-success' role='alert' name='notify'>Los datos se han guardado correctamente.</div><hr name='notify'>";
					include 'oculta_notificacion.php';
				}
			?>
			<br>
                <p><label>Clave: </label><input class="form-control" type="number" name="clave" placeholder="Clave" min="1"></p>
                <p><label>Nombre: </label><input class="form-control" type="text" name="nombre" placeholder="Nombre" maxlength="20"></p>
				<button class="form-control btn btn-primary verdesito" name="btn_save" id=btn_save>Guardar cambios</button>
		</form>
	</div>
</div>
<?php
	if(isset($_REQUEST['btn_save'])){
		$clave=$_REQUEST['clave'];
		$nombre=$_REQUEST['nombre'];
		try{
			$query=$conn->prepare("INSERT INTO partidas(id_partida,nombre) VALUES(:clave,:nombre)");
			$query->bindParam(":clave",$clave);
			$query->bindParam(":nombre",$nombre);
			$query->execute();
		}catch(PDOException $e){
			echo "Mensaje-Error: ".$e->getMessage();
			$error=1;
		}
	}
?>