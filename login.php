<?php


// Incluir conexion
require 'includes/config/database.php';
$db= conectarDB();

$errores = [];


if($_SERVER['REQUEST_METHOD'] === 'POST') {
    // echo "<pre>";
    // var_dump($_POST);
    // echo "</pre>";

    $usuario = $_POST['usuario'];
    $email = mysqli_real_escape_string($db,  $usuario);

    $password = mysqli_real_escape_string($db,  $_POST['password'] );


    if(!$usuario) {
        $errores[] = 'El usuario no es válido';
    }

    if(!$password) {
        $errores[] = 'El Password es obligatorio';
    }
  
    if(empty($errores)) {
  
        // Revisar si el usuario existe
        $query = "SELECT * FROM usuarios WHERE usuario = '${usuario}' ";
        $resultado = mysqli_query($db, $query);

        // El usuario existe.

        if($resultado->num_rows) {
            // Revisar si el password esta bien
            $usuario = mysqli_fetch_assoc($resultado);
    
            // Password a revisar y el de la BD.
            $auth = password_verify($password, $usuario['password']);

            if($auth) {
                // Autenticado.

                // Para autenticar usuarios estaremos utilizando la superglobal SESSION, esta va a mantener eso una sesión activa en caso de que sea valida.

                session_start();
                $_SESSION['usuario'] = $usuario['usuario'];
                $_SESSION['id'] =$usuario['id'];
                $_SESSION['login'] = true;
                if($_SESSION){
                    header('location: /admin.php');
                   }
            } else {
                // No autenticado
                $errores[] = 'El Password es incorrecto';
            }
        
        } else {

            $errores[] = 'El Usuario no existe';
        }
   
    }
}

include 'includes/templates/header.php';
?>

<main class="contenedor seccion contenido-centrado">
    <h1 class="fw-300 centrar-texto">Adiministrador</h1>
    <h2>Iniciar sesión</h2>

    <?php foreach ($errores as $error) : ?>
        <div class="alerta error">
            <?php echo $error; ?>
        </div>
    <?php endforeach; ?>

    <form method="POST" class="formulario" novalidate>
        <fieldset>
            <legend>usuario y Password</legend>
            <label for="usuario">Usuario</label>:</label>
            <input type="text" name="usuario" id="usuario" placeholder="Tu Usuario" >

            <label for="password">Password: </label>
            <input type="password" name="password" id="password" placeholder="Tu Password" >
        </fieldset>
        <input type="submit" value="Iniciar Sesión" class="boton boton-verde">
    </form>
</main>

<?php
include 'includes/templates/footer.php';

?>