<?php

    $host = "localhost";
    $db = "sitio";
    $user = "root";
    $password = "";

    try{
        $conexion = new PDO("mysql:host=$host;dbname=$db", $user, $password);
    }
    catch(Exception $ex){
        echo $ex->getMessage();
    }
?>