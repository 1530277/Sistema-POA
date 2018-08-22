<?
	require_once("valida_sesion.php");
	require_once("menu.php");
	require_once("agregar_css.php");
?>
<?php
	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "sistema_poa";
	try {
		$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
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
			<?php	//Valida POST del boton guardar
				if(isset($_POST['btn-guardar'])&&count($consulta_array_areas)!=0){
					echo "<div class='form-control alert alert-success' role='alert' name='notify'>Los datos se han guardado correctamente.</div>";
					//echo $_POST['descripcion']." ".$_POST['nombre']." ".$_POST['id_area'];
				}
				if(isset($_POST['btn-guardar'])&&count($consulta_array_areas)==0)
					echo"<div class='form-control alert alert-danger' role='alert' name='notify'No se han guardado cambios.</div>";
			?>
			<input type="text" class="form-control" placeholder="Nombre del puesto" maxlength="20" name="nombre" id="nombre" required="">
			<textarea class="form-control" name="descripcion" placeholder="Descripción" required=""></textarea>
			<div class="form-control inner-div">
				<span class="badge verdesito">Áreas:</span>
				<select id="id_area" name="id_area" class="form-control">
					<?php
						for($i=0;$i<count($consulta_array_areas);$i++){
							echo "<option value='".$consulta_array_areas[$i]["id_area"]."'>".$consulta_array_areas[$i]["id_area"]."</option>";
						
						}
						if(count($consulta_array_areas)==0)
							echo "<option value='No hay elementos Área registrados.'>No hay elementos Área registrados.</option>";
					?>
				</select>
				<?php
						echo "<div class='alert alert-danger' role='alert' id='noti' name='noti'>Se requiere hacer almenos el registro de un elemento Áreas para agregar elementos en esta sección.</div><hr name='noti'>";
				?>
				<script type="text/javascript">
					function cambia_select(){
						var json_areas=eval(<?php echo $json_areas; ?>);
						var id_area_val=document.getElementById("id_area").value;
						var str_html="";
						for(j=0;j<json_areas.length;j++){
							if(json_areas[j].id_area==id_area_val){
								str_html="<label class='form-control alert-info'><b>Nombre del area: </b>"+json_areas[j].nombre_area+"</label>";
							}
						}
						if(json_areas.length!=0){
							document.getElementById("noti").innerHTML=str_html;
							document.getElementById("noti").className="alert alert-info";
						}
						else{
							str_html="Se requiere hacer almenos el registro de un elemento 'Áreas' para agregar elementos en esta sección.";
							document.getElementById("noti").className="alert alert-danger";
						}
					}
					document.getElementById("id_area").addEventListener("change",cambia_select);
					window.onload=cambia_select;
				</script>
			</div><br>
			<button class="btn btn-primary form-control verdesito" id="btn-guardar" name="btn-guardar">Guardar</button>
		</form>
	</div>
</div>

<?php
	if(isset($_REQUEST['btn-guardar'])&&count($consulta_array_areas)>0){
		try{
			$msql=$conn->prepare("SELECT * FROM puestos");
			$msql->execute();
			$array_puestos=$msql->fetchAll();
			$id_puesto=count($array_puestos)+1;
			$nombre=$_REQUEST['nombre'];
			$descripcion=$_REQUEST['descripcion'];
			$id_area=$_REQUEST['id_area'];
			$query=$conn->prepare("INSERT INTO puestos(id_puesto,nombre,descripcion,id_area) VALUES(:id_puesto,:nombre,:descripcion,:id_area)");
			$query->bindParam(":id_puesto",$id_puesto);
			$query->bindParam(":nombre",$nombre);
			$query->bindParam(":descripcion",$descripcion);
			$query->bindParam(":id_area",$id_area);
			$query->execute();
		}catch(PDOException $e){
			echo "Message-error: ".$e->getMessage();
		}
	}
?>