<?php
require_once 'conexion.php';
$conexion = new Conexion();

if (isset($_GET['accion'])) {
    $accion = $_GET['accion'];

    if ($accion == "registrar"){

        $item = $_POST['item'];
        $precio = $_POST['precio'];
        $cantidad = $_POST['cantidad'];

        $query = "INSERT INTO factura(item, precio, cantidad) VALUES (?,?,?)";
        $reg = $conexion->prepare($query);

        $reg->bindParam(1, $item);
        $reg->bindParam(2, $precio);
        $reg->bindParam(3, $cantidad);

        if($reg->execute()){
            echo 1;
        }else{
            echo 0;
        }
    }
    elseif ($accion == "editar") {
        $id_factura = $_POST['id_factura'];
        $precio = $_POST['precio'];
        $cantidad = $_POST['cantidad'];
    
        // Verifica que los valores estén presentes
        if(empty($id_factura) || empty($precio) || empty($cantidad)){
            echo 0; // Error en los datos recibidos
            exit();
        }
    
        $sqlReg = "UPDATE factura SET precio = :precio, cantidad = :cantidad WHERE id_factura = :id_factura";
        $reg = $conexion->prepare($sqlReg);
    
        $reg->bindParam(':precio', $precio);
        $reg->bindParam(':cantidad', $cantidad);
        $reg->bindParam(':id_factura', $id_factura, PDO::PARAM_INT);
    
        if ($reg->execute()) {
            echo 1;
        } else {
            echo 0;
        }
    }
    
    elseif($accion == "eliminar") {

        $id_factura = $_POST['id_factura'];
        $precio = $_POST['precio'];
        $cantidad = $_POST['cantidad'];

    $sqlDel = "DELETE FROM `factura` WHERE `factura`.`id_factura` = ?" ;

        $del = $conexion->prepare($sqlDel);
        $del->bindParam(1, $id_factura);

        // Verificamos que se ejecutó la consulta
        if($del->execute()) {
            echo 1;
        } else {
            echo 0;
        }
    }
    else {
        echo 0;
    }
}
?>