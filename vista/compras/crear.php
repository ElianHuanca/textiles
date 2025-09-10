<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <title>Registrar Compra</title>
</head>

<body data-bs-theme="dark" style="color: #FFFFFF;">
    <?php include '../vista/componentes/navbar.php'; ?>
    <div class="d-flex" id="wrapper">
        <div class="w-100 p-4 text-center">
            <?php include '../vista/componentes/header.php'; ?>
            <h4>Registrar Compra</h4>
            <form action="../controlador/compraControlador.php?action=crearCompra" method="POST" id="formCompra">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label for="fecha" class="form-label">Fecha</label>
                        <input type="date" class="form-control" id="fecha" name="fecha" value="<?php echo date('Y-m-d'); ?>" required>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="sucursal" class="form-label">Sucursal</label>                        
                        <select class="form-select" name="sucursal_id" id="sucursal_id">
                            <?php foreach ($sucursales as $sucursal): ?>
                                <option value="<?php echo $sucursal['id']; ?>"><?php echo $sucursal['sucursal']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="total" class="form-label">Total Compras</label>
                        <input type="number" class="form-control" id="total" name="total" value="0" readonly>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="total_gastos" class="form-label">Total Gastos</label>
                        <input type="number" class="form-control" id="total_gastos" name="total_gastos" value="0" readonly>
                    </div>
                </div>
                <h5>Detalle Compras</h5>
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
                        <select class="form-select" name="color_id" id="color_id">
                            <?php foreach ($colores as $color): ?>
                                <option value="<?php echo $color['id']; ?>"><?php echo $color['color']; ?></option>
                            <?php endforeach; ?>
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
                <h5>Detalle Gastos</h5>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="" class="form-label">Tipo Gasto</label>
                        <select name="tipo_gasto_id" id="tipo_gasto_id" class="form-select">
                            <?php foreach ($tipos_gastos as $tipo_gasto): ?>
                                <option value="<?php echo $tipo_gasto['id']; ?>"><?php echo $tipo_gasto['tipo_gasto']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="gasto" class="form-label">Gasto</label>
                        <input type="text" class="form-control" id="gasto" name="gasto">
                    </div>
                </div>
                <button type="button" class="btn btn-secondary" onclick="agregarGasto();">Agregar Gasto</button>
                <input type="text" class="form-control" id="gastos" name="gastos" hidden>
                <table class="table table-striped w-100" id="tablaGastos">
                    <thead>
                        <tr>
                            <th>Tipo Gasto</th>
                            <th>Gasto</th>
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
        const gastos = [];
        const productos = [];

        function agregarGasto() {
            const tipoGastoId = document.getElementById('tipo_gasto_id').value;
            const gasto = parseFloat(document.getElementById('gasto').value);
            const tipoGastoText = document.querySelector(`#tipo_gasto_id option[value="${tipoGastoId}"]`).textContent;
            const totalGastos = document.getElementById('total_gastos');
            const nuevoGasto = {
                tipo_gasto_id: tipoGastoId,
                tipo_gasto: tipoGastoText,
                gasto: gasto
            };
            gastos.push(nuevoGasto);
            totalGastos.value = parseFloat(totalGastos.value) + gasto;
            actualizarTablaGastos();
        }

        function actualizarTablaGastos() {
            const tablaGastos = document.getElementById('tablaGastos').getElementsByTagName('tbody')[0];
            tablaGastos.innerHTML = '';
            gastos.forEach((gasto, index) => {
                const fila = tablaGastos.insertRow();
                fila.insertCell(0).textContent = gasto.tipo_gasto;
                fila.insertCell(1).textContent = gasto.gasto;
                const celdaAcciones = fila.insertCell(2);
                celdaAcciones.innerHTML = `<button class="btn btn-danger" onclick="eliminarGasto(${index})">Eliminar</button>`;
            });
        }

        function eliminarGasto(index) {
            const totalGastos = document.getElementById('total_gastos');
            totalGastos.value = parseFloat(totalGastos.value) - parseFloat(gastos[index].gasto);
            gastos.splice(index, 1);
            actualizarTablaGastos();
        }

        function agregarProducto() {
            const productoId = document.getElementById('producto_id').value;
            const colorId = document.getElementById('color_id').value;
            const cantidad = parseFloat(document.getElementById('cantidad').value);
            const precio = parseFloat(document.getElementById('precio').value);
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
                subtotal: parseFloat((cantidad * precio).toFixed(2))
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

        document.getElementById('formCompra').addEventListener('submit', function (event) {
            event.preventDefault();
            const productosInput = document.getElementById('productos');
            const gastosInput = document.getElementById('gastos');
            productosInput.value = JSON.stringify(productos);
            gastosInput.value = JSON.stringify(gastos);
            this.submit();
        });
    </script>
</body>

</html>