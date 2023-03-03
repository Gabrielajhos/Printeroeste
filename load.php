<?php

include 'includes/config/database.php';
$db = conectarDB();




if (isset($_GET['search'])) {

    $search = mysqli_real_escape_string($db, $_GET['search']);
    $query = "SELECT * FROM productos WHERE nombre or clasificacion LIKE '%${search}%'";
    echo $query;
    $result = mysqli_query($db, $query);

   
}

include 'includes/templates/header.php';

?>

<div class="contenedor">
    <form method="GET" enctype="multipart/form-data" >
        <legend>Buscador</legend>

        <label for="search">Buscar por nombre </label>
        <input id="search" name="search" placeholder="Nombre del producto">

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

 
<?php if (mysqli_num_rows($result) > 0) :
 while ( $productos = mysqli_fetch_assoc($result)) : ?>
        <tr>
        <td>
        <img src="imagenes/<?php echo $productos['imagen']; ?>"" width="100" class="imagen-tabla">
        </td>
        <td><?php echo $productos['id']; ?></td>
        <td><?php echo $productos['nombre']; ?></td>
        <td><?php echo $productos['descripcion']; ?></td>
        <td>
        <form method="POST">
                    <input type="hidden" name="id_eliminar" value="<?php echo $productos['id']; ?>">
                    <input type="submit" href="borrar.php" class="botones boton-rojo" value="Borrar">
                </form>
                    
                    <a href="actualizarproducto.php?id=<?php echo $productos['id']; ?>" class="botones boton-verde">Actualizar</a>
        </td>
        
        
    </tr>
   
    <?php endwhile; ?>  
    <?php endif; ?>
 

</tbody>
   </table>
</div>
</section>
    


   