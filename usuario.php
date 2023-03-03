<?php
require 'includes/config/database.php';
$db= conectarDB();


$usuario = "Gustavo";
$password = "printer.10";

    $passwordHash = password_hash($password, PASSWORD_BCRYPT);
    // echo strlen($passwordHash);


    // echo $passwordHash;


    $query = "INSERT INTO usuarios (usuario, password) VALUES('${usuario}', '${passwordHash}') ";

    echo $query;

    mysqli_query($db, $query);


?>