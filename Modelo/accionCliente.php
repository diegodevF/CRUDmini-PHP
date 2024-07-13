<?php
require_once 'conexion.php';
$conexion = new Conexion();

if (isset($_GET['accion'])) {
    $accion = $_GET['accion'];

    if ($accion == "registrar"){

        $nombre = $_POST['nombre'];
        $documento = $_POST['documento'];

        $query = "INSERT INTO cliente(nombre, documento) VALUES (?,?)";
        $reg = $conexion->prepare($query);

        $reg->bindParam(1, $nombre);
        $reg->bindParam(2, $documento);

        if($reg->execute()){
            echo 1;
        }else{
            echo 0;
        }
    }
}