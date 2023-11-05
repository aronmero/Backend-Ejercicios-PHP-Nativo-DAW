<?php
session_start();
if (isset($_SESSION["tipoUsuario"])) {

} else{
    $_SESSION["tipoUsuario"] = null;
}

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>DAW: Faltas</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href='estilo.css'>

</head>

<body>

    <?php
    if (!isset($_SESSION["tipoUsuario"])) {
        echo "<a href=iniciarSesion.php>Iniciar Sesion</a>";
    } else {
        if ($_SESSION["tipoUsuario"] == "alumno" || $_SESSION["tipoUsuario"] == "profesor") {
            echo "<a href=visualizarFalta.php>Visualizar faltas</a>";
        }
        if ($_SESSION["tipoUsuario"] == "profesor") {
            echo "<a href= insertarFalta.php>InsertarFalta</a>";
        }
    }
    
    ?>
    
</body>

</html>