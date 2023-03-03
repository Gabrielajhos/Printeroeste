<?php

include 'includes/config/database.php';
$db = conectarDB();

$consulta = "SELECT * FROM productos LIMIT ${limite}";

$resultado = mysqli_query($db, $consulta);


?>

    <section>

    <div class="contenedor-anuncios">

    <?php while($producto = mysqli_fetch_assoc($resultado)): ?>     

            <div class="anuncio"> 
               
        
                <div class="slider">
                
                   

                 <div class="section_img">

                    <img class="img1 slider_section"  loading="lazy" src="/imagenes/<?php echo $producto['imagen']; ?>" alt="anuncio">
            
                 </div>

    
 

                </div>
               

                <div class="contenido-anuncio">
                      
                   
                    <h3><?php echo $producto['nombre']; ?></h3>
                    <p><?php echo $producto['descripcion']; ?></p>
                    <p class="precio"><?php echo $producto['estado']; ?></p>
                    <p>Nuevo</p>

                    <ul class="iconos-caracteristicas">
                        <li>
                            <img class="icono" loading="lazy" src="build/img/copy-svgrepo-com.svg" alt="icono wc">
                            <p><?php echo $producto['copias']; ?></p>
                        </li>
                        <li>
                            <img class="icono" loading="lazy" src="build/img/time-past-sixty-svgrepo-com.svg" alt="icono estacionamiento">
                            <p><?php echo $producto['cpm']; ?></p>
                        </li>
                        <li>
                            <img class="icono" loading="lazy" src="build/img/size-actual-svgrepo-com.svg" alt="icono habitaciones">
                            <p>><?php echo $producto['vidrio']; ?></p>
                        </li>
                    </ul>
                
                       
                    <a href="https://wa.me/+5491126383489/?text= Hola! quisiera información sobre <?php echo $producto['nombre']; ?>" class="boton-amarillo-block what">
                        Consultar<span><img class="btn-what" src="build/img/WhatsApp-logo.png"></span>
                    </a>
 
                </div><!--.contenido-anuncio-->

                </div><!--anuncio-->
                <?php endwhile ?> 
    </div>
</section>  
