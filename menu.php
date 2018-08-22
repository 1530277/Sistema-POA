<!DOCTYPE html>
<html lang="en">
<head>
    <title>Sistema POA</title>
   <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="">

    <title>Areas</title>

    <!-- Bootstrap core CSS -->
    <link href="css2/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css2/font-awesome.min.css">
   
    <!-- Custom styles for this template -->
    <link href="css2/dashboard.css" rel="stylesheet">
    <link href="css/formulario.css" rel="stylesheet">
    
    <link rel="stylesheet" type="text/css" href="alertify/css/alertify.css" >
    <link rel="stylesheet" type="text/css" href="alertify/css/themes/default.css" >
  
  <script src="js/jquery-1.5.min.js"></script>
  </head>
  <?php
    require_once'agregar_css.php';
  ?>
<?php
  require 'header.php';
  require_once'css2/dashboard.php';
?>

    <style type="text/css">
    .button {background-color: white;color: black;border: 2px solid #4CAF50;padding: 5px 10px;text-align: center;text-decoration: none;display: inline-block;font-size: 7px;margin-left: 10px;width: 11px;height: 30px;}
.button:hover {
background-color: #4CAF50;
color: white;
}
      .div-lista{
        background-color: #273746;
        display: inline-block;
        font-size: 10px;
        width: 120px;
        min-height: 30px;
        margin-left: 30px; 
        margin-right: 40px;
        display: none;
      }
      .add-lista:hover  .div-lista{
        display: block;
      }
      .elemento-lista{
        width: 120px;
        height: 30px;
        border-color: gray;
        border: 3px;
        display: block;
        font-color: #34495E;
      }
      .elemento-lista:hover{
        font-color: #7DCEA0;
        background-color: #17202A;
        font-size-adjust: all;
      }
      .form-def{
        width: 500px;
        display: inline-block;
        border-color: gray;
        border: 3px;
      padding-left: 200px;
        align-self: center;
      }
      .centrar{
        align-items: center;

      padding: 30px 38px 66px;
        margin-left: 400px;
      }
      .div-left{
        width: 200px;
      }
      .dropdown {
    position: relative;
    display: inline-block;
}

.dropdown-content {
    display: none;
    position: absolute;
    background-color: #f9f9f9;
    min-width: 120px;
    min-height: 10px;
    padding: 12px 16px;
    z-index: 1;
}
.
.dropdown:hover .dropdown-content {
    display: block;
}
  </style>
</head>
<body>



  <div class="col-sm-3 col-md-2 sidebar color-barra">
          <ul class="nav nav-pills flex-column">
            <li class="nav-item">
              <a class="nav-link btn" href="areas.php">ÁREAS</a>
            </li>
            <li class="nav-item">
              <a class="nav-link btn" href="empleados.php">EMPLEADOS</a>
            </li>
            <li class="nav-item">
              <a class="nav-link btn" href="eje.php">EJES</a>
            </li>
            <li class="nav-item">
              <a class="nav-link btn" href="programa.php">PROGRAMAS</a>
            </li>
            <li class="nav-item">
              <a class="nav-link btn" href="partida.php">PARTIDAS</a>
            </li>
            <li class="nav-item">
              <a class="nav-link btn" href="material.php">MATERIAL</a>
            </li>
            <li class="nav-item">
              <a class="nav-link btn" href="proyecto.php">PROYECTOS</a>
            </li>
            <li class="nav-item">
              <a class="nav-link btn" href="requisicion.php">REQUISICIONES</a>
            </li>
            <li class="nav-item dropdown add-lista nav">
                <a class="nav-link btn" id="navbardrop" data-toggle="dropdown">
                  AGREGAR NUEVO
                </a>
                <div class="add-lista">
                  <ul class="div-lista nav">
                    <a class="nav-item">
                      <a class="nav-link elemento-lista" href="agregar_area.php">ÁREA</a>
                    </a>
                    <a  class="nav-item">
                      <a class="nav-link elemento-lista" href="agregar_empleado.php">EMPLEADO</a>
                    </a>
                    <a class="nav-item">
                      <a class="nav-link elemento-lista" href="agregar_eje.php">EJE RECTOR</a>
                    </a>
                    <a class="nav-item">
                      <a class="nav-link elemento-lista" href="agregar_requisicion.php">REQUISICION</a>
                    </a>
                    <a class="nav-item">
                      <a class="nav-link elemento-lista" href="agregar_proyecto.php">PROYECTO</a>
                    </a>
                    <a class="nav-item">
                      <a class="nav-link elemento-lista" href="agregar_material.php">MATERIAL</a>
                    </a>
                    <a class="nav-item">
                      <a class="nav-link elemento-lista" href="agregar_partida.php">PARTIDA</a>
                    </a>
                    <a class="nav-item">
                      <a class="nav-link elemento-lista" href="agregar_actividad.php">ACTIVIDAD</a>
                    </a>
                    <a class="nav-item">
                      <a class="nav-link elemento-lista" href="agregar_programa.php">PROGRAMA</a>
                    </a>
                    <a class="nav-item">
                      <a class="nav-link elemento-lista" href="agregar_puesto.php">PUESTO</a>
                    </a>
                  </div>
                </div>
              </li>
          </ul>
</div>
<?
/* <a class="dropdown-content button" href="agregar_area.php">ÁREA</a><BR>
                  <a class="dropdown-content button" href="agregar_empleado.php">EMPLEADO</a><br class="dropdown-content">
                  <a class="button dropdown-content" href="agregar_eje.php">EJE RECTOR</a><br class="dropdown-content">
                  <a class="button dropdown-content" href="agregar_requisicion.php">REQUISICION</a><br class="dropdown-content">
                  <a class="button dropdown-content" href="agregar_proyecto.php">PROYECTO</a><br class="dropdown-content">
                  <a class="button dropdown-content" href="agregar_material.php">MATERIAL</a><br class="dropdown-content">
                  <a class="button dropdown-content" href="agregar_partida.php">PARTIDA</a><br class="dropdown-content">
                  <a class="button dropdown-content" href="agregar_actividad.php">ACTIVIDAD</a><br class="dropdown-content">*/
?>