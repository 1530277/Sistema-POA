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
			$query=$conn->prepare("SELECT * FROM partidas");
			$query->execute();
			$array_consulta1=$query->fetchAll();
		}catch(PDOException $e) {
			echo "Mensaje-Error: ".$e->getMessage();
		}
?>
<div class = "container">
	<div class="wrapper">
		<form class="form-signin" method="post">
			<?php
				if(isset($_POST['btn_save'])){
					if(count($array_consulta1)==0)
						echo "<div class='alert alert-danger' role='alert' name='notify'>Se requiere hacer almenos el registro de una Partida.</div><hr name='notify'>";
					else
						echo "<div class='alert alert-success' role='alert' name='notify'>Los datos se han guardado correctamente.</div><hr name='notify'>";
					include 'oculta_notificacion.php';
				}
			?>
			<input class="form-control" type="text" maxlength="20" value="" name="clave" id="clave" required="" placeholder="Clave">
			<input class="form-control" type="text" maxlength="20" value="" name="nombre" id="n
			ombre" required="" placeholder="Nombre">
			<input class="form-control" type="number" min="0" placeholder="Precio (pesos):" name=precio required="">
			<hr><span class="badge verdesito">Elegir Partida</span>
			<select class="form-control form-control-lg" id=select_partida name=select_partida>
				<?php
					for($i=0;$i<count($array_consulta1);$i++)
						echo"<option id=".$array_consulta1[$i][0].">".$array_consulta1[$i][1]."</option>";
					if(count($array_consulta1)==0)
						echo"<option id=default>No hay registros</option>";
				?>
			</select>
			<select class="form-control form-control-lg" id=select_unidad name=select_unidad>
				<option>Kilogramo</option>
				<option>Piezas</option>
				<option>Caja</option>
				<option>Otro</option>
			</select>
			<input type="text" class="form-control ocultar" name="otra_opc" id=otra_opc minlength="0" maxlength="20" placeholder="Otro tipo de unidad:">
			<button class="form-control btn btn-primary verdesito" name="btn_save" id=btn_save>Guardar cambios</button>
		</form>
	</div>
	<script type="text/javascript">
		function cambia_unidad(){
			var unidad_val=document.getElementById("select_unidad").value;
			if(unidad_val=="Otro"){
				document.getElementById("otra_opc").className="form-control";
				document.getElementById("otra_opc").required=true;
			}
			else{
				document.getElementById("otra_opc").className="form-control ocultar";
				document.getElementById("otra_opc").required=false;
			}
		}
		window.onload=cambia_unidad;
		document.getElementById("select_unidad").addEventListener("change",cambia_unidad);
	</script>
</div>
<?php
	if(isset($_REQUEST['btn_save'])){
		$id_material=$_REQUEST['clave'];
		$nombre=$_REQUEST['nombre'];
		$id_partida=$_REQUEST['select_partida'];
		$unidad=$_REQUEST['select_unidad'];

		if($unidad=="Otro")
			$unidad=$_REQUEST['otra_opc'];
		
		$precio=$_REQUEST['precio'];
		if(count($array_consulta1)>0){
			//En función del nombre de la partida mostrado en el select se asigna el id_partida correspondiente al nombre ya que es el que conforma la consulta, no el nombre
			for($i=0;$i<count($array_consulta1);$i++){
				if($array_consulta1[$i]["nombre"]==$id_partida){
					$id_partida=$array_consulta1[$i]["id_partida"];
					break;
				}
			}
			try {
		    	$query=$conn->prepare("INSERT INTO materiales(clave,nombre,id_partida,unidad,precio) values(:clave,:nombre,:id_partida,:unidad,:precio)");
		    		$query->bindParam(":clave",$id_material);
		    		$query->bindParam(":nombre",$nombre);
		    		$query->bindParam(":id_partida",$id_partida);
					$query->bindParam(":unidad",$unidad);
					$query->bindParam(":precio",$precio);
					$query->execute();
					//$array_consulta2=$query->fetchAll();
		    	}catch(PDOException $e) {
		    		echo "Mensaje-Error: ".$e->getMessage();
				}
		}
	}
?>