function iniciarPagina(){
    $('#registrar').click(function(evt) {
        evt.preventDefault();
        console.log("Validando campos...");
        if (validarCampos()) {
            console.log("Registrando Items...");
            registrarCliente();
        } else {
            console.log("Falta diligenciar la información");
        }
    });
}

function validarCampos() {
    let nombre = document.getElementById("nombre");
    let documento = document.getElementById("documento");
    let errores = 0;

    // Validar campo nombre
    if (nombre.value.trim() === "") {
        alert("El campo nombre es obligatorio");
        nombre.focus();
        errores++;
    }

    // Validar campo documento
    if (documento.value.trim() === "" || isNaN(documento.value) || Number(documento.value) <= 0) {
        alert("El campo documento es obligatorio y debe ser un número mayor que 0");
        documento.focus();
        errores++;
    }

    // Retornar verdadero si no hay errores, falso en caso contrario
    return errores === 0;
}


function registrarCliente() {
    let nombre = $('#nombre').val();
    let documento = $('#documento').val();

    let cadena = 'nombre=' + nombre + '&documento=' + documento ;

    $.ajax({
        type: 'POST',
        url: '../Modelo/accionCliente.php?accion=registrar',
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