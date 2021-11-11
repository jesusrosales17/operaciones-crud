<?php 
function conectarDB() : mysqli {

  $db= mysqli_connect("fdb34.awardspace.net","3951341_familia","781210MR","3951341_familia"); 

  if(!$db) {
    echo "Error: No se pudo conectar con la base de datos";
    exit;
  }
  return $db; 
}
