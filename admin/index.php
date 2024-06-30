<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrador del sitio web</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>

<?php
    session_start();

    include("config/db.php");

    if($_POST)
    {
        $userId  = $_POST['id'];
        $userPwd = $_POST['password'];

        try{
            $query = $conexion->prepare("SELECT * FROM usuario WHERE id = :id and contrasenia = :pwd;");
            $query->bindParam(":id", $userId);
            $query->bindParam(":pwd", $userPwd);
            $query->execute();
            $userData = $query->fetch(PDO::FETCH_LAZY);
            
            if($userData)
            {
                $_SESSION['userName'] = $userData['nombre'];
                header('Location:inicio.php');
            }
            else{
                echo "<script>alert('La contraseña esta incorrecta');</script>";
            }

        }catch(Exception $ex){
            echo $ex->getMessage();
        }

    }

?>

    <div class="container">
        <div class="row">

            <div class="col-md-4"></div>

            <div class="col-md-4">
                <br/><br/><br/>
                <div class="card">
                    <div class="card-header"> 
                        Login
                    </div>

                    <div class="card-body">
                        <form action="" method ="post">
                            
                            <div class="form-group">
                                <label for="inputUser">ID Usuario</label>
                                <input type="text" class="form-control" id="inputUser" name="id" placeholder ="Ingrese su id">
                                <small id="userHelp" class="form-text text-muted" >Nosotros no compartiremos nunca informacion a otros</small>
                            </div>

                            <div class="form-group">
                                <label for="inputPassword">Contraseña</label>
                                <input type="password" class="form-control" id="inputPassword" name ="password" placeholder ="Ingrese su contraseña">
                            </div>

                            <button type="submit" class="btn btn-primary">Iniciar sesión administrador</button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>

</body>
</html>