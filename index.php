<?php
session_start();

if(isset($_SESSION['login']) && $_SESSION['login']) {
  header('Location:views/index.php');
}
?>

<!doctype html>
<html lang="es">

<head>
  <title>Loging</title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS v5.2.1 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">

</head>

<body>
 
<div class="container mt-3">
    <div class="card">
      <div class="card-header bg-primary text-light">
        <div class="row">
          <div class="col-md-6">
            <strong>LISTA DE CURSOS</strong>
          </div>
          <div class="col-md-6 text-end">
            <button class="btn btn-success btn-sm" id="abrir-modal" data-bs-toggle="modal" data-bs-target="#modal-registro-cursos">
              <i class="bi bi-plus-circle-fill"></i> Agregar curso
            </button>
          </div>
        </div>
      </div>
      <div class="card-body">
        <table class="table table-sm table-striped" id="tabla-cursos">
          <colgroup>
            <col width = "5%">
            <col width = "30%">
            <col width = "25%">
            <col width = "10%">
            <col width = "10%">
            <col width = "10%">
            <col width = "10%">
          </colgroup>
          <thead>
            <tr>
              <th>#</th>
              <th>Nombre</th>
              <th>Especialidad</th>
              <th>Nivel</th>
              <th>Inicio</th>
              <th>Inversión</th>
              <th>Operaciones</th>
            </tr>
          </thead>
          <tbody>

          </tbody>
        </table>
      </div>
      <div class="card-footer text-end">
        <a href="../controllers/usuario.controller.php?operacion=finalizar">Cerrar sesión</a>
      </div>
    </div>
  </div> <!-- Fin de container -->


  
  <!-- jQuery -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

  <script>
    $(document).ready(function (){

      function iniciarSesion(){
        const usuario = $("#usuario").val();
        const clave = $("#clave").val();

        if (usuario != "" && clave != ""){
          $.ajax({
            url: 'controllers/usuario.controller.php',
            type: 'POST',
            data: {
              operacion         : 'login',
              nombreusuario     : usuario,
              claveIngresada    : clave
            },
            dataType: 'JSON',
            success: function (result) {
              console.log(result);

              if (result["status"]){
                window.location.href = "views/index.php"
              }else{
                alert(["CONTRASEÑA INCORRECTA"]);
              }
            }

          });
      }
    }

    $("#iniciar-sesion").click(iniciarSesion);
    })
  </script>

</body>

</html>