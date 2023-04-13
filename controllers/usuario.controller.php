<?php

session_start();

require_once '../models/Usuario.php';

if(isset($_POST['operacion'])){
  $usuario = new Usuario();


  //  Identificando la operacion
  if ($_POST['operacion']== 'login'){

    $registro = $usuario->iniciarSesion($_POST['nombreusuario']);
    // echo json_encode($registro);

    $_SESSION["login"] = false;

    //  Objeto para contener el resultado
    $resultado = [
      "status" => false,
      "mensaje" => ""
    ];

    if ($registro){
      //  El usuario si existe
      // $resultado["status"] = true;
      // $resultado["mensaje"] = "Usuario encontrado";
      $claveEncriptada = $registro['claveacceso'];

      //  Validar la contraseña
      if(password_verify($_POST['claveIngresada'], $claveEncriptada)){
        $resultado["status"] = true;
        $resultado["mensaje"] = "Bienvenido al sistema";
        $_SESSION["login"]=true;
      }else {
        $resultado["mensaje"] = "Error en la contraseña";
      }

    }else{
      //  El usuario no existe
      $resultado["mensaje"] = "No encontramos al usuario";
    }


    //  Enviamos el objeto resultado a la vista
    echo json_encode($resultado);
  }

  //  Listar Usuarios
  if($_POST['operacion'] == 'listar'){
    $datosObtenidos = $usuario->listarUsuario();

    if($datosObtenidos){
      $numeroFila = 1;
    
      foreach($datosObtenidos as $usuario){
        echo "
        <tr>
          <td>{$numeroFila}</td>
          <td>{$usuario['nombreusuario']}</td>
          <td>{$usuario['nombres']}</td>
          <td>{$usuario['apellidos']}</td>
          <td>{$usuario['claveacceso']}</td>
          <td>
            <a href='#' data-idusuario='{$usuario['idusuario']}' class='btn btn-danger btn-sm eliminar'><i class='bi bi-trash'></i></a>
            <a href='#' data-idusuario='{$usuario['idusuario']}' class='btn btn-success btn-sm editar'><i class='bi bi-pencil'></i></a>                     
          </td>
        </tr>
        
        ";
        $numeroFila++;
      }

    }
  }

  //  Eliminar Usuario
  if($_POST['operacion'] == 'eliminar'){
    $usuario->eliminarUsuario($_POST['idusuario']);
  }
  
}

// I
if(isset($_GET['operacion'])){
  if($_GET['operacion'] == 'finalizar'){
    session_destroy();
    session_unset();
    header('Location: ../index.php');
  }
}