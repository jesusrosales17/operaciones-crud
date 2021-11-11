<?php
//importo la conexión de la base de datos
require "includes/config/conexion.php";
$db = conectarDB();
mysqli_set_charset($db, "utf8");
//creo la consulta
$consulta = "SELECT * FROM RAMA_FAMILIARES";
//optengo los resultados
$resultado = mysqli_query($db, $consulta);

//si se a realizado alguna accion optenemos el numero del mensaje correspondiente
$mensaje = $_GET["resultado"] ?? null;


//eliminamos al integrante de la base de datos
if($_SERVER["REQUEST_METHOD"] === "POST") {

  $key = $_POST["key"];
  //consulta
  $consulta = "DELETE FROM RAMA_FAMILIARES WHERE CURP = '$key'";
  $resulta = mysqli_query($db, $consulta);

  //si se elimino corrctamente reiniciamos la pagina y mostramos el mensaje de eliminado
  if($resultado) {
    header("location: /?resultado=3");
  }
}

//incluimos el template de header
include "includes/templates/header.php";
?>


  <main class="main">
   <?php if (intval($mensaje) === 1) : ?>
        <p class="alerta exito">Integrante Creado Correctamente</p>
    <?php elseif(intval($mensaje) === 2) : ?>
        <p class="alerta exito">Integrante Actualizado Correctamente</p>
    <?php elseif(intval($mensaje) === 3) : ?>
        <p class="alerta exito">Integrante Eliminado Correctamente</p>
    <?php endif ?>

    <a href="operaciones/crear.php" class="boton boton-verde-inline">Agregar Integrante</a>
    <table class="tabla">
      <thead> <tr>
          <th>INTEGRANTE</th> 
          <th>CURP</th>
          <th>NOMBRE</th>
          <th>APELLIDOS</th>
          <th>EDAD</th>
          <th>FECHA DE NACIMIENTO</th>
          <th>DOMICILIO</th>
          <th>CIUDAD</th>
          <th>Operacion</th>
        </tr>
      </thead>
      
      <tbody>
        <?php if($resultado->num_rows > 0): ?>
          <?php while($integrante = mysqli_fetch_assoc($resultado)): ?>
            <tr>
            <td><?php echo $integrante["INTEGRANTE"]; ?></td>
              <td><?php echo $integrante["CURP"]; ?></td>
              <td><?php echo $integrante["NOMBRE"]; ?></td>
              <td><?php echo $integrante["APELLIDOS"]; ?></td>
              <td><?php echo $integrante["EDAD"]; ?></td>
              <td><?php echo $integrante["FECHA_DE_NACIMIENTO"]; ?></td> 
              <td><?php echo $integrante["DOMICILIO"]; ?></td> 
              <td><?php echo $integrante["CIUDAD"]; ?></td>
              <td>
                <a href="operaciones/actualizar.php?key=<?php echo $integrante["CURP"] ?>" class="boton boton-verde-block">actualizar</a>
                <form method="POST"  class="w-100">
                  <input type="hidden" name="key" value="<?php echo $integrante["CURP"] ?>">
                  <input type="submit" class="boton boton-rojo-block" value="Eliminar">
                </form>
              </td>
            </tr>  
          <?php endwhile; ?>
         <?php endif; ?>
      </tbody> 
    </table> 
  </main> 

<?php 
  //incluimos el template de footer
  include "includes/templates/footer.php"; 
  //cerramos la conexión de la base de datos
  mysqli_close($db);
?>
