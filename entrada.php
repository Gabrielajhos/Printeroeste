<?php

include 'includes/config/database.php';
$db = conectarDB();

$id = $_GET['id'];

$consulta = "SELECT * FROM blog WHERE id= ${id}";
$resultado = mysqli_query($db, $consulta);


include 'includes/templates/header.php';
?>

<?php while($blog = mysqli_fetch_assoc($resultado)): ?>    

    <main class="contenedor seccion contenido-centrado">
        <h1><?php echo $blog['titulo'] ?></h1>

   
        <picture class="img-art">
           
            <img  loading="lazy" src="imagenes/<?php echo $blog['imagen']; ?>" alt="imagen del articulo">
        </picture>

        <p class="informacion-meta">Escrito el: <span><?php  echo $blog['fecha'] ?></span> por: <span><?php echo $blog['autor'] ?></span> </p>


        <div class="resumen-propiedad"> <?php echo $blog['descripcion'] ?></div>
    </main>
    <section>
        <a href="https://wa.me/+5491126383489?text=Hola! quisiera información sobre un producto de su pagina web. " class="whatsapp-button" target="_blank" style="position: fixed;  right: 15px; bottom: 105px;">
                <img src="https://i.ibb.co/VgSspjY/whatsapp-button.png" alt="whatsapp">
              </a>
        </section>  

<?php endwhile ?>
    <?php

include 'includes/templates/footer.php';

?>

