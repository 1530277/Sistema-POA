<?php
/*
<html>
	<head>
		<title>Menu Desplegable</title>
		<style type="text/css">
			
			* {
				margin:0px;
				padding:0px;
			}
			
			#header {
				margin:auto;
				width:500px;
				font-family:Arial, Helvetica, sans-serif;
			}
			
			ul, ol {
				list-style:none;
			}
			
			.nav {
				width:500px; /*Le establecemos un ancho
				margin:0 auto; /*Centramos automaticamente
			}

			.nav > li {
				float:left;
			}
			
			.nav li a {
				background-color:#000;
				color:#fff;
				text-decoration:none;
				padding:10px 12px;
				display:block;
			}
			
			.nav li a:hover {
				background-color:#434343;
			}
			
			.nav li ul {
				display:none;
				position:absolute;
				min-width:140px;
			}
			
			.nav li:hover > ul {
				display:block;
			}
			
			.nav li ul li {
				position:relative;
			}
			
			.nav li ul li ul {
				right:-140px;
				top:0px;
			}
			
		</style>
	</head>
	<body>
		<div id="header">
			<nav> <!-- Aqui estamos iniciando la nueva etiqueta nav -->
				<ul class="nav">
					<li><a href="">Inicio</a></li>
					<li><a href="">Servicios</a>
						<ul>
							<li><a href="">Submenu1</a></li>
							<li><a href="">Submenu2</a></li>
							<li><a href="">Submenu3</a></li>
							<li><a href="">Submenu4</a>
								<ul>
									<li><a href="">Submenu1</a></li>
									<li><a href="">Submenu2</a></li>
									<li><a href="">Submenu3</a></li>
									<li><a href="">Submenu4</a></li>
								</ul>
							</li>
						</ul>
					</li>
					<li><a href="">Acerca de</a>
						<ul>
							<li><a href="">Submenu1</a></li>
							<li><a href="">Submenu2</a></li>
							<li><a href="">Submenu3</a></li>
							<li><a href="">Submenu4</a></li>
						</ul>
					</li>
					<li><a href="">Contacto</a></li>
				</ul>
			</nav><!-- Aqui estamos cerrando la nueva etiqueta nav -->
		</div>
	</body>
</html>
/////////////////////////////////////////////////////////////////////////


<!DOCTYPE html>
<html>
<head>
<title>Facebook Login JavaScript Example</title>
<meta charset="UTF-8">
</head>
<body>
<script>
  // This is called with the results from from FB.getLoginStatus().
  function statusChangeCallback(response) {
    console.log('statusChangeCallback');
    console.log(response);
    // The response object is returned with a status field that lets the
    // app know the current login status of the person.
    // Full docs on the response object can be found in the documentation
    // for FB.getLoginStatus().
    if (response.status === 'connected') {
      // Logged into your app and Facebook.
      testAPI();
    } else {
      // The person is not logged into your app or we are unable to tell.
      document.getElementById('status').innerHTML = 'Please log ' +
        'into this app.';
    }
  }

  // This function is called when someone finishes with the Login
  // Button.  See the onlogin handler attached to it in the sample
  // code below.
  function checkLoginState() {
    FB.getLoginStatus(function(response) {
      statusChangeCallback(response);
    });
  }

  window.fbAsyncInit = function() {
    FB.init({
      appId      : '{your-app-id}',
      cookie     : true,  // enable cookies to allow the server to access 
                          // the session
      xfbml      : true,  // parse social plugins on this page
      version    : 'v2.8' // use graph api version 2.8
    });

    // Now that we've initialized the JavaScript SDK, we call 
    // FB.getLoginStatus().  This function gets the state of the
    // person visiting this page and can return one of three states to
    // the callback you provide.  They can be:
    //
    // 1. Logged into your app ('connected')
    // 2. Logged into Facebook, but not your app ('not_authorized')
    // 3. Not logged into Facebook and can't tell if they are logged into
    //    your app or not.
    //
    // These three cases are handled in the callback function.

    FB.getLoginStatus(function(response) {
      statusChangeCallback(response);
    });

  };

  // Load the SDK asynchronously
  (function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "https://connect.facebook.net/en_US/sdk.js";
    fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));

  // Here we run a very simple test of the Graph API after login is
  // successful.  See statusChangeCallback() for when this call is made.
  function testAPI() {
    console.log('Welcome!  Fetching your information.... ');
    FB.api('/me', function(response) {
      console.log('Successful login for: ' + response.name);
      document.getElementById('status').innerHTML =
        'Thanks for logging in, ' + response.name + '!';
    });
  }
</script>

<!--
  Below we include the Login Button social plugin. This button uses
  the JavaScript SDK to present a graphical Login button that triggers
  the FB.login() function when clicked.
-->

<fb:login-button scope="public_profile,email" onlogin="checkLoginState();">
</fb:login-button>

<div id="status">
</div>

</body>
</html>
*/?>

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
				if(isset($_POST['btn-guardar'])){
					$cont=0;
					if(isset($_POST['none-mate'])){
						echo"<div class='alert alert-danger' role='alert' name='notify'>Se requiere hacer almenos el registro de un elemento Empleado.</div><hr name='notify'>";$cont++;
					}

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
				  			echo "<th scope='row'>".$array_consulta_materiales[$i]["clave"]."</th>";
				  			echo "<td>".$array_consulta_materiales[$i]["nombre"]."</th>";
				  			echo "<td>".$array_consulta_materiales[$i]["unidad"]."</th>";
				  			echo "<td>".$array_consulta_materiales[$i]["precio"]."</th>";
				  			echo "<td>".$array_consulta_nombrepartida[$i]["nombre"]."</th>";
				  			echo '<td><input type="number" name="n_'.$array_consulta_materiales[$i]["clave"].'" class="form-control" min="0" placeholder="0"></td>';
				  				
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
	for($i=0,$j=0;$i<count($array_consulta_materiales);$i++){
		$key=$array_consulta_materiales[$i]["clave"];
		if($_REQUEST["n_".$key]!=""&&$_REQUEST["n_".$key]!="0"){
			$proyecto_materiales[$j]=$array_consulta_materiales[$i];
			$j++;
		}
	}
	if(count($proyecto_materiales)!=0)
		$count++;
	else
		echo "<input type='text' class='non-disp' name='none-mate' value='0'>";//se crea un elemento oculto con un valor para validar que no se hizo ni una modificación en los valores unitarios de los materiales, o sea que no se incrementó ninguno 

	if(isset($_REQUEST['btn-save'])&&$cont==5){
		/*
			-clave
			-nombre
			-id_empleado
			-id_area
			-justificacion
			-objetivo
			-metas
			-indicador_resultados
			-id_programa
			-descripcion
		*/

		//Inicializa variables - guardar datos correspondientes a la tabla de proyectos
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

		$query=$conn->prepare("INSERT INTO proyectos(clave,nombre,id_empleado,id_area,justificacion,objetivo,metas,indicador_resultados,id_programa,descripcion) VALUES(:clave,:nombre,:id_empleado,:id_area,:justificacion,:objetivo,:metas,:indicador_resultados,:id_programa,:descripcion)");
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
	}
?>