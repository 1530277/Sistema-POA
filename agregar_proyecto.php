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

		//Sentencias para crear arreglo con los identificadores de la tabla 'areas'
		$query=$conn->prepare("SELECT id_area FROM areas");
		$query->execute();
		$array_consulta_idarea=$query->fetchAll();

		//Sentencias para crear arreglo con los identificadores de la tabla 'empleados'
		$query=$conn->prepare("SELECT numero_empleado FROM empleados");
		$query->execute();
		$array_consulta_idemp=$query->fetchAll();

		//Sentencias para crear arreglo con los identificadores de la tabla 'programas'
		$query=$conn->prepare("SELECT id_programa FROM programas");
		$query->execute();
		$array_consulta_idprogras=$query->fetchAll();

		//Sentencia para crear un arreglo con todos los elementos de la tabla materiales
		$query=$conn->prepare("SELECT * FROM materiales");
		$query->execute();
		$array_consulta_materiales=$query->fetchAll();
		$array_consulta_nombrepartida=[];
		//Respaldo el id_partida en otro arreglo, donde posteriormente se consiguen los nombres correspondientes al id
		//¿Para qué esto? Se consideró que es más comprensible ver el nombre que el id, en esta ocasión
		for($i=0;$i<count($array_consulta_materiales);$i++)
			$array_consulta_nombrepartida[$i]=$array_consulta_materiales[$i][2];

		//Se llama a una función en la bd que trae el nombre de la partida según el parámetro que es el id_partida y se almacena en el arreglo de nombres de partidas para mostrarse en la tablita de abajo
		for($i=0;$i<count($array_consulta_materiales);$i++){
			$query=$conn->prepare("CALL nombre_partida(?)");
			$variable=$array_consulta_nombrepartida[$i];//Solo una variable se puede pasar por referencia, por eso no uso el vector como parámetro
			$query->bindParam(1,$variable);
			$query->execute();
			$eje=$query->fetchAll();
			$array_consulta_nombrepartida[$i]=$eje[0];
		}
	}catch(PDOException $e){
		echo "Mensaje-Error: ".$e->getMessage();
	}
?>

<style type="text/css">
	.non-disp{
		display: none;
	}
</style>
<div class = "container">
	<div class="wrapper">
		<form class="form-signin" method="post">
			<?php
				if(isset($_POST['btn-save'])){
					$cont=0;

					if(count($array_consulta_idemp)!=0){
						echo"<div class='alert alert-danger' role='alert' name='notify'>Se requiere hacer almenos el registro de un elemento Empleado.</div><hr name='notify'>";$cont++;
					}
					if(count($array_consulta_materiales)!=0){
						echo"<div class='alert alert-danger' role='alert' name='notify'>Se requiere hacer almenos el registro de un elemento Material.</div><hr name='notify'>";$cont++;
					}
					if(count($array_consulta_idprogras)!=0){
						echo"<div class='alert alert-danger' role='alert' name='notify'>Se requiere hacer almenos el registro de un elemento Programa.</div><hr name='notify'>";$cont++;
					}
					if(count($array_consulta_idarea)!=0){
						echo"<div class='alert alert-danger' role='alert' name='notify'>Se requiere hacer almenos el registro de un elemento Área.</div><hr name='notify'>";$cont++;
					}
					if($cont==0){
						echo "<div class='alert alert-success' role='alert' name='notify'>Los datos se han guardado correctamente.</div><hr name='notify'>";
					}
					include 'oculta_notificacion.php';
				}
			?>
			<input type="text" class="form-control" name="clave" placeholder="Clave del proyecto:" required maxlength="20">

			<textarea class="form-control" type="text" maxlength="100" value="" name="nombre" id="nombre" required="" placeholder="Nombre del proyecto"></textarea>

			<span class="badge verdesito">Empleado (Elegir código):</span>
			<select class="form-control" type="text" maxlength="20" value="" name="id_empleado" id="id_empleado" required="">
				<?php
				for($i=0;$i<count($array_consulta_idemp);$i++)
					echo"<option value=".$array_consulta_idemp[$i][0].">".$array_consulta_idemp[$i][0]."</option>";
				if(count($array_consulta_idemp)==0)
					echo"<option value='No hay registros'>No hay registros</option>";
				?>
			</select>

			<span class="badge verdesito">Área (Elegir código):</span>
			<select class="form-control" type="text" maxlength="20" value="" name="id_area" id="id_area" required="">
				<?php
				for($i=0;$i<count($array_consulta_idarea);$i++)
					echo"<option value=".$array_consulta_idarea[$i][0].">".$array_consulta_idarea[$i][0]."</option>";
				if(count($array_consulta_idarea)==0)
					echo"<option value='No hay registros'>No hay registros</option>";
				?>
			</select>

			<span class="badge verdesito">Programa (Elegir clave):</span>
			<select class="form-control" type="text" maxlength="20" value="" name="id_programa" id="id_programa" required="">
				<?php
				for($i=0;$i<count($array_consulta_idprogras);$i++)
					echo"<option value=".$array_consulta_idprogras[$i][0].">".$array_consulta_idprogras[$i][0]."</option>";
				if(count($array_consulta_idprogras)==0)
					echo"<option value='No hay registros'>No hay registros</option>";
				?>
			</select>

			<textarea class="form-control" type="text" maxlength="100" value="" name="descripcion" id="descripcion" required="" placeholder="Descripción del proyecto"></textarea>

			<textarea class="form-control" type="text" maxlength="100" value="" name="justificacion" id="justificacion" required="" placeholder="Justificación del proyecto"></textarea>

			<textarea class="form-control" type="text" maxlength="100" value="" name="objetivo" id="objetivo" required="" placeholder="Objetivo del proyecto"></textarea>

			<textarea class="form-control" type="text" maxlength="100" value="" name="metas" id="metas" required="" placeholder="Metas"></textarea>

			<textarea class="form-control" type="text" maxlength="100" value="" name="indicador_resultados" id="indicador_resultados" required="" placeholder="Indicador de resultados"></textarea>

			<span class="badge verdesito">Materiales (Recursos necesarios para el proyecto)</span>
			<div class="form-control inner-div">
				<table class="table">
				  <thead class="thead-dark">
				    <tr>
				      <th scope="col">Clave</th>
				      <th scope="col">Nombre</th>
				      <th scope="col">Unidad</th>
				      <th scope="col">Precio</th>
				      <th scope="col">Partida</th>
				      <th scope="col">Cantidad</th>
				    </tr>
				  </thead>
				  <tbody>
				  	<?
				  		for($i=0;$i<count($array_consulta_materiales);$i++){
								echo "<tr>";
				  			echo "<th scope='row'>".$array_consulta_materiales[$i]["clave"]."</th>";
				  			echo "<td>".$array_consulta_materiales[$i]["nombre"]."</th>";
				  			echo "<td>".$array_consulta_materiales[$i]["unidad"]."</th>";
				  			echo "<td>".$array_consulta_materiales[$i]["precio"]."</th>";
				  			echo "<td>".$array_consulta_nombrepartida[$i]["nombre"]."</th>";
				  			echo '<td><input type="number" id="n_'.$array_consulta_materiales[$i]["clave"].'" name="n_'.$array_consulta_materiales[$i]["clave"].'" class="form-control" min="0" placeholder="0"></td>';
				  			echo "</tr>";
				  		}
				  		if(count($array_consulta_materiales)==0)
				  			echo"<div class='alert alert-danger' role='alert' name='alerta'>No hay materiales registrados en el sistema.</div><hr name='alerta'>";
				  	?>
				  </tbody>
				</table>
			</div>

			<button class="btn btn-primary form-control verdesito" id="btn-save" name="btn-save">Guardar</button>
		</form>
	</div>
