<!-- < ? php -->
<!-- // session_start();

// if (!isset($_SESSION['login']) || $_SESSION['login'] == false){
//   header('Location:../index.php');
// } -->
<!doctype html>
<html lang="es">

<head>
  <title>Registro de usuarios</title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS v5.2.1 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">

    <!-- Iconos de Bootstrap -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.4/font/bootstrap-icons.css">

  <!-- Data Tables -->
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">


</head>

<body>

  <div class="container mt-3">
    <div class="card">
      <div class="card-header bg-secondary text-light">
        <div class="row">
          <div class="col-md-6">
            <strong>LISTA DE USUARIOS</strong>
          </div>
          <div class="col-md-6 text-end">
            <button class="btn btn-success btn-sm" id="abrir-modal" data-bs-toggle="modal" data-bs-target="#modal-registro-usuarios">
              <i class="bi bi-plus-circle-fill"></i> Agregar Usuario
            </button>
          </div>
        </div>
      </div>
      <div class="card-body">
        <table class="table table-sm table-striped" id="tabla-usuarios">
          <colgroup>
            <col width = "5%">
            <col width = "20%">
            <col width = "20%">
            <col width = "25%">
            <col width = "20%">
            <col width = "10%">
          </colgroup>

          <thead>
            <tr>
              <th>#</th>
              <th>Usuario</th>
              <th>Nombre</th>
              <th>Apellido</th>
              <th>Clave</th>
              <th>Operaciones</th>
            </tr>
          </thead>
          <tbody>

          </tbody>
        </table>
      </div>
    </div>
  </div> <!-- Fin de container -->

  <!-- Inicio del Modal-->


<!-- Modal Body -->
<!-- if you want to close by clicking outside the modal, delete the last endpoint:data-bs-backdrop and data-bs-keyboard -->
<div class="modal fade" id="modal-registro-usuarios" tabindex="-1" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTitleId">Nuevo Usuario</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        
      <!-- Cuerpo del modal -->

      <form id="formulario-usuarios">
        <div class="mb-3">
          <label for="nombreusuario" class="form-label">Usuario:</label>
          <input type="text" class="form-control form-control-sm" id="nombreusuario" placeholder="Escriba un usuario">
        </div>
        <div class="mb-3">
          <label for="nombres" class="form-label">Nombre:</label>
          <input type="text" class="form-control form-control-sm" id="nombres" placeholder="Escriba su nombre">
        </div>
        <div class="mb-3">
          <label for="apellidos" class="form-label">Apellido:</label>
          <input type="text" class="form-control form-control-sm" id="apellidos" placeholder="Escriba su apellido">
        </div>
        <div class="mb-3">
          <label for="claveacceso" class="form-label">Clave:</label>
          <input type="password" class="form-control form-control-sm" id="claveacceso" placeholder="Escriba su clave">
        </div>
      </form>

      <!-- Fin del  cuerpo del modal -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" id="guardar-usuario">Guardar</button>
      </div>
    </div>
  </div>
</div>


  <!-- Fin del Modal -->


  <!-- Bootstrap JavaScript Libraries -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
    integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js"
    integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous">
  </script>

  <!-- JQuery -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

  <script>
    //  Ejecutamos el código JavaScript después de que se haya cargado completamente el DOM
    $(document).ready(function(){

      //  Hacemos una consulta asincrona al servidor
      //  Función mostrar platos
      function mostrarUsuarios(){
        //  Enviamos una solicitud AJAX al controlador
        //  usando el método POST
        //  y enviamos un objeto de datos con la propiedad 'operacion' con valor 'listar'
          $.ajax({
            url: '../controllers/usuario.controller.php',
            type: 'POST',
            data: {operacion: 'listar'},
            dataType: 'text',
            success: function(result){
              $("#tabla-usuarios tbody").html(result);
            }
          });
      }  // Fin de la función mostrar usuarios


      function eliminarUsuario(){
        console.log("Eliminando");
      }

      $("#tabla-usuarios tbody").on("click", ".eliminar", function(){
        const idusuarioEliminar = $(this).data("idusuario");

        if(confirm("¿Estas seguro de proceder?")){
          $.ajax({
            url: '../controllers/usuario.controller.php',
            type: 'POST',
            data: {
              operacion : 'eliminar',
              idusuario : idusuarioEliminar
            },
            success: function(result){
              if (result == ""){
                mostrarUsuarios();
              }
            }
          });
        }
      });

      function registrarUsuario(){
        console.log("Registrando....");

        if(confirm("¿Estas segura de registrar en este usuario?")){
          $.ajax({
            url: '../controllers/usuario.controller.php',
            type: 'POST',
            data: {
              operacion  : 'registrar',
              nombreusuario    :  $("#nombreusuario").val(),
              nombres    :  $("#nombres").val(),
              apellidos    :  $("#apellidos").val(),
              claveacceso    :  $("#claveacceso").val(),
            },
            success: function(result){
              if(result == ""){
                $("#formulario-usuarios")[0].reset();

                mostrarUsuarios();

                $("#modal-registro-usuarios").modal('hide');
              }
            }
          });
        }
      }

      //  EVENTOS
      $("#guardar-usuario").click(registrarUsuario);

      //  Ejecución automatica
      mostrarUsuarios();
    });

    
  </script>

</body>

</html>
