<?php
    session_start( ); // iniciamos sesión
    /*
    Encriptamos la clave pasada por el formulario y luego la comparamos con el valor del captcha (almacenado en la variable de sesión)
    */
    $error = "Correcto";
    if(md5( $_POST['code'] ) != $_SESSION['key'])
      $error = "Incorrecto";
    echo $error;
?>