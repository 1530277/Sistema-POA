<?
	require_once("valida_sesion.php");
	require_once("menu.php");
	require_once("agregar_css.php");
	require_once("oculta_notificacion.php");
?>
<?php
	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "sistema_poa";
	try {
		$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		//Consulta para jalar datos de la tabla proyectos
		$query=$conn->prepare("SELECT * FROM proyectos");
		$query->execute();
		$consulta_array_proyectos=$query->fetchAll();
		$respaldo_proyectos=$consulta_array_proyectos;//clave,nombre,id_empleado,id_area,justificacion,objetivo,metas,indicador_resultados,id_programa,descripcion
		$json_proyectos=json_encode($respaldo_proyectos);

		//Consulta para jalar datos de la tabla areas
		$query=$conn->prepare("SELECT * FROM areas");
		$query->execute();
		$consulta_array_areas=$query->fetchAll();//id_area,nombre_area,encargado,depende_de(id_area)
		$respaldo_areas=$consulta_array_areas;
		$json_areas=json_encode($respaldo_areas);

		//Consulta tabla proyectos_materiales
		$query=$conn->prepare("SELECT * FROM proyectos_materiales");
		$query->execute();
		$consulta_array_proyectos_materiales=$query->fetchAll();
		$respaldo_proye_mate=$consulta_array_proyectos_materiales;//id_proyecto,id_material,cantidad,subtotal
		$json_pro_mate=json_encode($respaldo_proye_mate);

		//Consulta tabla materiales
		$query=$conn->prepare("SELECT * FROM materiales");
		$query->execute();
		$consulta_array_materiales=$query->fetchAll();//clave, nombre, id_partida, unidad, precio
		$respaldo_materiales=$consulta_array_materiales;
		$json_materiales=json_encode($respaldo_materiales);

		//Consulta tabla partidas
		$query=$conn->prepare("SELECT * FROM partidas");
		$query->execute();
		$consulta_array_partidas=$query->fetchAll();
		$respaldo_partidas=$consulta_array_partidas;
		$json_partidas=json_encode($respaldo_partidas);

	}catch(PDOException $e){
		echo "Mensaje-Error: ".$e->getMessage();
	}
