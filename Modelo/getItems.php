<?php
require_once("conexion.php");

class MisItems {
    function obtenerItems() {
        $conexion = new Conexion();
        
        $consulta = "SELECT precio, cantidad FROM factura"; // Ajusta la consulta según tu esquema de base de datos
        $modulos = $conexion->prepare($consulta);
        $modulos->execute();

        $items = array();
        while ($row = $modulos->fetch(PDO::FETCH_ASSOC)) {
            $items[] = $row;
        }

        // Devolver los datos en formato JSON
        header('Content-Type: application/json');
        echo json_encode($items);
    }
}

$misItems = new MisItems();
$misItems->obtenerItems();
?>
