<?php

require_once '../models/Usuario.php';

if(isset($_POST['operacion'])){
  $usuario = new Usuario();


  //  Identificando la operacion
  if ($_POST['operacion']== 'login'){

    $registro = $usuario->iniciarSesion($_POST['nombreusuario']);
    // echo json_encode($registro);


    //  Objeto para contener el resultado
    $resultado = [
      "status" => false,
      "mensaje" => ""
    ];

    if ($registro){
      //  El usuario si existe
      $resultado["status"] = true;
      $resultado["mensaje"] = "Usuario encontrado";
    }else{
      //  El usuario no existe
      $resultado["mensaje"] = "No encontramos al usuario";
    }


    //  Enviamos el objeto resultado a la vista
    echo json_encode($resultado);
  }
  
}