<?php
	include 'valida_sesion.php';
	include 'menu.php';
	require_once'agregar_css.php';
?>
<?
	try{
		$servername = "localhost";
		$username = "root";
		$password = "";
		$dbname = "sistema_poa";
		$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
		$query=$conn->prepare("SELECT * FROM puestos");
		$query->execute();
		$consulta_array_puestos=$query->fetchAll();
		$respaldo_puestos=$consulta_array_puestos;
		$json_puestos=json_encode($respaldo_puestos);

		$query=$conn->prepare("SELECT * FROM areas");
		$query->execute();
		$consulta_array_areas=$query->fetchAll();
		$respaldo_areas=$consulta_array_areas;
		$json_areas=json_encode($respaldo_areas);
		
	}catch(PDOException $e){
		echo "Mensaje-Error: ".$e->getMessage();
	}
?>
<div class="container">
	
	<div class="wrapper">
		<form class="form-signin" method="post">
			<?php
				if(isset($_POST['btn-guardar'])){
					if(count($consulta_array_puestos)!=0){
						echo "<div class='alert alert-success' name='notify'>Los datos se han guardado correctamente.</div><hr name='notify'>";
						include 'oculta_notificacion.php';
						echo "datos: ".$_POST['id_empleado'].", ".$_POST['puesto'];
					}
				}
			?>
			<hr><span class="badge verdesito">Número identificador del empleado:</span>
			<input class="form-control" type="number" min="0" maxlength="10" value="" name="id_empleado" id="id_empleado" required="" placeholder="Ejemplo: 12345">
			
			<hr><span class="badge verdesito">Nombre del empleado</span>
			<input class="form-control" type="text" maxlength="30" value="" name="nombre" id="nombre" required="" placeholder="Nombre">

			<input class="form-control" type="text" maxlength="20" value="" name="paterno" id="paterno" required="" placeholder="Apellido Paterno">

			<input class="form-control" type="text" maxlength="20" value="" name="materno" id="materno" required="" placeholder="Apellido Materno">
		
			<hr><span class="badge verdesito">Dirección</span>
			<input class="form-control" type="text" maxlength="20" value="" name="calle" id="calle" required="" placeholder="Calle">

			<input class="form-control" type="text" maxlength="30" value="" name="col_frac" id="col_frac" required="" placeholder="Colonia o fraccionamiento">

			<input class="form-control" type="text" maxlength="10" value="" name="n_casa" id="n_casa" required="" placeholder="Número de casa">
			
			<hr><span class="badge verdesito">Contacto</span>
			<input class="form-control" type="text" maxlength="15" value="" name="telefono" id="telefono" required="" placeholder="Teléfono">
			<input class="form-control" type="text" maxlength="20" value="" name="correo" id="coreo" required="" placeholder="Correo electrónico">

			<hr><span class="badge verdesito">Otros datos</span>
			<input class="form-control" type="text" maxlength="20" value="" name="curp" id="curp" required="" placeholder="CURP">

			<input class="form-control" type="text" maxlength="24" value="" name="numero_seguro" id="numero_seguro" required="" placeholder="Número de seguro">

			<input class="form-control" type="date" value="" name="fecha_entrada" id="fecha_entrada" required="" placeholder="Colonia o fraccionamiento">

			<div class="form-control inner-div" id=div_puesto>
				<span class="badge verdesito">Puesto (id del puesto):</span>
				<select class=form-control name="puesto" id="puesto">
					<?
						for($i=0;$i<count($consulta_array_puestos);$i++)
							echo"<option value='".$consulta_array_puestos[$i]["id_puesto"]."'>".$consulta_array_puestos[$i]["id_puesto"]."</option>";
						if(count($consulta_array_puestos)==0)
							echo "<option value='No hay elementos registrados tipo 'Puesto de empleado'>No hay elementos registrados tipo Puesto de empleado</option>";
					?>
				</select>
				<?
					echo "<div class='' role='alert' id=noti name='noti'></div><hr name='noti'>";
				?>
				<script type="text/javascript">

					function cambia_select(){
						var json_array=eval(<?php echo $json_puestos; ?>);
						var json_areas=eval(<? echo $json_areas; ?>);
						var id_puesto_val=document.getElementById("puesto").value;
						var str_html="";
						for(i=0;i<json_array.length;i++)
							if(json_array[i].id_puesto==id_puesto_val){
								str_html+="Datos del puesto:"+json_array[i].id_puesto+"<br>"
								str_html+="<div class='form-control alert-info'>";
								str_html+="<b>Nombre del puesto: </b>"+json_array[i].nombre+"<br>";
								str_html+="<b>Descripción: </b>"+json_array[i].descripcion+"<br>";
								str_html+="</div>";
								for(j=0;j<json_areas.length;j++)
									if(json_array[i].id_area==json_areas[j].id_area){
										str_html+="<div class='form-control alert-info'>";
										str_html+="<b>Puesto pertenece al area: </b>"+json_areas[i].nombre_area+"<br>";
										str_html+="<b>Clave del area a la cual pertenece el puesto: </b>"+json_areas[i].id_area+"<br>";
										str_html+="</div>";
									}
								document.getElementById("noti").innerHTML=str_html;
								document.getElementById("noti").className="alert alert-info";
							}
						if(json_array.length==0){
							str_html+="Se requiere hacer almenos el registro de un elemento Puesto para agregar elementos en esta sección.";
							document.getElementById("noti").innerHTML=str_html;
							document.getElementById("noti").className="alert alert-danger";
						}
					}
					document.getElementById("puesto").addEventListener("change",cambia_select);
					window.onload=cambia_select; 

				</script>
			</div><br>
			<button class="btn btn-primary form-control verdesito" id="btn-guardar" name="btn-guardar">Guardar</button>
			
		</form>
	</div>
	<?php
		if(isset($_REQUEST['btn-guardar'])){
			//Inicializa variables para accionar consulta de guardado
				try{
				$id_empleado=$_REQUEST['id_empleado'];
				$nombre=$_REQUEST['nombre'];
				$paterno=$_REQUEST['paterno'];
				$materno=$_REQUEST['materno'];
				$calle=$_REQUEST['calle'];
				$col_frac=$_REQUEST['col_frac'];
				$n_casa=$_REQUEST['n_casa'];
				$telefono=$_REQUEST['telefono'];
				$correo=$_REQUEST['correo'];
				$curp=$_REQUEST['curp'];
				$numero_seguro=$_REQUEST['numero_seguro'];
				$fecha_entrada=$_REQUEST['fecha_entrada'];
				$id_puesto=$_REQUEST['puesto'];
				//Variables conexion-servidor
				
				//Guarda en tabla empleados
				$query=$conn->prepare("INSERT INTO empleados(numero_empleado, nombre, apellido_paterno, apellido_materno, calle, colonia_fraccionamiento, numero_casa, telefono, correo, curp, numero_seguro, fecha_ingreso) VALUES (:id_empleado, :nombre, :paterno, :materno, :calle, :col_frac, :n_casa, :telefono, :correo, :curp, :numero_seguro, :fecha_entrada)");

				$query->bindParam(":id_empleado",$id_empleado);
				$query->bindParam(":nombre",$nombre);
				$query->bindParam(":paterno",$paterno);
				$query->bindParam(":materno",$materno);
				$query->bindParam(":calle",$calle);
				$query->bindParam(":col_frac",$col_frac);
				$query->bindParam(":n_casa",$n_casa);
				$query->bindParam(":telefono",$telefono);
				$query->bindParam(":correo",$correo);
				$query->bindParam(":curp",$curp);
				$query->bindParam(":numero_seguro",$numero_seguro);
				$query->bindParam(":fecha_entrada",$fecha_entrada);
				$query->execute();

				//Guarda en tabla empleados_puestos, para relacionar al empleado registrado con un puesto en la institución
				$query=$conn->prepare("INSERT INTO empleados_puestos(id_empleado,id_puesto) VALUES(:id_empleado,:id_puesto)");
				
				$query->bindParam(":id_empleado",$id_empleado);
				$query->bindParam(":id_puesto",$id_puesto);
				$query->execute();
			}catch(PDOException $e){
				echo "Error-Message: ".$e->getMessage();
			}
			//$array_consulta2=$query->fetchAll();
		}    	
	?>
</div>