<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Color</title>
    <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">
</head>

<body data-bs-theme="dark" style="color: #FFFFFF;">
    <div class="container mt-5">
        <h2>
            <?php echo "Producto: " . $producto['producto']; ?>
        </h2>
        <br>
        <h2>Agregar Color</h2>
        <form action="../controlador/productoControlador.php?action=agregarColor&producto_id=<?php echo $producto['id']; ?>" method="POST">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="color_id" class="form-label">Color</label>
                    <select name="color_id" id="color_id" class="form-select" required>
                        <option value="">Seleccione un color</option>
                        <?php
                        foreach ($coloresDisponibles as $color) {
                            echo "<option value='{$color['id']}'>{$color['color']}</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Registrar</button>
        </form>
        <br>
        <h3>Colores Registrados</h3>
        <table class="table table-dark">
            <thead>
                <tr>    
                    <th>ID</th>
                    <th>Color</th>
                    <th>Codigo</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($coloresRegistrados as $color) {
                    echo "<tr>";
                    echo "<td>{$color['id']}</td>";
                    echo "<td>{$color['color']}</td>";
                    echo "<td>{$color['codigo']}</td>";
                    echo "<td><a href='../controlador/productoControlador.php?action=eliminarColor&producto_id={$producto['id']}&color_id={$color['id']}' class='btn btn-danger'>Eliminar</a></td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
        <a href="../controlador/productoControlador.php?action=obtenerProductos" class="btn btn-secondary">Volver</a>
    </div>
</body>
</html>