<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="index.css">
    <?php
        require_once("../Bibliotecas/addOns.php");
    ?>
</head>
<body>
        <div class="vista-insertar">
            <h2>Ingresar Cliente</h2>
            <form id="form-insertar" method="POST">
                <label for="nombre">Nombre cliente</label>
                <input type="text" id="nombre" name="nombre" required>
                
                <label for="documento">Documento cliente</label>
                <input type="number" id="documento" name="documento" required>
                
                <button type="submit" id="registrar" name="registrar">Registrar Cliente</button>
            </form>
        </div>
        <script src="../Controlador/cliente.js"></script>

    <script type="text/javascript">
            $(document).ready(function(){
                iniciarPagina()
            })
    </script>
</body>
</html>