<?php
include 'includes/config/database.php';
$db = conectarDB();

$consulta = "SELECT * FROM blog";

$resultado = mysqli_query($db, $consulta);



include 'includes/templates/header.php';
?>

    <main class="contenedor seccion contenido-centrado">
        <h1>Nuestro Blog</h1>

        <?php while($blog = mysqli_fetch_assoc($resultado)): ?>     
        <article class="entrada-blog">
            <div class="imagen">
                <picture>
            
                    <img loading="lazy" src="imagenes/<?php echo $blog['imagen']; ?>" alt="Texto Entrada Blog">
                </picture>
            </div>

            <div class="texto-entrada">
                <a href="entrada.php?id=<?php echo $blog['id']; ?>">
                    <h4><?php echo $blog['titulo'] ?></h4>
                    <p>Escrito el: <span><?php  echo $blog['fecha'] ?></span> por: <span><?php echo $blog['autor'] ?></span> </p>

                    <p> <?php echo $blog['resumen'] ?></p>
                </a>
            </div>
        </article>

        <?php endwhile  ?>


    </main>
    <section>
        <a href="https://wa.me/+5491126383489?text=Hola! quisiera información sobre un producto de su pagina web. " class="whatsapp-button" target="_blank" style="position: fixed;  right: 15px; bottom: 105px;">
                <img src="https://i.ibb.co/VgSspjY/whatsapp-button.png" alt="whatsapp">
              </a>
        </section>  


    <?php

include 'includes/templates/footer.php';

?>

