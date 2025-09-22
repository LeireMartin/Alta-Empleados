<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Comprobacion de empleados</title>
</head>

<body>
    

    <?php
    $conexion = mysqli_connect("localhost:3307", "root", "", "2daw") or
        die("Problemas con la conexion");

    $clave1 = $_REQUEST["clave1"];
    $clave2 = $_REQUEST["clave2"];
    $correo = $_REQUEST["mail"];
    try {
        #Comprueba correo
        $correoRegistrado = mysqli_query($conexion, query: "select * from usuarios where Usuario_email ='$correo'");
        $fila = mysqli_fetch_row($correoRegistrado);
        if ($fila !== null) {

            throw new Exception("Usuario ya registrado");
        }
        #Comprueba clave
        if ($clave1 != $clave2) {
            throw new Exception("Las cotraseñas no coinciden");
        } else {
            mysqli_query($conexion, "insert into usuarios(Usuario_email,Usuario_clave) values
                    ('$_REQUEST[mail]','$_REQUEST[clave1]')")
                or die("Problema con la consulta..." . mysqli_error($conexion));
            echo "Usuario registrado";
        }
    } catch (\Throwable $e) {
        echo "Error: " . $e->getMessage();
    }

    mysqli_close($conexion);
    echo "\n"
    ?>
    <input type="button" value="Volver" onclick="window.history.back()">

</body>

</html>