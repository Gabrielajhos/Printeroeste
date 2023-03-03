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

$consulta = "SELECT * FROM blog WHERE id = ${id}";
$resultado = mysqli_query($db, $consulta);
$blog = mysqli_fetch_assoc($resultado);

$errores = [];

$titulo = $blog['titulo'];
$descripcion = $blog['descripcion'];
$autor = $blog['autor'];
$resumen = $blog['resumen'];




if ($_SERVER['REQUEST_METHOD'] === 'POST') {

   

    $titulo = $_POST['titulo'];
    $descripcion = $_POST['descripcion'];
    $autor = $_POST['autor'];
    $resumen = $_POST['resumen'];

    $imagen = $_FILES['imagen'] ?? null;


    if (!$titulo) {
        $errores[] = 'Debes añadir un titulo';
    }
    
    if (!$resumen) {
        $errores[] = 'Debes añadir un resumen';
    }

    if (strlen($descripcion) < 50) {
        $errores[] = 'La Descripción es obligatoria y debe tener al menos 50 caracteres';
    }
    

    $medida = 2 * 1000 * 1000;
  

    if ($imagen['size'] > $medida) {
        $errores[] = 'La Imagen es muy grande';
    }





    // El array de errores esta vacio
    if (empty($errores)) {
     
        $carpetaImagen = "./imagenes/";

        
        if($imagen['name']){
         
            unlink($carpetaImagen. $blog['imagen']);

                        
        $nombreImagen = md5(uniqid( rand(), true)) . ".jpg";
        
        move_uploaded_file($imagen['tmp_name'], $carpetaImagen . $nombreImagen);

        }else{

            $nombreImagen= $blog['imagen'];

        }



        $query = "UPDATE blog SET titulo = '${titulo}', descripcion = '${descripcion}', autor = '${autor}',
         imagen = '${nombreImagen}', resumen = '${resumen}' WHERE id = '${id}' ";
        // echo $query;


        $resultado = mysqli_query($db, $query) or die(mysqli_error($db));
        // var_dump($resultado);
        // printf("Nuevo registro con el id %d.\n", mysqli_insert_id($db));

        if ($resultado) {
            header('location: /admin.php?resultado=4');
        }
  

    // Insertar en la BD.

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

<form class="container form_crear_producto" method="POST"  entype="multipart/form-data">


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
    <input name="imagen" type="file" id="imagen" name="imagen" value="<?php echo $imagen ?>">


</fieldset>
<input class="boton_producto" type="submit" value="Agregar Artículo" >

</form>



</main>

<?php 

include 'includes/templates/footer.php';
mysqli_close($db); ?>
