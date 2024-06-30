<?php include("template/header.php"); 

    include("admin/config/db.php");

    $sentenciaSelect = $conexion->prepare("SELECT * FROM libros;");
    $sentenciaSelect->execute();
    $bookList = $sentenciaSelect->fetchAll(PDO::FETCH_ASSOC);

    foreach($bookList as $bookInfo)
    {
?>
    <div class="col-md-3">
        <div class="card">
            <img class="card-img-top" src="img/<?php echo $bookInfo['imagen']; ?>">
            <div class="card-body">
                <h4 class="card-title"><?php echo $bookInfo['nombre']; ?></h4>
                <a name="" id="" class="btn btn-primary" href="#" role="button">Ver más</a>
            </div>
        </div>
    </div>
<?php } 

include("template/footer.php") ?> 
