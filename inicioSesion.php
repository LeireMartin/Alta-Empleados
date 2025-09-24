<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php
    $conexion = mysqli_connect("localhost:3307", "root", "", "2daw") or
        die("Problemas con la conexion");

    $usuario = $_REQUEST["correo"];
    $clave = $_REQUEST["pass"];
    try {
        
        $claveCorrecta=mysqli_query($conexion, query:"select * from usuarios where Usuario_email='$correo' and Usuario_clave='$pass'");
        $fila= mysqli_fetch_row($claveCorrecta);
        if($fila<1){
          mysqli_query($conexion,query:"update usuarios set Usuario_numero_intentos=Usuario_intentos+1 where Usuario_email='$correo'");
          $intentos=mysqli_query($conexion,query:"select Usuario_numero_intentos from usuarios where Usuario_email='$correo'");
          $filaIntentos=mysqli_fetch_row($intentos);
          if($filaIntentos[0]>3){
            mysqli_query($conexion,query:"update usuarios set Usuario_bloqueado=1 where Usuario_email='$correo'");
            throw new Exception("Usuario bloqueado");
            
          }
            throw new Exception("Contraseña incorrecta");
        }else{
            mysqli_query($conexion,query:"update usuarios set Usuario_numero_intentos=0 where Usuario_email='$correo'");
            echo "Inicio de sesion correcto";
            

        }
    } catch (\Throwable $th) {
        //throw $th;
    }
   


    ?>
</body>

</html>