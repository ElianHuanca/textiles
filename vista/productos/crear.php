<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Producto</title>
    <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">
</head>

<body data-bs-theme="dark" style="color: #FFFFFF;">
    <div class="container mt-5">
        <h2>Registrar Producto</h2>
        <form action="../controlador/productoControlador.php?action=crearProducto" method="POST" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="producto" class="form-label">Nombre del Producto</label>
                    <input type="text" class="form-control" id="producto" name="producto" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="categoria_id" class="form-label">Categoría</label>
                    <select class="form-select" id="categoria_id" name="categoria_id" required>
                        <option value="">Seleccione una categoría</option>
                        <?php
                        foreach ($categorias as $categoria) {
                            echo "<option value='{$categoria['id']}'>{$categoria['categoria']}</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Registrar</button>
        </form>
    </div>
</body>

</html>