?>
<div class="container">
	<div class="wrapper">
		<form class="form-signin" method="post">
			<div class="inner-div form-control">
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
				<div id="nombre_proyecto" name=nombre_proyecto class="form-control alert"></div>
			</div>

			<?if(count($consulta_array_proyectos)!=0){?>
				<div class="form-control alert alert-info" id="notify" name=notify>
					<span class="glyphicon glyphicon-asterisk"><b>Nota: </b></span>
					El fin de una requisición es llevar el control de los materiales que anteriormente se habían solicitado. Es decir, no es necesario hacer una requisición de todos los materiales contemplados para un proyecto, se puede hacer una requisición de una parte del total de los materiales contemplados para un proyecto en específico.
				</div>
				<div class="form-control inner-div">
					<span class="badge verdesito">Materiales del proyecto:</span>
					<div id="materiales_proyecto" class="form-control"></div>
				</div>
			<?}?>

			<button class="btn btn-primary form-control verdesito" id="btn-save" name="btn-save">Guardar</button>
			<script type="text/javascript">
				//Función que muestra un formato para los materiales correspondientes al proyecto elegído
				function muestra_formato(){
					var json_areas=eval(<?php echo $json_areas;?>);
					var json_proyectos_materiales=eval(<?php echo $json_pro_mate;?>);//id_proyecto,id_material,cantidad,subtotal
					var json_materiales=eval(<?php echo $json_materiales;?>);//clave, nombre, id_partida, unidad, precio
					var json_partidas=eval(<? echo $json_partidas;?>);
					var id_proyecto=document.getElementById("proyectos").value;
					var str_innerHTML="<table class='table'>";
						str_innerHTML+="<thead class='thead-dark'>";
				    str_innerHTML+="<tr>";
				      str_innerHTML+="<th scope='col'>Clave</th>";
				      str_innerHTML+="<th scope='col'>Nombre</th>";
				      str_innerHTML+="<th scope='col'>Unidad</th>";
				      str_innerHTML+="<th scope='col'>Precio</th>";
				      str_innerHTML+="<th scope='col'>Partida</th>";
				      str_innerHTML+="<th scope='col'>Cantidad requerida</th>";
				    str_innerHTML+="</tr>";
				  	str_innerHTML+="</thead>";
				  	str_innerHTML+="<tbody>";
				  	for(i=0;i<json_proyectos_materiales.length;i++)
				  		if(json_proyectos_materiales[i].id_proyecto==id_proyecto){
				  			for(j=0;j<json_materiales.length;j++){
				  			//Se recorren todos los elementos en la tabla proyectos_materiales y donde coincida con el id_proyecto del elemento "select" entra al if para después comparar el id_material de la celda en tiempo de ejecución y buscar los datos en la tabla materiales
				  				if(json_proyectos_materiales[i].id_material==json_materiales[j].clave){
										str_innerHTML+="<th scope='row'>"+json_materiales[i].clave+"</th>";
										str_innerHTML+="<td>"+json_materiales[j].nombre+"</td>";
										str_innerHTML+="<td>"+json_materiales[j].unidad+"</td>";
										str_innerHTML+="<td>"+json_materiales[j].precio+"</td>";
										for(k=0;k<json_partidas.length;k++)//En función del id_partida en la tabla materiales se busca el nombre de la misma en la tabla partidas
											if(json_materiales[j].id_partida==json_partidas[k].id_partida){
												str_innerHTML+="<td>"+json_partidas[j].nombre+"</td>";
												break;
											}
										var id_mat_proy=json_proyectos_materiales[i].id_proyecto+"_"+json_proyectos_materiales[i].id_material;
										str_innerHTML+="<td><input name='"+id_mat_proy+"' type='number' class='form-control' placeholder='0' min=0 max='"+json_proyectos_materiales[i].cantidad+"'></td>";
									}
								}
							}
					str_innerHTML+="</tbody>";
					str_innerHTML+="</table>";
					document.getElementById("materiales_proyecto").innerHTML=str_innerHTML;
				}
				//Función que muestra el id/clave del proyecto para posteriormente cargar en un div la información correspondiente a éste
				function cambia_select_proyectos(){
					var json_array=eval(<?php echo $json_proyectos;?>);//Esta linea trae el json_array de php a javascript
					var json_areas=eval(<?php echo $json_areas;?>);//Esta línea trae el json_areas de php a javascript
					var select_proyecto=document.getElementById("proyectos").value;

					//Si existen elementos en el arreglo con la consulta de la tabla de proyectos entonces dependiendo del id_proyecto se actualizarán los datos del proyecto elegido para que el usuario pueda observar acerca de cual proyecto se hará la requisición
					for(i=0;i<json_array.length;i++)
						if(select_proyecto==json_array[i].clave){
							var str_innerHTML="Datos del proyecto:<br>";
							str_innerHTML+="<div class='form-control alert-info'>";
							str_innerHTML+="<b>Nombre del proyecto: </b>"+json_array[i].nombre+"<br>";
							str_innerHTML+="<b>Objetivo del proyecto: </b>"+json_array[i].objetivo+"<br>";
							str_innerHTML+="<b>Descripción del proyecto: </b>"+json_array[i].descripcion+"<br>";
							str_innerHTML+="<b>Clave del encargado del proyecto: </b>"+json_array[i].id_empleado+"<br>";
							str_innerHTML+="<b>Metas del proyecto: </b>"+json_array[i].descripcion+"<br>";
							str_innerHTML+="<b>Clave del área a la que pertenece el proyecto:</b> "+json_array[i].id_area+"<br>";
							for(j=0;j<json_areas.length;j++)
								if(json_areas[j].id_area==json_array[i].id_area)
									str_innerHTML+="<b>Nombre del área a la que pertenece el proyecto: </b>"+json_areas[j].nombre_area;
							str_innerHTML+="</div>";
							document.getElementById("nombre_proyecto").innerHTML=str_innerHTML;
							document.getElementById("nombre_proyecto").className="alert alert-info";
						}
					//Sino hay elementos en el arreglo que tiene la consulta de proyectos entonces se muestra un mensaje informando del problema
					if(json_array.length==0){
						var str_innerHTML="<label class='form-control alert-danger'>Se requiere hacer almenos el registro de un elemento 'Proyectos' para agregar elementos en esta sección.</label>";
						document.getElementById("nombre_proyecto").innerHTML=str_innerHTML;
						document.getElementById("nombre_proyecto").className="alert alert-danger";
					}
					muestra_formato();//Cada que cambie de proyecto cargará los datos del mismo
				}
				function al_cargar(){
					cambia_select_proyectos();
				}
				document.getElementById("proyectos").addEventListener("change",cambia_select_proyectos);
				window.onload=al_cargar;
			</script>
		</form>
	</div>
