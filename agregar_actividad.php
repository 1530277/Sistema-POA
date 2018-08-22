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
		$query=$conn->prepare("SELECT clave,nombre FROM proyectos");
		$query->execute();
		$consulta_array_proyectos=$query->fetchAll();
		$respaldo_proyectos=$consulta_array_proyectos;
		$json_array=json_encode($respaldo_proyectos);
	}catch(PDOException $e){
		echo "Mensaje-Error: ".$e->getMessage();
	}
?>

<?php
	$cont=0;
	if(count($consulta_array_proyectos)==0)
		$cont++;
	if(empty($_POST['mes0']))
		$cont++;
	if(isset($_POST['btn_save'])&&$cont==0){
		$nombre=$_REQUEST['nombre'];
		$descripcion=$_REQUEST['descripcion'];
		$id_proyecto=$_REQUEST['proyectos'];
		if(!empty($_POST['mes0'])){
			$mes_plan=$_POST['mes0'];
		}
		$query=$conn->prepare("SELECT * FROM actividades WHERE id_proyecto=:id_p");
		$query->bindParam(":id_p",$id_proyecto);
		$query->execute();
		$array_cont=$query->fetchAll();
		$id_actividad=count($array_cont);
		$id_actividad++;
		if(!empty($_REQUEST['mes1'])){
			$mes_ejec=$_POST['mes1'];
			$query=$conn->prepare("INSERT INTO actividades(id_actividad,id_proyecto,meses_plan,meses_ejec,nombre,descripcion)VALUES(:id_actividad,:id_proyecto,:meses_plan,:meses_ejec,:nombre,:descripcion)");
			$query->bindParam(":id_actividad",$id_actividad);
			$query->bindParam(":id_proyecto",$id_proyecto);
			$query->bindParam(":meses_plan",implode(", ",$mes_plan));
			$query->bindParam(":meses_ejec",implode(", ",$meses_ejec));
			$query->bindParam(":nombre",$nombre);
			$query->bindParam(":descripcion",$descripcion);
			$query->execute();
		}else{
			$query=$conn->prepare("INSERT INTO actividades(id_actividad,id_proyecto,meses_plan,meses_ejec,nombre,descripcion)VALUES(:id_actividad,:id_proyecto,:meses_plan,:meses_ejec,:nombre,:descripcion)");
			$mes_ejec="";
			$query->bindParam(":id_actividad",$id_actividad);
			$query->bindParam(":id_proyecto",$id_proyecto);
			$query->bindParam(":meses_plan",implode(", ",$mes_plan));
			$query->bindParam(":meses_ejec",$mes_ejec);
			$query->bindParam(":nombre",$nombre);
			$query->bindParam(":descripcion",$descripcion);
			$query->execute();
		}
	}