</div>

<?
	$cont=0;
	if(count($array_consulta_idemp)!=0)
		$cont++;
	if(count($array_consulta_materiales)!=0)
		$cont++;
	if(count($array_consulta_idprogras)!=0)
		$cont++;
	if(count($array_consulta_idarea)!=0)
		$cont++;
	$proyecto_materiales=[];
	if(isset($_REQUEST['btn-save'])){
		for($i=0,$j=0;$i<count($array_consulta_materiales);$i++){
			$key=$array_consulta_materiales[$i]["clave"];
			$cantidad=$_REQUEST["n_".$key];
			if($cantidad!=""&&$cantidad!="0"&&floatval($cantidad)>0){
				$proyecto_materiales[$j]=$array_consulta_materiales[$i];
				$j++;
			}
		}
	}
	if(count($proyecto_materiales)!=0)
		$cont++;

	if(isset($_REQUEST['btn-save'])&&$cont==5){
		//Inicializa variables - guardar datos correspondientes a la tabla de proyectos
		try{
			$clave=$_REQUEST['clave'];
			$nombre=$_REQUEST['nombre'];
			$id_empleado=$_REQUEST['id_empleado'];
			$id_area=$_REQUEST['id_area'];
			$justificacion=$_REQUEST['justificacion'];
			$objetivo=$_REQUEST['objetivo'];
			$metas=$_REQUEST['metas'];
			$indicador_resultados=$_REQUEST['indicador_resultados'];
			$id_programa=$_REQUEST['id_programa'];
			$descripcion=$_REQUEST['descripcion'];

			$query=$conn->prepare("INSERT INTO proyectos(clave,nombre,id_empleado,id_area,justificacion,objetivo,metas,indicador_resultados,id_programa,descripcion)
			VALUES(:clave,:nombre,:id_empleado,:id_area,:justificacion,:objetivo,:metas,:indicador_resultados,:id_programa,:descripcion)");
			$query->bindParam(":clave",$clave);
			$query->bindParam(":nombre",$nombre);
			$query->bindParam(":id_empleado",$id_empleado);
			$query->bindParam(":id_area",$id_area);
			$query->bindParam(":justificacion",$justificacion);
			$query->bindParam(":objetivo",$objetivo);
			$query->bindParam(":metas",$metas);
			$query->bindParam(":indicador_resultados",$indicador_resultados);
			$query->bindParam(":id_programa",$id_programa);
			$query->bindParam(":descripcion",$descripcion);

			$query->execute();

			$query=$conn->prepare("INSERT INTO proyectos_materiales(id_proyecto,id_material,cantidad,subtotal)
			VALUES(:id_proyecto,:id_material,:cantidad,:subtotal)");
			//Ciclo que ejecuta el guardar datos en la tabla proyectos_materiales
			for($i=0;$i<count($proyecto_materiales);$i++){
					$query->bindParam(":id_proyecto",$clave);
					$query->bindParam(":id_material",$proyecto_materiales[$i]["clave"]);
					$query->bindParam(":cantidad",$_REQUEST["n_".$proyecto_materiales[$i]["clave"]]);
					$subtotal=floatval($_REQUEST["n_".$proyecto_materiales[$i]["clave"]])*floatval($proyecto_materiales[$i]["precio"]);
					$query->bindParam(":subtotal",$subtotal);
					$query->execute();
			}
		}catch(PDOException $e){
			echo "Message-Error: ".$e;
		}

	}
?>
