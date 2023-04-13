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
            <button class="btn btn-success btn-sm" id="abrir-modal" data-bs-toggle="modal" data-bs-target="#modal-registro-cursos">
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
      <!-- <div class="card-footer text-end">
        <a href="../controllers/usuario.controller.php?operacion=finalizar">Cerrar sesión</a>
      </div> -->
    </div>
  </div> <!-- Fin de container -->

  <!-- Inicio del Modal-->




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

      //  Ejecución automatica
      mostrarUsuarios();
    });

    
  </script>

</body>

</html>