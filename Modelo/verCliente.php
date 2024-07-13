<?php
require_once("../Vista/index.php");

class misClientes {
    function verClientes() {
        require_once("conexion.php");
        $conexion = new Conexion();
        
        // Preparar la consulta SQL para obtener solo el primer cliente
        $consulta = "SELECT nombre, documento FROM `cliente` LIMIT 1";
        $modulos = $conexion->prepare($consulta);
        $modulos->execute();

        // Recuperar el primer cliente si existe
        $cliente = null;
        if ($modulos->rowCount() > 0) {
            $cliente = $modulos->fetch(PDO::FETCH_ASSOC);
        }

        return $cliente;
    }
}
?>
