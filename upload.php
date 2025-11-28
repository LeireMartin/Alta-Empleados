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
    
    $foto = $_FILES['fileToUpload']['tmp_name'];
    if($foto==null){
        $foto= "";
    echo "No se ha subido ninguna foto, se asigna foto por defecto";

    }
    ?>
</body>
</html>

