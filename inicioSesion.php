<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php
    session_start();
    $conexion = mysqli_connect("localhost:3307", "root", "", "2daw") or
        die("Problemas con la conexion");
    //RECIBIR USUARIO Y CONTRASEÑA INTRODUCIDA
    $usuario = $_POST["correo"];
    $clave = $_POST["pass"];

    try {

        //SACO TODA LA INFORMACION DEL USUARIO INTRODUCIDO
        $datosUsuario = mysqli_query($conexion, query: "select * from usuarios where Usuario_email='$usuario'");
        $fila = mysqli_fetch_array($datosUsuario);
        //SACO LA CONTRASEÑA GUARDADA
        $hashAlmacenado = $fila['Usuario_clave'];

        if (password_verify($clave, $hashAlmacenado)) {

            mysqli_query($conexion, query: "update usuarios set Usuario_numero_intentos=0 where Usuario_email='$usuario'");
            $_SESSION["usuario"] = $usuario;
            echo "Inicio de sesion correcto: " . $_SESSION["usuario"];
            $tipoUser = $fila['Usuario_perfil'];
            if ($tipoUser == "admin") {
                header("Location: InicioAdmin.html");
            } else {
                header("Location: Inicio.html");
            }
        } else {
            echo "Contraseña incorrecta";

            //añadeintentos de inicio de sesion
            mysqli_query($conexion, query: "update usuarios set Usuario_numero_intentos=(Usuario_intentos+1) where Usuario_email='$usuario'");
            $intentos = mysqli_query($conexion, query: "select Usuario_numero_intentos from usuarios where Usuario_email='$usuario'");
            $filaIntentos = mysqli_fetch_row($intentos);
            //al llegar a 3 intentos se bloquea
            if ($filaIntentos[0] > 3) {
                echo "Usuario bloqueado";
                mysqli_query($conexion, query: "update usuarios set Usuario_bloqueado=1 where Usuario_email='$usuario'");
                throw new Exception("Usuario bloqueado");
            }
            throw new Exception("Contraseña incorrecta");
        }
    } catch (\Throwable $th) {
        //throw $th;
    }



    ?>
</body>

</html>