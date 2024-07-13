// Evento para inicializar la página y agregar eventos a los botones
function iniciarPagina() {
    // Evento para registrar ítem
    $('#registrar').click(function(evt) {
        evt.preventDefault();
        console.log("Validando campos...");
        if (validarCampos()) {
            console.log("Registrando Items...");
            registrarItems();
        } else {
            console.log("Falta diligenciar la información");
        }
    });

    // Evento para editar ítem
    $('#EditarItems').click(function(evt) {
        evt.preventDefault();
        console.log("Editando Items...");
        editarItems();
    });

    // Evento para eliminar ítem
    $('#EliminarItem').click(function(evt) {
        evt.preventDefault();
        console.log("Eliminando Items...");
        eliminarItem();
    });
}

// Función para validar los campos
function validarCampos() {
    let concepto = document.getElementById("concepto");
    let precio = document.getElementById("precio");
    let cantidad = document.getElementById("cantidad");
    let errores = 0;

    // Validar campo concepto
    if (concepto.value.trim() === "") {
        alert("El campo concepto es obligatorio");
        concepto.focus();
        errores++;
    }

    // Validar campo precio
    if (precio.value.trim() === "" || isNaN(precio.value) || Number(precio.value) <= 0) {
        alert("El campo precio es obligatorio y debe ser un número mayor que 0");
        precio.focus();
        errores++;
    }

    // Validar campo cantidad
    if (cantidad.value.trim() === "" || isNaN(cantidad.value) || Number(cantidad.value) <= 0) {
        alert("El campo cantidad no debe estar vacío y debe ser un número mayor que 0");
        cantidad.focus();
        errores++;
    }

    // Retornar verdadero si no hay errores, falso en caso contrario
    return errores === 0;
}

// Función para registrar ítems
function registrarItems() {
    let item = $('#concepto').val();
    let precio = $('#precio').val();
    let cantidad = $('#cantidad').val();

    let cadena = 'item=' + item + '&precio=' + precio + "&cantidad=" + cantidad;

    $.ajax({
        type: 'POST',
        url: '../Modelo/accionFactura.php?accion=registrar',
        data: cadena,
        async: true,
        success: function(r) {
            if (r == 0) {
                alert("No se pudo registrar la información.");
            } else if (r == 1) {
                alert("La información se registró correctamente.");
                self.location = "../Vista/index.php";
            } else {
                alert("Error desconocido." + r);
            }
        },
        error: function(e) {
            alert("Error con el servidor: " + e);
        }
    });
}

// Función para editar ítems
function editarItems() {
    let id_factura = $('#item').val();
    let precio = $('#precio-editar').val();
    let cantidad = $('#cantidad-editar').val();

    let cadena = "id_factura=" + id_factura + "&precio=" + precio + "&cantidad=" + cantidad;
    console.log(cadena);

    $.ajax({
        type: "POST",
        url: "../Modelo/accionFactura.php?accion=editar",
        data: cadena,
        async: true,
        success: function(r) {
            console.log("r: ", r);
            if (r == 0) {
                alert("ERROR... No se pudo editar el ítem.");
            } else if (r == 1) {
                alert("El ítem se editó correctamente.");
                self.location = "../Vista/index.php";
            } else {
                alert("ERROR... Error del servidor.");
            }
        },
        error: function(e) {
            alert("Error con el servidor: " + e);
        }
    });
}

// Evento para el formulario de edición para evitar envío tradicional
document.getElementById('form-editar').addEventListener('submit', function(event) {
    event.preventDefault();
    editarItems();
});

// Función para eliminar ítems
function eliminarItem() {
    let id_factura = $('#id_factura').val();
    let item = $('#item').val();
    let precio = $('#precio').val();
    let cantidad = $('#cantidad').val();

    let cadena = "id_factura=" + id_factura + "&item" + item + "&precio=" + precio + "&cantidad=" + cantidad;
    console.log(cadena);

    $.ajax({
        type: "POST",
        url: "../Modelo/accionFactura.php?accion=eliminar",
        data: cadena,
        async: true,
        success: function(r) {
            console.log("r: ", r);
            if (r == 0) {
                alert("ERROR... No se pudo eliminar la categoria.");
            } else if (r == 1) {
                alert("El elemento se eliminó correctamente.");
                self.location = "../Vista/index.php";
            } else {
                alert("ERROR... Error de servidor.");
            }
        },
        error: function(e) {
            alert("Error con el servidor: " + e);
        }
    });
}

// Inicializar la página y configurar eventos
