<?php
    require_once "../Modelo/verFactura.php";
    require_once "../Modelo/verCliente.php";
    $misFacturas = new misFacturas();
    $misClientes = new misClientes();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Interfaz de Aplicación Básica</title>
    <link rel="stylesheet" href="index.css">
    <?php
        require_once("../Bibliotecas/addOns.php");
    ?>
</head>
<body>
    <div class="container">
        <h1>Facturacion de ventas</h1>
        
        <div class="vista-insertar">
            <h2>Insertar Item</h2>
            <form id="form-insertar" method="POST">
                <label for="concepto">Item</label>
                <input type="text" id="concepto" name="item" required>
                
                <label for="precio">Precio por Unidad</label>
                <input type="number" id="precio" name="precio" required>
                
                <label for="cantidad">Cantidad</label>
                <input type="number" id="cantidad" name="cantidad" required>
                
                <button type="submit" id="registrar">Añadir Item</button>
                <button id="añadir-cliente"> <a href="./cliente.php">Añadir Cliente</a> </button>
            </form>
        </div>

        <div class="vista-listado">
            <div class="mostrar-cliente">
                <h4>Cliente: <?php
            $cliente = $misClientes->verClientes();
            echo htmlspecialchars($cliente['nombre']); 
            ?>
            </h4>
            <h4>
               Documento del cliente: <?php echo htmlspecialchars($cliente['documento']);  ?>
            </h4>
            </div>

    <h2>Listado Facturación</h2>
    <table id="tablaFacturacion">
        <thead>
            <tr>
                <th>Id Factura</th>
                <th>Item</th>
                <th>Precio</th>
                <th>Cantidad</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $respFacturas = $misFacturas->verFacturas();
                foreach($respFacturas as $fila){
                    echo '<tr>';
                    echo '<td>' . htmlspecialchars($fila['id_factura']) . '</td>';
                    echo '<td>' . htmlspecialchars($fila['item']) . '</td>';
                    echo '<td>' . htmlspecialchars($fila['precio']) . '</td>';
                    echo '<td>' . htmlspecialchars($fila['cantidad']) . '</td>';
                    echo '<td>' . ($fila['precio'] * $fila['cantidad']) . '</td>';
                    echo '</tr>';
                }
            ?>
        </tbody>
    </table>
</div>

<div class="vista-editar">
    <h2>Eliminar Item</h2>
    <form id="form-editar">
        <label for="item">Item</label>
        <select id="item" name="item">
            <?php
                foreach($respFacturas as $fila){
                    echo '<option id="id_factura" value="' . htmlspecialchars($fila['id_factura']) . '" data-precio="' . htmlspecialchars($fila['precio']) . '" data-cantidad="' . htmlspecialchars($fila['cantidad']) . '">';
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

<div class="vista-totales">
            <h2>Totales</h2>
            <div class="totales">
                <div class="total-item">
                    <label for="num-items">Número de items</label>
                    <input type="number" id="num-items" readonly value="0">
                </div>
                <div class="total-item">
                    <label for="subtotal">Subtotal</label>
                    <input type="number" id="subtotal" readonly value="0">
                </div>
                <div class="total-item">
                    <label for="iva">IVA</label>
                    <input type="number" id="iva" readonly value="0">
                </div>
                <div class="total-item">
                    <label for="total">Total</label>
                    <input type="number" id="total" readonly value="0">
                </div>
            </div>
        </div>
    </div>


            <!--ENTRADA DE SCRIPTS-->
            <!-- Acciones facturas en Javascripts -->
    <script src="../Controlador/factura.js"></script>

    <script type="text/javascript">
            $(document).ready(function(){
                iniciarPagina()
            })
    </script>

<!-- Actualizar los campos de items -->
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

<!-- ELiminar el item del listado sin eliminarlo de la base de datos -->
<script>
  $(document).ready(function() {
    // Función para eliminar el ítem del listado y de la tabla de facturación
    $('#EliminarItem').click(function() {
        var selectedItem = $('#item').val(); // Obtener el valor seleccionado del select

        if (selectedItem) {
            // Eliminar la opción del select
            $('#item option[value="' + selectedItem + '"]').remove();

            // Eliminar la fila correspondiente en la tabla de listado de facturación
            $('.vista-listado table tbody').find('tr').each(function() {
                var idFactura = $(this).find('td:first-child').text();
                if (idFactura === selectedItem) {
                    $(this).remove();
                    return false; // Salir del bucle al encontrar y eliminar la fila
                }
            });

            // Limpiar los campos de precio y cantidad después de eliminar
            $('#precio-editar').val('');
            $('#cantidad-editar').val('');
            
            alert('Ítem eliminado del listado y de la tabla de facturación.');
        } else {
            alert('Selecciona un ítem para eliminar del listado.');
        }
    });

    // Evento change en el select para actualizar los campos de precio y cantidad
    $('#item').change(function() {
        var selectedItem = $(this).val();
        var selectedOption = $(this).find('option:selected');

        if (selectedOption.length > 0) {
            var precio = selectedOption.data('precio');
            var cantidad = selectedOption.data('cantidad');

            $('#precio-editar').val(precio); // Actualizar el campo de precio
            $('#cantidad-editar').val(cantidad); // Actualizar el campo de cantidad
        } else {
            $('#precio-editar').val(''); // Limpiar el campo de precio si no hay opción seleccionada
            $('#cantidad-editar').val(''); // Limpiar el campo de cantidad si no hay opción seleccionada
        }
    });

    // Evento submit del formulario (para modificar el ítem, si necesario)
    $('#form-editar').submit(function(event) {
        event.preventDefault(); // Prevenir el envío del formulario de manera tradicional
        // Aquí puedes agregar la lógica para enviar los datos modificados al servidor si es necesario
    });
});
</script>

<!-- Totales -->
<script>
$(document).ready(function() {
    function actualizarTotales(items) {
        let numItems = 0;
        let subtotal = 0;
        const porcentajeIVA = 0.19; // 21% IVA

        items.forEach(item => {
            numItems += item.cantidad;
            subtotal += item.precio * item.cantidad;
        });

        let iva = subtotal * porcentajeIVA;
        let total = subtotal + iva;

        $('#num-items').val(numItems);
        $('#subtotal').val(subtotal.toFixed(2));
        $('#iva').val(iva.toFixed(2));
        $('#total').val(total.toFixed(2));
    }

    $.ajax({
        url: "../Modelo/getItems.php",
        type: "GET",
        dataType: "json",
        success: function(data) {
            actualizarTotales(data);
        },
        error: function(xhr, status, error) {
            console.error("Error al obtener los datos:", status, error);
            alert("Error al obtener los datos.");
        }
    });
});

</script>

</body>
</html>
