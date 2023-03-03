<?php

require 'includes/funciones.php';
// Proteger esta ruta.
$auth = estaAutenticado();
if(!$auth) {
    header('Location: /');}

// BASE DE DATOS
require 'includes/config/database.php';
$db= conectarDB();

$search = [''];

if (isset($_GET['search'])) {

    $search = mysqli_real_escape_string($db, $_GET['search']);
    $query = "SELECT * FROM productos WHERE nombre or clasificacion LIKE '%${search}%'";
    $result = mysqli_query($db, $query);

   
}

$resultado= $_GET['resultado'] ?? NULL;

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
    }}  




include 'includes/templates/header.php';
?>

<a href="logout.php" class="btn-out boton-rojo"> Salir de administrador << </a>

<section class="tablas-admin">
    <h2>Productos</h2>

<a href="admin.php" class="boton-volver"><< Volver </a>

    
<div class="contenedor">
    <form method="GET">
        <legend>Buscador</legend>


        <label>Buscar por clasificación</label>
        <select name="search">
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
<input type="submit" value="search">

<input type="submit" value="Mostrar Todos">

    </form>
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



<?php while( $productos = mysqli_fetch_assoc($result) ): ?>
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
<sectio>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</sectio>