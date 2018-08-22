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
		//arreglo con id de empleado
		$query=$conn->prepare("SELECT numero_empleado FROM empleados");
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
			if(isset($_POST['btn_save'])){
				if(strlen($_POST['id_area'])<5)
					echo"<div class='alert alert-danger' role='alert' name='notify'>Se requiere hacer almenos el registro de una Áreas.</div><hr name='notify'>";
				else
					echo "<div class='alert alert-success' role='alert' name='notify'>Los datos se han guardado correctamente.</div><hr name='notify'>";
				include 'oculta_notificacion.php';
			}
		?>
		<input class="form-control" type="text" minlength="5" maxlength="5" value="" name="id_area" id="id_area" required="" placeholder="Código">
		<input class="form-control" type="text" maxlength="20" value="" name="nombre" id="nombre" required="" placeholder="Nombre"><br>
		<label class="">Clave de empleado a cargo:</label>
		<input class="form-control" name=encargado id="encargado" list=lista_empleados required="">
			<datalist id=lista_empleados>
			<?php
				for($i=0;$i<count($array_consulta1);$i++)
					echo"<option value=".$array_consulta1[$i][0].">";
				if(count($array_consulta1)==0)
					echo"<option value='No hay registros'>";
			?>
			</datalist>
		</select><br>
		<label class="">Es sub-área de:</label>
		<select class="form-control form-control-lg" name=depende id="depende">
			<?php
				try {
		    		$query=$conn->prepare("SELECT nombre_area FROM areas");
					$query->execute();
					$array_consulta2=$query->fetchAll();
		    	}catch(PDOException $e) {
		    		echo "Mensaje-Error: ".$e->getMessage();
				}
				echo "<option id=sin_dependencia name=sin_dependencia>No es sub-área</option>";
				for($i=0;$i<count($array_consulta2);$i++)
					echo"<option class='form-control' id=".$array_consulta2[$i][0].">".$array_consulta2[$i][0]."</option>";
			?>
		</select>
		<button class="form-control btn btn-primary verdesito" name="btn_save" id=btn_save>Guardar cambios</button>
	</form>
</div>
</div>

<?php
	if(isset($_REQUEST['btn_save'])){
			$clave=$_REQUEST['id_area'];
			$encargado=$_REQUEST['encargado'];
			$nombre=$_REQUEST['nombre'];
			$depende=$_REQUEST['depende'];
			if(strlen($clave)==5){
				try{
					if($depende!="No es sub-área"){
						$query=$conn->prepare("INSERT INTO areas(id_area,nombre_area,encargado,depende_de) values(:id_a,:nom_a,:id_e,:dep)");
						//Conseguir el id del área seleccionada (nombre_area)
						$mq=$conn->prepare("SELECT id_area FROM areas WHERE nombre_area=:nom");
						$mq->bindParam(':nom',$depende);
						$mq->execute();
						$id_depende=$mq->fetchAll();
						$depende=$id_depende[0][0];
					}else{
						$query=$conn->prepare("INSERT INTO areas(id_area,nombre_area,encargado) values(:id_a,:nom_a,:id_e)");
				    	$query->bindParam(":id_a",$clave);
				    	$query->bindParam(":nom_a",$nombre);
				    	$query->bindParam(":id_e",$encargado);
						if($depende!="No es sub-área")
				    		$query->bindParam(":dep",$depende);
				    	$query->execute();
			    	}
			    }
			    catch(PDOException $e){
			    	echo "Mensaje-Error: ".$e->getMessage();
				}
		}
	}
?>