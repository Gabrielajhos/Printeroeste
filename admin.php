<?php

require 'includes/funciones.php';
// Proteger esta ruta.
$auth = estaAutenticado();
if(!$auth) {
    header('Location: login.php');}

// BASE DE DATOS
require 'includes/config/database.php';
$db= conectarDB();


$query1= 'SELECT * FROM productos LIMIT 5';
$resultadoconsulta= mysqli_query($db, $query1);



$query2= 'SELECT * FROM blog LIMIT 5';
$resultadoconsulta2= mysqli_query($db, $query2);

//MENSAJE CONDICIONAL
$resultado= $_GET['resultado'] ?? NULL;




//BORRAR PRODUCTOS
if($_SERVER['REQUEST_METHOD'] === 'POST'){

$id= $_POST['id_eliminar'];
$id= filter_var($id, FILTER_VALIDATE_INT);
if($id){

//eliminar archivo
$query= "SELECT imagen FROM productos WHERE id= ${id}";

$resultado= mysqli_query($db, $query);
$producto= mysqli_fetch_assoc($resultado);

unlink('./imagenes/' . $producto['imagen']);

//eliminar producto
 $query= "DELETE FROM productos  WHERE id= ${id}";

 $resultado2 = mysqli_query($db, $query);

 if ($resultado2) {
        header('Location: /admin.php?resultado=5');
 }



    //eliminar archivo de blog
$query3= "SELECT imagen FROM blog WHERE id= ${id}";

    $resultado3= mysqli_query($db, $query3);
    $blog= mysqli_fetch_assoc($resultado3);
    
    unlink('./imagenes/' . $blog['imagen']);
    
    
    //eliminar articulo
$query3= "DELETE FROM blog  WHERE id= ${id}";
    
$resultado4 = mysqli_query($db, $query3);
    
        if ($resultado4) {
            header('Location: /admin.php');
        }



}
}

// TEMPLATE
include 'includes/templates/header.php';
?>
<a href="logout.php" class="btn-out boton-rojo"> Salir de administrador << </a>


<mai> 
<h1> Administra tus productos y publicaciones</h1>

<?php if($resultado == 1):  ?>

<p class="alerta exito">Poducto  Creado Correctamente</p>

<?php elseif($resultado == 2): ?>
        <p class="alerta exito">Producto Actualizado Correctamente</p>
        <?php elseif($resultado == 5): ?>
        <p class="alerta exito">Producto Eliminado con exito!</p>
    <?php endif ?>
   
      
</mai>

<section class="tablas-admin">
    <h2>Productos</h2>

    <div class="botones">
    <a href="crearproducto.php" class="new">Crear nuevo producto >> </a>
    <a href="productosTodos.php" class="all">ver todos >> </a>
    </div>
    <div class=" div-tabla">
   <table class=tabla>
   <thead>
    <tr>
        <th class="encabezado0">Foto</th>
        <th class="encabezado1">id</th>
        <th class="encabezado2">Nombre</th>
        <th class="encabezado3">descripcion</th>
        <th class="encabezado4">Acciones</th>
    </tr>
</thead>
<tbody>

<?php while( $productos = mysqli_fetch_assoc($resultadoconsulta) ): ?>
    <tr>
        <td>
        <img src="imagenes/<?php echo $productos['imagen']; ?>"" width="100" class="imagen-tabla">
        </td>
        <td><?php echo $productos['id']; ?></td>
        <td><?php echo $productos['nombre']; ?></td>
        <td class="ocult"><?php echo $productos['descripcion']; ?></td>
        <td>
        <form method="POST">
                    <input type="hidden" name="id_eliminar" value="<?php echo $productos['id']; ?>">
                    <input type="submit" href="borrar.php" class="botones boton-rojo" value="Borrar">
                </form>
                    
                    <a href="actualizarproducto.php?id=<?php echo $productos['id']; ?>" class="botones boton-verde">Actualizar</a>
        </td>
        
        
    </tr>
    <?php endwhile; ?>  


</tbody>
   </table>
</div>
</section>



<section class="tablas-admin"> 
    <h2 > Administrar blog</h2>

    <?php if($resultado == 3):  ?>

<p class="alerta exito"> Creaste un nuevo articulo para tu blog!</p>

<?php elseif($resultado == 4): ?>
        <p class="alerta exito">Artículo actualizado correctamente!</p>
    <?php endif ?>
   
    <div >

    <div class="botones">
    <a href="crearblog.php" class="new">Crear nuevo artículo >> </a>
    <a href="articulosTodos.php" class="all">ver todos >> </a>
    </div>

    <table class=tabla>
   <thead>
    <tr>
        <th class="encabezado0">Foto</th>
        <th class="encabezado1">Id</th>
        <th class="encabezado2">Título</th>
        <th class="encabezado3">descripción</th>
        <th class="encabezado">Fecha</th>
        <th class="encabezado4 acciones">  Acciones  </th>

    </tr>
</thead>
<tbody>
<?php while( $blog = mysqli_fetch_assoc($resultadoconsulta2) ): ?>
    <tr>
        <td> 
        <img src="imagenes/<?php echo $blog['imagen']; ?>"" width="100" class="imagen-tabla">
        </td>
        <td><?php echo $blog['id']; ?></td>
        <td><?php echo $blog['titulo']; ?></td>
        <td class="ocult"><?php echo $blog['resumen']; ?></td>
        <td><?php echo $blog['fecha']; ?></td>
       <td>
       <form class="form-eliminar" method="POST">
                    <input type="hidden" name="id_eliminar" value="<?php echo $blog['id']; ?>">
                    <input type="submit" href="borrar.php" class="botones eliminar boton-rojo" value="Borrar">
                </form>
                    
                    <a href="actualizarblog.php?id=<?php echo $blog['id']; ?>" class="botones boton-verde">Actualizar</a>

       </td>
        
        
    </tr>

    <?php endwhile; ?>  
    
</tbody>
   </table>

   </div>
</section>

<section>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script src="src/js/confirmaciones.js"></script>
</section>

<?php
include 'includes/templates/footer.php';

?>