?>
<div class="container">
	<div class="wrapper">
		<form class="form-signin" method="post">
			<?
				if(isset($_POST['btn_save'])){
					if(count($consulta_array_proyectos)==0){
						echo "<div class='alert alert-danger' role='alert' name='notify'>Se requiere hacer almenos el registro de un elemento Áreas para agregar elementos en esta sección.</div><hr name='notify'>";
					}
					if(empty($_POST['mes0']))
						echo "<div class='alert alert-danger' role='alert' name='notify'>Se requiere elegir al menos los meses de Planeación.</div><hr name='notify'>";
					if(count($consulta_array_proyectos)!=0||!empty($_POST['mes0']))
						echo "<div class='alert alert-success' role='alert' name='notify'>Los datos se han guardado correctamente.</div><hr name='notify'>";
				}
				include "oculta_notificacion.php";
			?>
			<span class="badge verdesito">Clave del proyecto:</span>
			<select id="proyectos" name="proyectos" class="form-control">
				<?php
					/*
						Si el arreglo tiene elementos significa que anteriormente se han registrado elementos en la tabla, sino la única opción del select será una en la que avisa que no hay datos registrados y se necesita registrar para registrar elementos "programa"
					*/
					if(count($consulta_array_proyectos)==0)
						echo"<option value='No hay registros'>No hay registros</option>";
					for($i=0;$i<count($consulta_array_proyectos);$i++)
						echo"<option value='".$consulta_array_proyectos[$i]["clave"]."'>".$consulta_array_proyectos[$i]["clave"]."</option>";
				?>
			</select>
			<input type="text" name="nombre_proyecto" disabled="" value="" id=nombre_proyecto class="form-control">

			<script type="text/javascript">
				//
				function cambia_select(){
					var json_array=eval(<?php echo $json_array;?>);//Esta linea trae el json_array de php a javascript
					var select_proyecto=document.getElementById("proyectos").value;

					for(i=0;i<json_array.length;i++)
						if(select_proyecto==json_array[i].clave)
							document.getElementById("nombre_proyecto").value=json_array[i].nombre;
					if(json_array.length==0)
						document.getElementById("nombre_proyecto").value="No hay registros";
				//	var inp_nombre_proyecto=document.getElementById("");
				}
				document.getElementById("proyectos").addEventListener("change",cambia_select);
				window.onload=cambia_select;
			</script>

			<input type="text" class="form-control" placeholder="Nombre de la actividad" required="" name="nombre" maxlength="20">

			<textarea class="form-control" name="descripcion" id="descripcion" required="" placeholder="Descripción"></textarea>


					<?php
					function meses(){
						for($i=0;$i<2;$i++){
							if($i==0)
								echo "<br>
			<span class='badge verdesito'>Meses de planeación:</span>";
							else
								echo "<br>
			<span class='badge verdesito'>Meses de ejecución:</span>";
								echo"
						<div class='form-control inner-div'>
							<div class='form-check'>
								<div class='div-check'>
									<input type='checkbox' class='form-check-input' value='Enero' id='Ene.$i'>
									<label class='form-check-label' for='Ene.$i'>Enero</label>
								</div>
								<div class='div-check'>
									<input type='checkbox' class='form-check-input' value='Febrero' id='Feb.$i'>
									<label class='form-check-label' for='Feb.$i'>Febrero</label>
								</div>
								<div class='div-check'>
									<input type='checkbox' class='form-check-input' value='Marzo' id='Mar.$i'>
									<label class='form-check-label' for='Mar.$i'>Marzo</label>
								</div>
								<div class='div-check'>
									<input type='checkbox' class=' form-check-input' value='Abril' id='Abr.$i'>
									<label class='form-check-label' for='Abr.$i'>Abril</label>
								</div>
								<div class='div-check'>
									<input type='checkbox' class='form-check-input' value='Mayo' id='May.$i'>
									<label class='form-check-label' for='May.$i'>Mayo</label>
								</div>
								<div class='div-check'>
									<input type='checkbox' class='form-check-input' value='Junio' id='Jun.$i'>
									<label class='form-check-label' for='Jun.$i'>Junio</label>
								</div>
								<div class='div-check'>
									<input type='checkbox' class='form-check-input' value='Julio' id='Jul.$i'>
									<label class='form-check-label' for='Jul.$i'>Julio</label>
								</div>
								<div class='div-check'>
									<input type='checkbox' class='form-check-input' value='Agosto' id='Ago.$i'>
									<label class='form-check-label' for='Ago.$i'>Agosto</label>
								</div>
								<div class='div-check'>
									<input type='checkbox' class='form-check-input' value='Septiembre' id='Sep.$i'>
									<label class='form-check-label' for='Sep.$i'>Septiembre</label>
								</div>
								<div class='div-check'>
									<input type='checkbox' class='form-check-input' value='Octubre' id='Oct.$i'>
									<label class='form-check-label' for='Oct.$i'>Octubre</label>
								</div>
								<div class='div-check'>
									<input type='checkbox' class='form-check-input' value='Noviembre' id='Nov.$i'>
									<label class='form-check-label' for='Nov.$i'>Noviembre</label>
								</div>
								<div class='div-check'>
									<input type='checkbox' class='form-check-input' value='Diciembre' id='Dic.$i'>
									<label class='form-check-label' for='Dic.$i'>Diciembre</label>
								</div>
							</div>
						</div>";
						}
					}
					meses();
					?>
			<br>
			<button class="form-control btn btn-primary verdesito" name="btn_save" id=btn_save>Guardar cambios</button>
		</form>
		<script type="text/javascript">
			/*
				Esto sirve solo para colocar de forma dinámica los "names" del conjunto de check-inputs que simbolizan los meses
			*/
			var meses=['Ene.','Feb.','Mar.','Abr.','May.','Jun.','Jul.','Ago.','Sep.','Oct.','Nov.','Dic.'];
			for(i=0;i<2;i++){
				//alert("meses-length: "+meses.length);
				for(j=0;j<meses.length;j++){
					var elem=document.getElementById(meses[j]+i);
					elem.setAttribute("name","mes"+i+"[]");
				}
			}
		</script>
	</div>
</div>
