<?php
require 'includes/funciones.php';
// Proteger esta ruta.
$auth = estaAutenticado();
if(!$auth) {
    header('Location: /');}

require 'includes/config/database.php';
$db= conectarDB();



$id =  $_GET['id'];
$id = filter_var($id, FILTER_VALIDATE_INT);
if(!$id) {
    header('Location: /admin.php');
}

$consulta = "SELECT * FROM productos WHERE id = ${id}";
$resultado = mysqli_query($db, $consulta);
$productos = mysqli_fetch_assoc($resultado);

$errores = [];

$nombre = $productos['nombre'];
$descripcion = $productos['descripcion'];
$cpm = $productos['cpm'];
$vidrio = $productos['vidrio'];
$copias = $productos['copias'];
$clasificacion = $productos['clasificacion'];




if ($_SERVER['REQUEST_METHOD'] === 'POST') {

   

    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $cpm = $_POST['cpm'];
    $vidrio = $_POST['vidrio'];
    $copias = $_POST['copias'];
    $clasificacion = $_POST['clasificacion'];
    $estado = $_POST['estado'];
  


    $imagen = $_FILES['imagen'] ?? null;


    if (!$nombre) {
        $errores[] = 'Debes añadir un nombre para tu producto';
    }

    
    if (!$estado) {
        $errores[] = 'Debes añadir el estado tu producto';
    }
    
    if (strlen($descripcion) < 40) {
        $errores[] = 'La Descripción es obligatoria y debe tener al menos 60 caracteres';
    }
    
    if (!$clasificacion) {
        $errores[] = 'La clasificacion es obligatoria';
    }
    
    
  

    $medida = 2 * 1000 * 1000;
    // var_dump($imagen['size']);
    // var_dump($imagen);

    if ($imagen['size'] > $medida) {
        $errores[] = 'La Imagen es muy grande';
    }




    // echo "<pre>";
    // var_dump($errores);
    // echo "</pre>";

    // El array de errores esta vacio
    if (empty($errores)) {
        // Si hay una imagen NUEVA, entonces borrar la anterior.

  
            $carpetaImagen = "./imagenes/";

            if($imagen['name']){
         
                unlink($carpetaImagen. $productos['imagen']);

                $nombreImagen = md5(uniqid( rand(), true)) . ".jpg";
            
                move_uploaded_file($imagen['tmp_name'], $carpetaImagen . $nombreImagen);


            }else{
                $nombreImagen= $productos['imagen'];
    
            }
            
      


        $query = "UPDATE productos SET nombre = '${nombre}', descripcion = '${descripcion}', cpm = '${cpm}', estado = '${estado}',
         vidrio = '${vidrio}', copias = '${copias}', clasificacion = '${clasificacion}', imagen = '${nombreImagen}'  WHERE id = '${id}' ";
        // echo $query;


        $resultado = mysqli_query($db, $query) or die(mysqli_error($db));
        // var_dump($resultado);
        // printf("Nuevo registro con el id %d.\n", mysqli_insert_id($db));

        if ($resultado) {
            header('location: /admin.php?resultado=2');
        }
    }

    // Insertar en la BD.


}



include 'includes/templates/header.php';
?>


<main clas="container crear_producto">
<h1>Actualizar  producto</h1>

<a href="admin.php" class="boton-volver"><< Volver </a>

<?php foreach ($errores as $error) : ?>
    <div class="alerta error">
       <?php echo $error; ?> 
       </div>
    <?php endforeach; ?>

<form class="container form_crear_producto" method="POST"  enctype="multipart/form-data">


<fieldset>
    <label for="nombre"> Nombre</label>
    <input type="text" id="nombre" name="nombre" placeholder="Nombre del producto" value="<?php echo $nombre ?>"></input>

    <label for="descripcion">Descripción</label>
    <textarea id="descipcion" name="descripcion"><?php echo $descripcion ?></textarea>

    <label for="cpm">Copias por minuto</label>
    <input type="text" id="cpm" name="cpm" placeholder="30 cpm" value="<?php echo $cpm ?>">

    <label for="vidrio">Tamaño de vidrio</label>
    <input type="text" id="vidrio" name="vidrio" placeholder="ejemplo: oficio" value="<?php echo $vidrio ?>">

    <label for="copias">Cantidad de copias</label>
    <input type="text" id="copias" name="copias" placeholder="Ejemplo 30.000 -> 30K" value="<?php echo $copias ?>">
</fieldset>
<fieldset>
    <legend>Clasificación</legend>

<select name="clasificacion">

<option  value="">-- seleccione --</option> 
<option value="volumen"> Fotocopiadoras de volumen</option>
<option value="compactas">Fotocopiadoras compactas</option>
<option value="imp-laser">Impresoras láser</option>
<option value="imp-tinta">Impresoras de tinta</option>
<option value="toner">Tóner</option>
<option value="insumos">Insumos y repuestos</option>
<option value="guillotinas">Guillotinas</option>
<option value="anilladoras">Anilladoras</option>
<option value="equipo-oficina">Equipo de oficina</option>
</select>

<label for="estado">Estado</label>
    <select id="estado" name="estado">
        <option value="nuevo">Nuevo</option>
        <option value="Reacondicionado">Reacondicionado</option>
    </select >
</fieldset>
<fieldset>
    <legend>Imagen del producto</legend>
    <imagen for="imagen">Foto del producto</imagen>
    <input name="imagen" type="file" id="imagen" accept="image/jpg, image/png" name="imagen" value="<?php echo $imagen ?>">


</fieldset>
<input class="boton_producto" type="submit" value="Actualizar producto" >

</form>



</main>

<?php 

include 'includes/templates/footer.php';
mysqli_close($db); ?>
?>