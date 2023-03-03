<?php

require 'includes/funciones.php';
// Proteger esta ruta.
$auth = estaAutenticado();
if(!$auth) {
    header('Location: /');}

// BASE DE DATOS
require 'includes/config/database.php';
$db= conectarDB();

$query2= 'SELECT * FROM blog LIMIT 5';
$resultadoconsulta2= mysqli_query($db, $query2);

//MENSAJE CONDICIONAL
$resultado= $_GET['resultado'] ?? NULL;


if($_SERVER['REQUEST_METHOD'] === 'POST'){

    $id= $_POST['id_eliminar'];
    $id= filter_var($id, FILTER_VALIDATE_INT);
    if($id){

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
<section class="tablas-admin"> 
    <h2 > Administrar blog</h2>
    <a href="admin.php" class="boton-volver"><< Volver </a>
    <?php if($resultado == 3):  ?>

<p class="alerta exito"> Creaste un nuevo articulo para tu blog!</p>

<?php elseif($resultado == 4): ?>
        <p class="alerta exito">Artículo actualizado correctamente!</p>
    <?php endif ?>
   

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
       <form method="POST">
                    <input type="hidden" name="id_eliminar" value="<?php echo $blog['id']; ?>">
                    <input type="submit" href="borrar.php" class="botones boton-rojo" value="Borrar">
                </form>
                    
                    <a href="actualizarblog.php?id=<?php echo $blog['id']; ?>" class="botones boton-verde">Actualizar</a>

       </td>
        
        
    </tr>

    <?php endwhile; ?>  
    
</tbody>
   </table>

   </div>
</section>