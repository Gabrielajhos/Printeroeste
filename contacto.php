<?php
include 'includes/templates/header.php';
?>

<main class="contenedor seccion form-icons">
 <div class="redes-sociales">
        <ul>
  <li>
    <a href="https://www.facebook.com/PrinterOeste/">
      <i class="fab fa-facebook-f icon"></i>    </a>
  </li>
  <li>
    <a href="https://www.instagram.com/printeroeste/"><i class="fab fa-instagram icon"></i></a>
  </li>
  <li>
    <a href=" https://wa.me/+5491126383489"><i class="fab fa-whatsapp icon"></i></a></li>
  <li>
    <a href="https://www.google.com/search?q=printer+oeste&sxsrf=AJOqlzXjSd2uJUpWQDDyc8fqgC2n7Y3P1A%3A1676492251446&source=hp&ei=2z3tY72HGcfd5OUPyPeCqAk&iflsig=AK50M_UAAAAAY-1L62rgh84wrZeCTh89uB0oNdwR9dXk&oq=printe&gs_lcp=Cgdnd3Mtd2l6EAMYADIECCMQJzIECCMQJzIKCC4QxwEQrwEQQzIECAAQQzIQCAAQgAQQsQMQgwEQsQMQCjIFCAAQgAQyCwguEIAEEMcBEK8BMgsILhCABBDHARCvATIFCAAQgAQyCggAEIAEEBQQhwI6BwgjEOoCECc6CwgAEIAEELEDEIMBOgsILhCABBCxAxCDAToICAAQsQMQgwE6EQguEIAEELEDEIMBEMcBENEDOgYIIxAnEBM6CwguEIMBELEDEIAEOggIABCABBCxAzoKCC4QxwEQ0QMQQzoICC4QgAQQsQM6CwguEIAEEMcBENEDUMQFWIMSYIoZaAFwAHgAgAGZAYgBxAWSAQMxLjWYAQCgAQGwAQo&sclient=gws-wiz"><i class="fab fa-google icon"></i></a></li>
</ul>
    
</div>

</main>
   
   

    <section class="contenedor seccion form-contact">


        <h1>Contacto</h1>

     
        <picture>
            <img loading="lazy" src="build/img/tienda1.jpg" alt="Imagen Contacto">
        </picture>

        <h2>Llene el formulario de Contacto</h2>

        <form class="formulario">
            <fieldset>
                <legend>Información Personal</legend>

                <label for="nombre">Nombre</label>
                <input type="text" placeholder="Tu Nombre" id="nombre">

                <label for="email">E-mail</label>
                <input type="email" placeholder="Tu Email" id="email">

                <label for="telefono">Teléfono</label>
                <input type="tel" placeholder="Tu Teléfono" id="telefono">

                <label for="mensaje">Mensaje:</label>
                <textarea id="mensaje"></textarea>
            </fieldset>

            <fieldset>
                <legend>Información sobre la propiedad</legend>

                <p>Como desea ser contactado</p>

                <div class="forma-contacto">

                    <label for="contactar-telefono">Teléfono</label>
                    <input name="contacto" type="radio" value="telefono" id="contactar-telefono">

                    <label for="contactar-email">E-mail</label>
                    <input name="contacto" type="radio" value="email" id="contactar-email">
                </div>

                <p>Si eligió teléfono, elija la hora</p>

                <label for="hora">Hora:</label>
                <input type="time" id="hora" min="09:00" max="18:00">

            </fieldset>

            <input type="submit" value="Enviar" class="boton-verde">
        </form>

    </section>
   



    <?php

include 'includes/templates/footer.php';

?>

