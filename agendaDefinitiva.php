<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="agendaDefinitivo.css"></link>
    <title>Agenda</title>
</head>
<body>

<?php
session_start();
$_nombreError="";
//$_contactosRecogidos = explode(",", $_POST["agenda_Nombre"]);

// el array se guarda en la sesion , si no esta declarada , se crea
// Logica de la agenda 
// Condiciones

            // 2 - Si el nombre no existe y se introduce un teléfono, se añade a la agenda.
            // 3 - Si el nombre ya existe y se introduce un teléfono, se actualiza el teléfono.
            // 4 - Si el nombre ya existe y no se introduce un teléfono, se elimina la entrada.

if(!isset($_SESSION["data"])){  
$_SESSION['data'] = array();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && $_SERVER["REQUEST_METHOD"]) { 
    if(empty($_POST["nombre"])){

        $_nombreError= "<br><br>El nombre es obligatorio , esta vacío";

    }else{
        $_nombre = $_POST["nombre"];
        $_tel= $_POST["tel"];

// Añade
if (!empty($_nombre) || !empty($_tel)) {
    $nuevoContacto = $_nombre . " - " . $_tel;
    //$_SESSION['data'][] = $nuevoContacto; // Agregar el contacto a la sesión // Si dejo esto lo que hago es sobrescribir el array cada vez que envia 

    // actualizar si existe el nombre en la agenda // si existe en la agenda un nombre 
     if ( isset($_SESSION['data'][$_nombre])) {

        $nuevoContacto = $_nombre . " - " . $_tel;
        $_SESSION['data'][$_nombre] = $nuevoContacto; // Agregar el contacto a la sesión
        echo " Contacto actualizado = ";
     }else{
        $_SESSION['data'][$_nombre] = $nuevoContacto; // Agregar el contacto a la sesión
     echo"Contacto Agregado = " ;
     print_r($nuevoContacto);

    }}else {
      //borrar
        if(isset($_SESSION['data'][$_nombre])) {
        unset($_SESSION['data']);
        $_mensaje = " Se ha borrado el contacto". $_nombre." - ". $_tel ;
        echo"Mensaje: ". $_mensaje ."";

            }else {
                $_mensaje = " el contacto no existe para ser eleminado";
            }

        }
    }
   
    
}
// limpiar
if (isset($_POST['limpiar'])) {
    $_SESSION['data'] = array(); // Reinicia la sesión a un array vacío
    $_mensaje = "Todos los contactos han sido eliminados.";
}
?>

<h1> Agenda DWSC 02</h1>
<div class="contenedor">
    <div class="contenedorAgenda">
        <div class="formulario">
            <form action="agendaDefinitiva.php" method="POST">
            <label>Nombre</label>
            <input type="text" name="nombre" placeholder="introduce un nombre">
            <input type="hidden" name="agenda_Nombre" value="<?php echo implode (",",$_SESSION['data'] ) ?>" ><br><br>
            <label>Telefono</label>
            <input type="text" name="tel" placeholder="introduce un telefono"><br><br>
            <input type="submit" name="enviar"value="Añadir Contacto">
            </form>
        </div>




        <div class="error">

    <p> <?php echo $_nombreError ?></p>

        </div>

    
    </div><!-- Contenedor Agenda -->
    <div class="resultados">
        <h3>Contactos guardados:</h3>
        <form action="" method="POST">
        <ul>
        <?php
        // Imprimir todos los contactos almacenados en la sesión
        if (!empty($_SESSION['data'])) {
            
        foreach ($_SESSION['data'] as $contacto) {
            echo "<li>". $contacto ."</li>". "<br>";
        }   
    
    }  
        ?>
        </ul>
    
        </form>
        </div>
    <div class="limpiar">
        <h3> Limpiar Contactos</h3>
        <form action="agendaDefinitiva.php" method="POST">
        <input type="submit" name="limpiar" value="Limpiar todos los contactos">
    </form>
    </div>
</div>




</body>
</html>