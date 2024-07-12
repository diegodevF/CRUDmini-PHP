<?php
    require_once "../Modelo/verFactura.php";
    $misFacturas = new misFacturas();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Interfaz de Aplicación Básica</title>
    <link rel="stylesheet" href="index.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
    integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
    crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
    integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy"
    crossorigin="anonymous"></script>
</head>
<body>
    <div class="container">
        <h1>Facturacion de ventas</h1>
        
        <div class="vista-insertar">
            <h2>Insertar Item</h2>
            <form id="form-insertar" method="POST">
                <label for="concepto">Concepto</label>
                <input type="text" id="concepto" name="item" required>
                
                <label for="precio">Precio por Unidad</label>
                <input type="number" id="precio" name="precio" required>
                
                <label for="cantidad">Cantidad</label>
                <input type="number" id="cantidad" name="cantidad" required>
                
                <button type="submit" id="registrar">Añadir</button>
            </form>
        </div>

        <div class="vista-listado">
            <h2>Listado Facturación</h2>
            <table>
                <thead>
                    <tr>
                        <th>Concepto</th>
                        <th>Precio</th>
                        <th>Cantidad</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $cant = 0;
                        $respFacturas = $misFacturas->verFacturas();
                        foreach($respFacturas as $fila){?>
                        <tr>
                            <th><?php echo($fila['item']); ?></th>
                            <th><?php echo($fila['precio']); ?></th>
                            <th><?php echo($fila['cantidad']); ?></th>
                            <th><?php echo( $fila['precio'] * $fila['cantidad']); ?></th>
                        </tr>
                        <?php
                        $cant++;
                        }
                        ?>
                </tbody>
            </table>
        </div>

        <div class="vista-editar">
    <h2>Eliminar Item</h2>
    <form id="form-editar">
        <label for="item">Item</label>
        <select id="item" name="item" onchange="actualizarCampos()">
            <?php
                $respFacturas = $misFacturas->verFacturas();
                foreach($respFacturas as $fila){
                    echo '<option value="' . htmlspecialchars($fila['id_factura']) . '" data-precio="' . htmlspecialchars($fila['precio']) . '" data-cantidad="' . htmlspecialchars($fila['cantidad']) . '">';
                    echo htmlspecialchars($fila['item']);
                    echo '</option>';
                }
            ?>
        </select>
        
        <label for="precio-editar">Precio</label>
        <input type="number" id="precio-editar" name="precio-editar" readonly>

        <label for="cantidad-editar">Cantidad</label>
        <input type="number" id="cantidad-editar" name="cantidad-editar">

        <button type="submit" id="ModificarItem">Modificar Item</button>
        <button type="button" id="EliminarItem">Eliminar Item</button>
    </form>
</div>


        <!-- <div class="vista-totales">
            <h2>Totales</h2>
            <div class="totales">
                <div class="total-item">
                    <label for="num-items">Número de items</label>
                    <input type="number" id="num-items" readonly value="110">
                </div>
                <div class="total-item">
                    <label for="subtotal">Subtotal</label>
                    <input type="number" id="subtotal" readonly value="376.0">
                </div>
                <div class="total-item">
                    <label for="iva">IVA</label>
                    <input type="number" id="iva" readonly value="56.4">
                </div>
                <div class="total-item">
                    <label for="total">Total</label>
                    <input type="number" id="total" readonly value="432.4">
                </div>
            </div>
        </div>
    </div> -->

    <script src="../Controlador/factura.js"></script>
    <script type="text/javascript">
            $(document).ready(function(){
                iniciarPagina()
            })
        </script>
        <script>
    function actualizarCampos() {
        const select = document.getElementById("item");
        const selectedOption = select.options[select.selectedIndex];
        
        const precio = selectedOption.getAttribute("data-precio");
        const cantidad = selectedOption.getAttribute("data-cantidad");
        
        document.getElementById("precio-editar").value = precio;
        document.getElementById("cantidad-editar").value = cantidad;
    }
    
    // Inicializa los campos de precio y cantidad al cargar la página
    window.onload = function() {
        actualizarCampos();
    };
</script>

</body>
</html>