</div>
<?
	if($_REQUEST['btn-save']){
		//Se valida los materiales pertenecientes al proyecto en "tiempo real" y si tienen algo distinto a "", 0 y "0" (!empty())
		$array_materiales_requeridos=[];
		for($i=0,$j=0;$i<count($consulta_array_proyectos_materiales);$i++){
			$key=$consulta_array_proyectos_materiales[$i]["id_proyecto"]."_".$consulta_array_proyectos_materiales[$i]["id_material"];
			if(!empty($_REQUEST[$key])){
				$array_materiales_requeridos[$j]=$consulta_array_proyectos_materiales[$i];
				$j++;
			}
		}
		if(count($array_materiales_requeridos)!=0&&count($consulta_array_proyectos)!=0){
			try{
				for($i=0;$i<count($array_materiales_requeridos);$i++){
					$query=$conn->prepare("SELECT * FROM requisiciones");
					$query->execute();
					$id_requisicion=count($query->fetchAll());
					$id_requisicion++;
					$id_proyecto=$_REQUEST['proyectos'];
					$id_material=$array_materiales_requeridos[$i]["id_material"];
					//Busca el id_area del proyecto en la tabla proyectos
					for($m=0;$m<count($consulta_array_proyectos);$m++)
						if($consulta_array_proyectos[$m]["clave"]==$id_proyecto)
							$id_area=$consulta_array_proyectos[$m]["id_area"];
					//Fin busqueda
					$key=$array_materiales_requeridos[$i]["id_proyecto"]."_".$array_materiales_requeridos[$i]["id_material"];
					$cantidad_total_materiales=$_REQUEST[$key];
					//Busca el precio del material "x" en la tabla materiales
					for($m=0;$m<count($consulta_array_materiales);$m++)
						if($consulta_array_materiales[$m]["clave"]==$array_materiales_requeridos[$j]["id_material"])
							$precio_unitario_material=$consulta_array_materiales[$m]["precio"];
					//Fin busqueda
					$importe_total=floatval($cantidad_total_materiales)*floatval($precio_unitario_material);
					$fecha_requisicion=date("Y/m/d");
					$estado="No aceptado";
					$query=$conn->prepare("INSERT INTO requisiciones(id_requisicion,id_proyecto,id_material,id_area,cantidad,importe,fecha_requisicion,estado)
					 VALUES(:id_requisicion,:id_proyecto,:id_material,:id_area,:cantidad,:importe,:fecha_requisicion,:estado)");
					$query->bindParam(":id_requisicion",$id_requisicion);
					$query->bindParam(":id_proyecto",$id_proyecto);
					$query->bindParam(":id_material",$id_material);
					$query->bindParam(":id_area",$id_area);
					$query->bindParam(":cantidad",$cantidad_total_materiales);
					$query->bindParam(":importe",$importe_total);
					$query->bindParam(":fecha_requisicion",$fecha_requisicion);
					$query->bindParam(":estado",$estado);
					$query->execute();

					$proyect_modified_quantity_material=floatval($array_materiales_requeridos[$i][""])
					$query=$conn->prepare("UPDATE proyectos_materiales SET ")
				}
			}catch(PDOException $e){
				echo "<div class='form-control alert-danger'>".$e->getMessage()."</div>";
			}
		}
	}
?>
