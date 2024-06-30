<?php
    session_start();

    if(!isset($_SESSION['userName'])){
        header("Location: ../index.php");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>

    <?php $url = "http://".$_SERVER['HTTP_HOST']."/sitioweb" ?>

    <nav class="navbar navbar-expand navbar-light bg-light">
        <div class="nav navbar-nav">
            <a class="nav-item nav-link active" href="#">Administrador del sitio web: <?php echo $_SESSION['userName']; ?> <span class="sr-only">(current)</span></a>
            <a class="nav-item nav-link" href="<?php echo $url;?>/admin/inicio.php">Inicio</a>
            <a class="nav-item nav-link" href="<?php echo $url;?>/admin/section/products.php">Libros</a>
            <a class="nav-item nav-link" href="<?php echo $url;?>/admin/section/close.php">Cerrar sesión</a>
            <a class="nav-item nav-link" href="<?php echo $url; ?>" target="_blank">Ver sitio web</a>
        </div>
    </nav>

    <div class="container">
    <br/>
        <div class="row">