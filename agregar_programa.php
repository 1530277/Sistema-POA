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
		$query=$conn->prepare("SELECT id_eje, nombre FROM ejes_rectores");
		$query->execute();
		$array_consulta_ejerect=$query->fetchAll();
	}catch(PDOException $e){
		echo "Mensaje-Error: ".$e->getMessage();
	}
?>

<div class="container">
	<div class="wrapper">
		<form class="form-signin" method="post">
			<?
				if(isset($_POST['btn-save'])){
					if(count($array_consulta_ejerect)==0)
						echo "<div class='alert alert-danger' role='alert' name='notify'>Se requiere hacer almenos el registro de un elemento Eje Rector para agregar elementos en esta sección.</div><hr name='notify'>";
					if(count($array_consulta_ejerect)!=0)
						echo "<div class='alert alert-success' role='alert' name='notify'>Los datos se han guardado correctamente.</div><hr name='notify'>";
				}
				include "oculta_notificacion.php";
			?>
			<input type="number" id="id_programa" name="id_programa" class="form-control" required="" min="0" maxlength="50" placeholder="Clave">

			<input type="text" id="nombre" name="nombre" class="form-control" required="" min="0" placeholder="Nombre del programa">

			<textarea class="form-control" name="objetivo" required="" maxlength="150" placeholder="Objetivo"></textarea>
			<span class="badge verdesito">Ejes Rectores:</span>
			<select class="form-control" name="ejes_rectores">
				<?php
					/*
						Si el arreglo tiene elementos significa que anteriormente se han registrado elementos en la tabla, sino la única opción del select será una en la que avisa que no hay datos registrados y se necesita registrar para registrar elementos "programa"
					*/
					if(count($array_consulta_ejerect)==0)
						echo"<option value='No hay registros'>No hay registros</option>";
					for($i=0;$i<count($array_consulta_ejerect);$i++)
						echo"<option value='".$array_consulta_ejerect[$i]["nombre"]."'>".$array_consulta_ejerect[$i]["nombre"]."</option>";
				?>
			</select>

			<button class="btn btn-primary form-control verdesito" id="btn-save" name="btn-save">Guardar</button>
		</form>
	</div>
</div>
<?php
	//Condiciona que se haga click en el botón para guardar y que hayan elementos "eje rector guardados en la bd, ya que por consecuencia se habrá elegido uno"
	if(isset($_REQUEST['btn-save'])&&count($array_consulta_ejerect)>0){
		//Definen e inicializan variables para realizar el guardado de los datos
		try{
			$id_programa=$_REQUEST['id_programa'];
			for($i=0;$i<count($array_consulta_ejerect);$i++)
				if($_REQUEST['ejes_rectores']==$array_consulta_ejerect[$i]["nombre"])
					$id_eje=$array_consulta_ejerect[$i]["id_eje"];
			$nombre=$_REQUEST['nombre'];
			$objetivo=$_REQUEST['objetivo'];
			$query=$conn->prepare("INSERT INTO programas(id_programa,nombre,objetivo,id_eje) VALUES(:id_programa,:nombre,:objetivo,:id_eje)");
			$query->bindParam(":id_programa",$id_programa);
			$query->bindParam(":nombre",$nombre);
			$query->bindParam(":objetivo",$objetivo);
			$query->bindParam(":id_eje",$id_eje);
			$query->execute();
		}catch(Exception $e){
			echo "Message-Error: ".$e;
		}

	}
?>
