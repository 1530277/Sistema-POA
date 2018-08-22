<?php
	include 'valida_sesion.php';
	include 'menu.php';
	require_once'agregar_css.php';
?>
<?php
	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "sistema_poa";
	try {
		$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$query=$conn->prepare("SELECT nombre_area FROM areas");
		$query->execute();
		$array_consulta1=$query->fetchAll();
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
			<input class="form-control" type="text" maxlength="15" value="" name="id_eje" id="id_eje" required="" placeholder="Clave">
			<input class="form-control" type="text" maxlength="15" value="" name="nombre" id="nombre" required="" placeholder="Clave">
			<textarea class="form-control" type="text" value="" name="objetivo" id="objetivo" required="" placeholder="Objetivo..."></textarea>
			<br>
			<label class="">Área:</label>
			<input class="form-control" placeholder="Áreas" name="areas" id="areas" list=lista_areas required="">
			<datalist id=lista_areas>
				<?php
					for($i=0;$i<count($array_consulta1);$i++)
						echo"<option value=".$array_consulta1[$i][0].">";
					if(count($array_consulta1)==0)
						echo"<option value='No hay registros'>";
				?>
			</datalist>
			<button class="form-control btn btn-primary verdesito" name="btn_save" id=btn_save>Guardar cambios</button>
		</form>
	</div>
</div>
<?php
	if(isset($_REQUEST['btn_save'])){
		$id_eje=$_REQUEST['id_eje'];
		$nombre=$_REQUEST['nombre'];
		$objetivo=$_REQUEST['objetivo'];
		$areas=$_REQUEST['areas'];
		$id_area="";
		if(count($array_consulta1)!=0){
			try{
				$query=$conn->prepare("INSERT INTO ejes_rectores(id_eje,nombre,objetivo,id_area) values(:id_eje,:nombre,:objetivo,:id_area)");
					//Conseguir el id del área seleccionada (nombre_area)
				$mq=$conn->prepare("SELECT * FROM areas");
				$mq->execute();
				$array_areas=$mq->fetchAll();
				for($n=0;$n<count($array_areas);$n++)
					if($array_areas[$n]["nombre_area"]==$areas)
						$id_area=$array_areas[$n]["id_area"];
				$query->bindParam(":id_eje",$id_eje);
		    	$query->bindParam(":nombre",$nombre);
		    	$query->bindParam(":objetivo",$objetivo);
		    	$query->bindParam(":id_area",$id_area);
		    	$query->execute();
		    }catch(PDOException $e){
		    	echo "Mensaje-Error: ".$e->getMessage();
			}
		}
	}
?>