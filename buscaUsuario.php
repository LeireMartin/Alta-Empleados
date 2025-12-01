<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuarios</title>
    <style>
        table {
            border: 1px;
        }
    </style>
</head>


<body>
    <?php
    session_start();
    $conexion = mysqli_connect("localhost:3307", "root", "", "2daw") or
        die("Problemas con la conexion");
     $getNombre = isset($_GET['nombre']) ? trim($_GET['nombre']) : '';
    $getPerfil = $_GET['perfil'] !== "Todos" ? trim($_GET['perfil']) : '';

    $sql = "SELECT Usuario_id, Usuario_email, Usuario_nombre, Usuario_bloqueado, Usuario_perfil from usuarios ";
        $arr = array();if ($getNombre != '') {
            $arr[] = " Usuario_nombre LIKE '%$getNombre%'";
        }

        if ($getPerfil != '') {
            $arr[] = "Usuario_perfil = '$getPerfil'";
        }

        if(count($arr) > 0){
            $sql .= 'WHERE '.implode(' AND ', $arr).";";
        }

        $registros = mysqli_query($conn, $sql);



        while ($reg = mysqli_fetch_array($registros)) {
            $bloqueado = $reg["Usuario_bloqueado"];
            $perfil = $reg["Usuario_perfil"];
            $id = $reg["Usuario_id"];
            if($perfil == 0) $perfil = "usuario";
            ?>
            <tr><td><?=$id?></td><td><?=$reg["Usuario_nombre"]?></td>
            <td><?=$reg["Usuario_email"]?></td>
            <td><?=$perfil?></td>
            <td><a href="#"><button class="boton-tabla">MODIFICAR</button></a></td>
            <td><a href="eliminar.php?id=<?=$id?>&perfil=<?=$getPerfil?>&nombre=<?=$getNombre?>">ELIMINAR</a></td>
            <td><input type="checkbox" name="ids[]" value="<?=$id?>"></td>
            <td><a href="bloquear.php?id=<?=$id?>&perfil=<?=$getPerfil?>&nombre=<?=$getNombre?>"><?=($bloqueado == 1) ? 'desbloquear':'bloquear'?></a></td>
        </tr>
            
            <?php } ?>
</body>

</html>