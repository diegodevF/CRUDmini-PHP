
//Evento para validar campos
function iniciarPagina(event){
    $('#registrar').click(function(evt){
        evt.preventDefault();
        console.log("Validando campos...");
        validarCampos();
    });

    //Evento para registrar item
    $('#registrar').click(function(evt){
        evt.preventDefault();
        console.log("Registrando Items...");
        registrarItems();
    });

    //Evento para editar tiems
    $('#EditarItems').click(function(evt){
        evt.preventDefault();
        console.log("Editando Items...");
        editarItems();
    });

    //Evento para elimiar items
    $('#EliminarItems').click(function(evt){
        evt.preventDefault();
        console.log("Eliminar items...");
        eliminarCategoria();
    });
}

function validarCampos() {
    let concepto = document.getElementById("concepto");
    let precio = document.getElementById("precio");
    let cantidad = document.getElementById("cantidad");
    let err = 0;

    if (concepto.value.trim() === "") {
        alert("El campo concepto es obligatorio");
        concepto.focus();
        return false;
    }

    if (precio.value.trim() === "" || isNaN(precio.value) || Number(precio.value) <= 0) {
        alert("El campo precio es obligatorio y debe ser un número mayor que 0");
        precio.focus();
        return false;
    }

    if (cantidad.value.trim() === "" || isNaN(cantidad.value) || Number(cantidad.value) <= 0) {
        alert("El campo cantidad es obligatorio y debe ser un número mayor que 0");
        cantidad.focus();
        return false;
    }

    if (err < 1) {
        console.log("VAMOS A REGISTRAR EL USUARIO");
        registrarItems();
    }
    else {
        console.log("FALTA DILIGENCIAR LA INFORMACIÃ“N");
    }

    return true;
}

//Funcion eliminar items
function registrarItems() {
    let item = $('#concepto').val();
    let precio = $('#precio').val();
    let cantidad = $('#cantidad').val();

    let cadena = 'item=' + item + '&precio=' + precio + "&cantidad=" + cantidad;

    $.ajax({
        type: 'POST', // Protocolos HTTP -> Enviar información
        url: '../Modelo/accionFactura.php?accion=registrar',
        data: cadena,
        async: true,
        success: function (r) { // r -> Respuesta del servidor
            if(r == 0) {
                alert("No se pudo registrar la información.");
            } else if(r == 1) {
                alert("La información se registró correctamente.");
            } else {
                alert("Error desconocido."+ r);
            }
        },
        error: function (e) {
            alert("Error con el servidor: " + e);
        }
    });

}

//Funcion editar Items
function editarItems() {
    let id_factura = $('#item').val(); // Obtiene el ID del ítem seleccionado
    let precio = $('#precio-editar').val(); // Obtiene el precio del formulario
    let cantidad = $('#cantidad-editar').val(); // Obtiene la cantidad del formulario

    let cadena = "id_factura=" + id_factura + "&precio=" + precio + "&cantidad=" + cantidad;
    console.log(cadena);

    $.ajax({
        type: "POST", // Protocolo HTTP -> Enviar información
        url: "../Modelo/accionFactura.php?accion=editar",
        data: cadena,
        async: true,
        success: function (r) { // r -> Respuesta del servidor
            console.log("r: ", r); // Visualizar el valor de respuesta r
            if (r == 0) {
                alert("ERROR... No se pudo editar el ítem.");
            } else if (r == 1) {
                alert("El ítem se editó correctamente.");
            } else {
                alert("ERROR... Error del servidor.");
            }
        },
        error: function (e) {
            alert("Error con el servidor: " + e);
        }
    });
}

// Agrega un evento de escucha al formulario para que se envíe la solicitud AJAX al hacer clic en "Modificar Item"
document.getElementById('form-editar').addEventListener('submit', function(event) {
    event.preventDefault(); // Previene que el formulario se envíe de la manera tradicional
    editarItems(); // Llama a la función para editar el ítem
});



    //Funcion eliminar items
    function eliminarCategoria() {
        let id_cat = $('#id_cat').val(); // se obtiene la var del formulario
        let cadena = "id_cat=" + id_cat;  
        //alista la var para enviarla al archivo acciones
    
        $.ajax({
            type: "POST", // Protocolos HTTP -> Enviar información
            url: "../../model/accionesCategoria.php?accion=eliminar",
            data: cadena,
            async: true,
            success: function (r) { // r -> Respuesta del servidor
                console.log("r: " , r); // Visualizar el valor de repuesta r
                if(r == 0) {
                    alert("ERROR... No se pudo eliminar la categoria.");
                } else if(r == 1) {
                    alert ("El elemento se elimino correctamente.")
                    self.location="../categorias.php"
                    //location.reload(); //instrucción para recargar la página
                } else {
                    alert("ERROR... Error de servidor.");
                }
            },
            error: function (e) {
                alert("Error con el servidor: " + e);
            }
        });
    
    }
