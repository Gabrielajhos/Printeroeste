<?php 

require 'includes/funciones.php';
// Proteger esta ruta.
$auth = estaAutenticado();
if(!$auth) {
    header('Location: /');}


require 'includes/config/database.php';
$db= conectarDB();



$errores = [];

$titulo = '';
$descripcion = '';
$autor = '';
$resumen= '';



if ($_SERVER['REQUEST_METHOD'] === 'POST') {


//echo "<pre>";  
//var_dump($_POST);
//echo "</pre>";  

//echo "<pre>";  
//var_dump($_FILES);
//echo "</pre>";  

    $titulo = $_POST['titulo'];
    $descripcion = $_POST['descripcion'];
    $fecha = date('Y/m/d');
    $autor = $_POST['autor'];
    $resumen = $_POST['resumen'];


   


$titulo = mysqli_real_escape_string( $db, $_POST['titulo'] );
$descripcion = mysqli_real_escape_string( $db, $_POST['descripcion'] );
$autor = mysqli_real_escape_string( $db, $_POST['autor'] );
$resumen = mysqli_real_escape_string( $db, $_POST['resumen'] ); 

$imagen= $_FILES['imagen'];

//var_dump($imagen);


if (!$titulo) {
    $errores[] = 'Debes añadir un título';
}

if (strlen($descripcion) < 60) {
    $errores[] = 'La Descripción es obligatoria y debe tener al menos 100 caracteres';
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


   
$carpetaImagenes = "./imagenes/";

if(!is_dir($carpetaImagenes)){
    mkdir($carpetaImagenes);
}
//nombre de imagen

$nombreImagen= md5(uniqid( rand(), true)) . ".jpg";
//subir la imagen

move_uploaded_file($imagen['tmp_name'], $carpetaImagenes . $nombreImagen);



    $query = "INSERT INTO blog (titulo, descripcion, fecha, autor, imagen, resumen) VALUES 
    ( '$titulo', '$descripcion', '$fecha', '$autor', '$nombreImagen', $'resumen')";
    
    
    $resultado = mysqli_query($db, $query);
    // var_dump($resultado);
    // printf("Nuevo registro con el id %d.\n", mysqli_insert_id($db));
    
    if ($resultado) {
    
        header('location: /admin.php?resultado=3');
    }
    }

   
}







include 'includes/templates/header.php';

?>



<main clas="container crear_producto">
<h1>Crear Nuevo Artículo</h1>

<a href="admin.php" class="boton-volver"><< Volver </a>

<?php foreach ($errores as $error) : ?>
    <div class="alerta error">
       <?php echo $error; ?> 
       </div>
    <?php endforeach; ?>

<form class="container form_crear_producto" method="POST" enctype="multipart/form-data">


<fieldset>
    <label for="nombre"> titulo</label>
    <input type="text" id="titulo" name="titulo" placeholder="Título de tu Artículo" value="<?php echo $titulo ?>"></input>

    <label for="resumen">Resumen</label>
    <textarea id="resumen" name="resumen"><?php echo $resumen ?></textarea>

    <label for="descripcion">Descripción</label>
    <textarea id="descripcion" name="descripcion"><?php echo $descripcion ?></textarea>

    <label for="autor">Autor</label>
    <input type="text" id="autor" name="autor" placeholder="Ejemplo : Admin" value="<?php echo $autor ?>">
</fieldset>

<fieldset>
    <legend>Imagen del Articulo</legend>
    <imagen for="imagen">Foto del producto</imagen>
    <input name="imagen" type="file" id="imagen" accept="image/jpg, image/png" value="<?php echo $imagen?>">


</fieldset>
<input class="boton_producto" type="submit" value="Agregar Artículo" >

</form>



</main>

<?php 

include 'includes/templates/footer.php';
mysqli_close($db); ?>
?>