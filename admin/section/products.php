<?php include("../template/header.php") ?>
<?php 
    $id         = (isset($_POST['txtId']))? $_POST['txtId'] : "";
    $bookName   = (isset($_POST['txtName']))? $_POST['txtName']: "";
    $image      = (isset($_FILES['imgImage']['name']))? $_FILES['imgImage']['name']: "";
    $accion     = (isset($_POST['accion']))? $_POST['accion']: "";

    include("../config/db.php");

    switch($accion)
    {
        case "add":
                try{
                    $sentenciaSQL = $conexion->prepare("INSERT INTO libros(nombre, imagen) VALUES(:nombre, :imagen);");
                    $sentenciaSQL->bindParam(':nombre', $bookName);
                    
                    $date = new DateTime();
                    $fileName = ($image != "")? $date->getTimestamp()."_".$_FILES['imgImage']['name'] : "imagen.jgp";
                    
                    $tmpImage = $_FILES['imgImage']['tmp_name'];
                    
                    if($tmpImage != "")
                    {
                        move_uploaded_file($tmpImage, "../../img/".$fileName);
                        $sentenciaSQL->bindParam(':imagen', $fileName); 
                        $sentenciaSQL->execute();
                    }
                }
                catch(Exception $er){
                    echo $er->getMessage();
                }
                header("Location: products.php");
                
            break;

        case "update":
                try{
                    $sentenciaSQL;

                    if($image != "")
                    {

                        $sentenciaSelect = $conexion->prepare("SELECT imagen FROM libros WHERE id = :id;");
                        $sentenciaSelect->bindParam(':id', $id);
                        $sentenciaSelect->execute();
                        $bookImage = $sentenciaSelect->fetch(PDO::FETCH_LAZY);

                        if(isset($bookImage["imagen"]) && file_exists("../../img/".$bookImage["imagen"]))
                        {
                            unlink("../../img/".$bookImage["imagen"]);
                        }

                        $date = new DateTime();
                        $fileName = $date->getTimestamp()."_".$_FILES['imgImage']['name'];
                        $tmpImage = $_FILES['imgImage']['tmp_name'];

                        if($tmpImage != "")
                        {
                            move_uploaded_file($tmpImage, "../../img/".$fileName);

                            $sentenciaUpdate = $conexion->prepare("UPDATE libros SET nombre = :nombre, imagen = :imagen WHERE id = :id ");
                            $sentenciaUpdate->bindParam(':id', $id);
                            $sentenciaUpdate->bindParam(':nombre', $bookName);
                            $sentenciaUpdate->bindParam(':imagen', $fileName); 
                            $sentenciaUpdate->execute();
                        }
                    }
                    else
                    {
                        $sentenciaSQL = $conexion->prepare("UPDATE libros SET nombre = :nombre WHERE id = :id ");
                        $sentenciaSQL->bindParam(':id', $id);
                        $sentenciaSQL->bindParam(':nombre', $bookName);
                        $sentenciaSQL->execute();
                    }
                }
                catch(Exception $er){
                    echo $er->getMessage();
                }

                header("Location: products.php");

            break;

        case "cancel":
            header("Location: products.php");
            break;

        case "select":
                try{
                    $sentenciaSQL = $conexion->prepare("SELECT * FROM libros WHERE id = :id;");
                    $sentenciaSQL->bindParam(':id', $id);
                    $sentenciaSQL->execute();
                    $bookInfo = $sentenciaSQL->fetch(PDO::FETCH_LAZY);

                    $bookName = $bookInfo['nombre'];
                    $image = $bookInfo['imagen'];
                }
                catch(Exception $er){
                    echo $er->getMessage();
                }
            break;

        case "delete":
                try{

                    $sentenciaSQL = $conexion->prepare("SELECT imagen FROM libros WHERE id = :id;");
                    $sentenciaSQL->bindParam(':id', $id);
                    $sentenciaSQL->execute();
                    $bookInfo = $sentenciaSQL->fetch(PDO::FETCH_LAZY);

                    if(isset($bookInfo["imagen"]) && ($bookInfo["imagen"] != "imagen.jpg"))
                    {
                        if(file_exists("../../img/".$bookInfo["imagen"]))
                        {
                            unlink("../../img/".$bookInfo["imagen"]);
                            
                            $sentenciaSQL = $conexion->prepare("DELETE FROM libros WHERE id = :id;");
                            $sentenciaSQL->bindParam(':id', $id);
                            $sentenciaSQL->execute();
                        }
                    }
                }
                catch(Exception $er){
                    echo $er->getMessage();
                }
            
                header("Location: products.php");
            break;
    }

    $sentenciaSelect = $conexion->prepare("SELECT * FROM libros;");
    $sentenciaSelect->execute();
    $bookList = $sentenciaSelect->fetchAll(PDO::FETCH_ASSOC); //This var storage every book from the table
?>
    <div class="col-md-5">

        <div class="card">
            <div class="card-header">
                Datos libros
            </div>

            <div class="card-body">
                <form action="products.php" method ="POST" enctype = "multipart/form-data">                    
                    <div class="form-group">
                        <label for="inputId">ID</label>
                        <input type="text" required readonly class="form-control" id="inputId" name="txtId" value="<?php echo $id;?>" placeholder ="Ingrese el ID">
                    </div>
        
                    <div class="form-group">
                        <label for="inputId">Nombre</label>
                        <input type="text" required class="form-control" id="inputName" name="txtName" value="<?php echo $bookName;?>" placeholder ="Ingrese el nombre">
                    </div>
        
                    <div class="form-group">
                        <label for="inputImg">Imagen: 
                            <?php if($image != "") {
                                    echo "<img src = '../../img/".$image."' width =80'>";
                                }
                                else{
                                    echo $image;
                                } ?>
                        </label>
                        <input type="file" class="form-control" id="inputImg" name="imgImage">
                    </div>
        
                    <div class="btn-group" role="group">
                        <button type="submit" <?php echo ($accion  != "select")? "" : "disabled"; ?> name ="accion" value ="add" class="btn btn-success">Agregar</button>
                        <button type="submit" <?php echo ($accion  == "select")? "" : "disabled"; ?> name ="accion" value ="update" class="btn btn-warning">Modificar</button>
                        <button type="submit" <?php echo ($accion  == "select")? "" : "disabled"; ?> name ="accion" value ="cancel" class="btn btn-info">Cancelar</button>
                    </div>
                </form>
            </div>
                
        </div>
    </div>


    <div class="col-md-7">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Imagen</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($bookList as $books) { ?>
                <tr>
                    <td><?php echo $books['id']; ?></td>
                    <td><?php echo $books['nombre']; ?></td>
                    <td>
                        <img src="../../img/<?php echo $books['imagen']; ?>" width="80" alt ="<?php echo $books['imagen']; ?>">
                    </td>
                    <td>
                        <form method ="POST">
                            <input type="hidden" name="txtId" id="txtId" value ="<?php echo $books['id']; ?>">
                            <input type="submit" name ="accion" value="select" class="btn btn-primary">
                            <input type="submit" name ="accion" value="delete" class="btn btn-danger">
                        </form>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

<?php include("../template/footer.php") ?>