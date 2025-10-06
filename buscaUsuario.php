<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuarios</title>
    <style>
        table{
            border: 1px;
        }
    </style>
</head>
    <!-- Almenos 3 campos para filtrar-->

<body>
    <?php
    session_start();
    $nombre = $_POST["nombre"];
    $conexion = mysqli_connect("localhost:3307", "root", "", "2daw") or
        die("Problemas con la conexion");

    $registros = mysqli_query($conexion, "select Usuario_id, Usuario_nombre, Usuario_email
                        from usuarios where Usuario_nombre='$_REQUEST[nombre]'") or
        die("Problemas en el select:" . mysqli_error($conexion));

    if ($nombre === '') {
        $registros = mysqli_query($conexion, "select Usuario_id, Usuario_email, Usuario_nombre
                        from usuarios") or
            die("Problemas en el select:" . mysqli_error($conexion));

        while ($reg = mysqli_fetch_array($registros)) {
            echo "<table> <tr></tr>";
            echo "<td>Nombre: " . $reg['Usuario_nombre'] . "</td>";
            echo "<td>Mail:   " . $reg['Usuario_email'] . "</td>";
            echo "</tr></table>";
        }
    } elseif ($reg = mysqli_fetch_array($registros)) {
        echo "Mail:" . $reg['Usuario_email'] . "<br>";
        echo "Nombre:" . $reg['Usuario_nombre'] . "<br>";
    } else {
        echo "No existe un usuario con ese nombre.";
    }
    mysqli_close($conexion);
    ?>
</body>

</html>