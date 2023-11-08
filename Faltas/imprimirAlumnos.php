<?php

function imprimirAlumnado($grupoSeleccionado): void
{
    require "../loginInfo.php";


    echo '<div class="encabezado"><div>Check</div><div>Sesion</div><div>Nombre y apellidos</div><div>Tipo de falta</div></div>';
    try {
        $conn = new PDO("mysql:host=$servername;dbname=faltas", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $conn->prepare("SELECT * FROM alumno  inner join usuario on alumno.dni=usuario.dni where idCurso=:idCurso");
        $stmt->bindParam(':idCurso', $grupoSeleccionado);
        $stmt->execute();
        $datosAlumno = $stmt->fetchAll();
        $longitud = count($datosAlumno);
        $_SESSION["numAlumnosInserccion"]=$longitud;
        $conn = "";
    } catch (PDOException $e) {
        echo "Conneccion fallida: " . $e->getMessage();
    }
    for ($i = 0; $i < $longitud; $i++) {
        try {
            //TODO: Al cambiar la fecha que se actualice el display
            if (!isset($fecha)) {
                $fecha = date("Y-m-d");
            }
            $cialAlumnoMostrar = $datosAlumno[$i][0];
            $conn = new PDO("mysql:host=$servername;dbname=faltas", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $conn->prepare("SELECT * FROM falta  where cial=:cial and dia=:dia");
            $stmt->bindParam(':cial', $cialAlumnoMostrar);
            $stmt->bindParam(':dia', $fecha);
            $stmt->execute();
            $faltas = $stmt->fetchAll();
            $numFaltas = count($faltas);

            echo "<div class=datosAlumno>";
            echo "<div class=navAlumno><input type=checkbox> " . $datosAlumno[$i][3] . " " . $datosAlumno[$i][4] . " " . $datosAlumno[$i][5] . "</div>";


            for ($j = 1; $j <= 6; $j++) {
                $checked = "";
                $existeFalta = "";
                $idfalta = "";
                $disabled = "";
                for ($w = 0; $w < $numFaltas; $w++) {
                    if ($faltas[$w][3] == $j) {
                        $existeFalta = "faltaExistente";
                        $checked = "checked";
                        $disabled = "disabled";
                        $idfalta = $faltas[$w][0];
                        break;
                    }
                }
                $nombreCheck = $i . "checkbox$j";
                echo "<div class=$existeFalta>" . "<input type='checkbox' $disabled " . "" . "class=secretoCorto name='$nombreCheck'  $checked >";

                echo "<input type=hidden name=" . $j . "faltaExistente$i value=" . $idfalta . ">";

                echo "<input type=hidden name=cialAlumno$i value=" . $datosAlumno[$i][0] . ">" .
                    "<div class=secretoCorto>$j</div><p>" . $datosAlumno[$i][3] . " " . $datosAlumno[$i][4] . " " . $datosAlumno[$i][5] . " </p><div></div></div>";
            }
        } catch (PDOException $e) {
            echo "Conneccion fallida: " . $e->getMessage();
        }
        echo "</div>";
    }
}