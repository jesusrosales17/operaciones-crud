<?php
//importamos la base de datos
require "../includes/config/conexion.php";
$db = conectardb();
mysqli_set_charset($db, "utf8");
//optenemos los datos del integrante para llenar el formulario
$key =  $_GET["key"];
$consulta = "SELECT * FROM RAMA_FAMILIARES WHERE CURP='$key'";
$resultado = mysqli_query($db, $consulta);

//si no se encuentra el integrante redireccionamos al usuario a la pagina principal
if($resultado->num_rows === 0){
  header("location: /");
}

$info = mysqli_fetch_assoc($resultado);

//crear un arreglo de errores
$errores = [];

//variableas para llenar los inputs 

$integrante = $info["INTEGRANTE"];
$curp = $info["CURP"];
$nombre = $info["NOMBRE"];
$apellidos = $info["APELLIDOS"];
$edad = $info["EDAD"];
$nacimiento = $info["FECHA_DE_NACIMIENTO"];
$domicilio = $info["DOMICILIO"]; 
$ciudad = $info["CIUDAD"];

//revisamos que el metodo sea POST
if($_SERVER["REQUEST_METHOD"] === "POST") {

  //escapamos las variables para evitar que nos inserten codigo sql
  //las guardamos en las variables creadas con anterioridad
  $integrante = trim( mysqli_real_escape_string($db,$_POST["integrante"]) );
  $curp = strtoupper( trim( mysqli_real_escape_string($db,$key) )  );
  $nombre =trim(  mysqli_real_escape_string($db,$_POST["nombre"]) );
  $apellidos =trim(  mysqli_real_escape_string($db,$_POST["apellidos"]) );
  $edad = trim(  mysqli_real_escape_string($db,$_POST["edad"]) );
  $nacimiento = trim(  mysqli_real_escape_string($db,$_POST["nacimiento"]) );
  $domicilio =trim( mysqli_real_escape_string($db,$_POST["domicilio"]) );
  $ciudad =trim( mysqli_real_escape_string($db,$_POST["ciudad"] )  );
  
  //validación
  if(!$integrante) {
    $errores[] = "El integrante es obligatorio";
  }
  if(!$nombre) {
    $errores[] = "El nombre es obligatorio";
  }
  if(!$apellidos) {
    $errores[] = "Los apellidos son obligarios";
  }
  if(!$edad) {
    $errores[] = "La edad es obligatoria";
  }
  if(!$nacimiento) {
    $errores[] = "La fecha de nacimiento es obligatoria";
  }
  if(!$domicilio) {
    $errores[] = "El domicilio es obligatorio";
  }
  if(!$ciudad) {
    $errores[] = "La ciudad es obligatoria";
  }

  //verificamos que no existan errores
  if(empty($errores)) {
    //actualizarel integrante en la base de datos
    $consulta = "UPDATE RAMA_FAMILIARES SET INTEGRANTE='$integrante', CURP='$curp', NOMBRE='$nombre', APELLIDOS='$apellidos', EDAD='$edad',FECHA_DE_NACIMIENTO='$nacimiento', DOMICILIO='$domicilio', CIUDAD='$ciudad' WHERE CURP='$curp'";

    $resultado = mysqli_query($db, $consulta);
       if ($resultado) { 
        // Redireccionar al usuario
        header("Location: /?resultado=2");
       }
  }
 
}

//importamos el template de header
include "../includes/templates/header.php" 
?>
  <main class="main-formulario">
    <a href="/" class="boton boton-verde-inline">Volver</a>
      <?php foreach($errores as $error):?>
        <div class="alerta error"><?php echo $error; ?></div>
      <?php endforeach; ?>
      <form class="formulario" method="POST">
        <label for="integrante">Integrante:</label>
        <input type="text" id="integrante" name="integrante" placeholder="Integrante" value="<?php echo $integrante ?>">
      
        <label for="curp">CURP:</label>
        <input type="text" id="curp" name="curp" placeholder="curp" value="<?php echo $info["CURP"] ?>" disabled>
      
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" placeholder="Nombre" value="<?php echo $nombre ?>">
      
        <label for="apellidos">Apellidos:</label>
        <input type="text" id="apellidos" name="apellidos" placeholder="Apellidos" value="<?php echo $apellidos ?>">
      
        <label for="edad">Edad:</label>
        <input type="number" id="edad" name="edad" placeholder="Edad" value="<?php echo $edad ?>">
      
        <label for="nacimiento">Fecha de nacimiento:</label>
        <input type="date" id="nacimiento" name="nacimiento" value="<?php echo $nacimiento?>">
      
        <label for="domicilio">Domicilio:</label>
        <input type="text" id="domicilio" name="domicilio" placeholder="Domicilio" value="<?php echo $domicilio ?>">
      
        <label for="ciudad">Ciudad:</label>
        <input type="text" id="ciudad" name="ciudad" placeholder="Ciudad" value="<?php echo $ciudad ?>">
      
        <input type="submit" class="submit boton boton-verde-inline" value="Actualizar Integrante">
      </form> 
  </main>

<?php 
  //incluimos el template de footer
  include "../includes/templates/footer.php";
  //cerramos la conexión con la base de datos
  mysqli_close($db);
?>
