<?php 

require 'includes/funciones.php';
// Proteger esta ruta.
$auth = estaAutenticado();
if(!$auth) {
    header('Location: /');}


require 'includes/config/database.php';
$db= conectarDB();

$errores = [];

$nombre = '';
$descripcion = '';
$cpm = '';
$vidrio = '';
$copias = '';
$clasificacion = '';
$estado= '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    
//echo "<pre>";  
//var_dump($_POST);
//echo "</pre>";  

//echo "<pre>";  
//var_dump($_FILES);
//echo "</pre>";  


    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $cpm = $_POST['cpm'];
    $vidrio = $_POST['vidrio'];
    $copias = $_POST['copias'];
    $clasificacion = $_POST['clasificacion'];
    $estado = $_POST['estado'];



$nombre = mysqli_real_escape_string( $db, $_POST['nombre'] );
$descripcion = mysqli_real_escape_string( $db, $_POST['descripcion'] );
$cpm = mysqli_real_escape_string( $db, $_POST['cpm'] );
$vidrio = mysqli_real_escape_string( $db, $_POST['vidrio'] );
$copias = mysqli_real_escape_string( $db, $_POST['copias'] );
$clasificacion = mysqli_real_escape_string( $db, $_POST['clasificacion'] );
$estado = mysqli_real_escape_string( $db, $_POST['estado'] );

$imagen= $_FILES['imagen'];

var_dump($imagen);



if (!$nombre) {
    $errores[] = 'Debes añadir un nombre para tu producto';
}



if (!$estado) {
    $errores[] = 'Debes añadir en que estado esta tu producto';
}

if (strlen($descripcion) < 40) {
    $errores[] = 'La Descripción es obligatoria y debe tener al menos 60 caracteres';
}

if (!$clasificacion) {
    $errores[] = 'La clasificacion es obligatoria';
}

if (!$imagen['name']) {
    $errores[] = 'Imagen no válida';
}

$medida = 2 * 1000 * 1000;
// var_dump($imagen['size']);
// var_dump($imagen);

if ($imagen['size'] > $medida) {
    $errores[] = 'La Imagen es muy grande';
}


if (empty($errores)) {

$carpetaImagen = "./imagenes/";

$nombreImagen = md5(uniqid( rand(), true)) . ".jpg";

move_uploaded_file($imagen['tmp_name'], $carpetaImagen . $nombreImagen);



    $query = "INSERT INTO productos (nombre, descripcion, cpm, vidrio, copias, clasificacion, imagen, estado) 
    VALUES ( '$nombre', '$descripcion', '$cpm', '$vidrio',  '$copias', '$clasificacion', '$nombreImagen', '$estado' )";
    
    
    $resultado = mysqli_query($db, $query);
    // var_dump($resultado);
    // printf("Nuevo registro con el id %d.\n", mysqli_insert_id($db));
    
    if ($resultado) {
    
        header('location: /admin.php?resultado=1');
    }
    }

   
}







include 'includes/templates/header.php';

?>



<main clas="container crear_producto">
<h1>Crear Nuevo producto</h1>

<a href="admin.php" class="boton-volver"><< Volver </a>

<?php foreach ($errores as $error) : ?>
    <div class="alerta error">
       <?php echo $error; ?> 
       </div>
    <?php endforeach; ?>

<form class="container form_crear_producto" method="POST" action="crearproducto.php" enctype="multipart/form-data" >


<fieldset>
    <label for="nombre"> Nombre</label>
    <input type="text" id="nombre" name="nombre" placeholder="Nombre del producto" value="<?php echo $nombre ?>"></input>

    <label for="descripcion">Descripción</label>
    <textarea id="descripcion" name="descripcion"><?php echo $descripcion ?></textarea>

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
<option value="oficina">Equipo de oficina</option>
</select>

<label for="estado">Estado</label>
    <select id="estado" name="estado">
        <option value="">--seleccione--</option>
        <option value="nuevo">Nuevo</option>
        <option value="Reacondicionado">Reacondicionado</option>
    </select >
</fieldset>
<fieldset>
    <legend>Imagen del producto</legend>
    <imagen for="imagen">Foto del producto</imagen>
    <input name="imagen" type="file" id="imagen" accept="image/jpg, image/png" name="imagen" value="<?php echo $imagen ?>">


</fieldset>
<input class="boton_producto" type="submit" value="Agregar producto" >

</form>



</main>

<?php 

include 'includes/templates/footer.php';
mysqli_close($db); ?>
?>