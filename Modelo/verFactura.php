<?php
require_once("../Vista/index.php");

class misFacturas{
    function verFacturas(){
        require_once("conexion.php");
        $conexion = new Conexion();
        $arreglo = array();

        $consulta = "SELECT id_factura, item, precio, cantidad FROM `factura` ";
        $modulos = $conexion -> prepare(($consulta));
        $modulos -> execute();

        $total = $modulos -> rowCount();
        if($total > 0){
            $a = 0;
            while($row = $modulos -> fetch(PDO::FETCH_ASSOC)){
                $arreglo[$a] = $row;
                $a++;
            }
        }
        return $arreglo;
    }
}
?>
