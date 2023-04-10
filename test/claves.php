<?php


//  Tabla
$claveUsuario = "SENATI";

$claveMD5 = md5($claveUsuario);
$claveSHA = sha1($claveUsuario);
$claveHASH = password_hash($claveUsuario, PASSWORD_BCRYPT);

$claveAcceso = "SENATi";

// var_dump($claveMD5);
// var_dump($claveSHA);
// var_dump($claveHASH);

//  Validar clave HASH

if (password_verify($claveAcceso, $claveHASH)){
  echo "Accesso correcto";
}else{
  echo "Accesso incorrecto";
}