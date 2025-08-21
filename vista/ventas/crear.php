<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <title>Registrar Venta</title>
</head>

<body data-bs-theme="dark" style="color: #FFFFFF;">
    <?php include '../vista/componentes/navbar.php'; ?>
    <div class="d-flex" id="wrapper">
        <div class="w-100 p-4 text-center">
            <?php include '../vista/componentes/header.php'; ?>
            <h4>Registrar Venta</h4>
            <form action="../controlador/ventaControlador.php?action=crearVenta" method="POST" id="formVenta">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label for="sucursal" class="form-label">Sucursal</label>
                        <select class="form-select" name="sucursal_id" id="sucursal_id">
                            <?php foreach ($sucursales as $sucursal): ?>
                                <option value="<?php echo $sucursal['id']; ?>"><?php echo $sucursal['sucursal']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="total" class="form-label">Total Venta</label>
                        <input type="number" class="form-control" id="total" name="total" value="0" readonly>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="total_ganancias" class="form-label">Total Ganancias</label>
                        <input type="number" class="form-control" id="total_ganancias" name="total_ganancias" value="0" readonly>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="descuento" class="form-label">Descuento</label>
                        <input type="number" class="form-control" id="descuento" name="descuento" value="0">
                    </div>
                </div>
                <h5>Detalle Ventas</h5>
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label for="producto" class="form-label">Producto</label>
                        <select class="form-select" name="producto_id" id="producto_id">
                            <?php foreach ($productos as $producto): ?>
                                <option value="<?php echo $producto['id']; ?>"><?php echo $producto['producto']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="color" class="form-label">Color</label>
                        <select class="form-select" name="color_id" id="color_id" disabled>
                        </select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="cantidad" class="form-label">Cantidad</label>
                        <input type="number" class="form-control" id="cantidad" name="cantidad">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="precio" class="form-label">Precio</label>
                        <input type="number" class="form-control" id="precio" name="precio">
                    </div>
                </div>
                <button type="button" class="btn btn-secondary" onclick="agregarProducto();">Agregar Producto</button>
                <input type="text" class="form-control" id="productos" name="productos" hidden>
                <table class="table table-striped w-100" id="tablaProductos">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Color</th>
                            <th>Cantidad</th>
                            <th>Precio</th>
                            <th>Subtotal</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
                <button type="submit" class="btn btn-primary">Registrar</button>
            </form>
        </div>
    </div>
    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
    <script>
        const productos = [];

        function agregarProducto() {
            const productoId = document.getElementById('producto_id').value;
            const colorId = document.getElementById('color_id').value;
            const cantidad = document.getElementById('cantidad').value;
            const precio = document.getElementById('precio').value;
            const productoText = document.querySelector(`#producto_id option[value="${productoId}"]`).textContent;
            const colorText = document.querySelector(`#color_id option[value="${colorId}"]`).textContent;
            const total = document.getElementById('total');

            const nuevoProducto = {
                producto: productoText,
                color: colorText,
                cantidad: cantidad,
                precio: precio,
                color_id: colorId,
                producto_id: productoId,
                subtotal: cantidad * precio
            };
            total.value = parseFloat(total.value) + nuevoProducto.subtotal;
            productos.push(nuevoProducto);
            actualizarTablaProductos();
        }

        function actualizarTablaProductos() {
            const tablaProductos = document.getElementById('tablaProductos').getElementsByTagName('tbody')[0];
            tablaProductos.innerHTML = '';
            productos.forEach((producto, index) => {
                const fila = tablaProductos.insertRow();
                fila.insertCell(0).textContent = producto.producto;
                fila.insertCell(1).textContent = producto.color;
                fila.insertCell(2).textContent = producto.cantidad;
                fila.insertCell(3).textContent = producto.precio;
                fila.insertCell(4).textContent = producto.subtotal;
                const celdaAcciones = fila.insertCell(5);
                celdaAcciones.innerHTML = `<button class="btn btn-danger" onclick="eliminarProducto(${index})">Eliminar</button>`;
            });
        }

        function eliminarProducto(index) {
            const total = document.getElementById('total');
            total.value = parseFloat(total.value) - productos[index].subtotal;
            productos.splice(index, 1);
            actualizarTablaProductos();

        }

        document.getElementById('formCompra').addEventListener('submit', function(event) {
            event.preventDefault();
            const productosInput = document.getElementById('productos');
            const gastosInput = document.getElementById('gastos');
            productosInput.value = JSON.stringify(productos);
            gastosInput.value = JSON.stringify(gastos);
            this.submit();
        });

        document.getElementById('producto_id').addEventListener('change', function() {
            const productoId = this.value;
            const colorSelect = document.getElementById('color_id');
            colorSelect.innerHTML = '';
            obtenerColoresPorProducto(productoId);
            colorSelect.disabled = false;
        });

        function obtenerColoresPorProducto(productoId) {
            fetch(`../controlador/ventaContolador.php?producto_id=${productoId}`)
                .then(response => response.json())
                .then(data => {
                    const colorSelect = document.getElementById('color_id');
                    colorSelect.innerHTML = '';
                    data.forEach(color => {
                        const option = document.createElement('option');
                        option.value = color.id;
                        option.textContent = color.color;
                        colorSelect.appendChild(option);
                    });
                    colorSelect.disabled = false;
                });
        }
    </script>
</body>

</html>