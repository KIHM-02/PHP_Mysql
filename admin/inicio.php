<?php include('template/header.php') ?>

            <div class="col-md-12">
                
                <div class="jumbotron">
                    <h1 class="display-3">Bienvenido <?php echo $_SESSION['userName']; ?>!</h1>
                    <p class="lead">La funcion del adminitrador es agregar, modificar y borrar libros, diviertete haciendo eso!</p>
                    <hr class="my-2">
                    <p class="lead">
                        <a class="btn btn-primary btn-lg" href="section/products.php" role="button">Seccion libros</a>
                    </p>
                </div>

            </div>
            
<?php include('template/footer.php') ?>