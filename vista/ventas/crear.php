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
                        <input type="text" class="form-control" id="total" name="total" value="0" readonly>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="total_ganancias" class="form-label">Total Ganancias</label>
                        <input type="text" class="form-control" id="total_ganancias" name="total_ganancias" value="0" readonly>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="descuento" class="form-label">Descuento</label>
                        <input type="text" class="form-control" id="descuento" name="descuento" value="0">
                    </div>
                </div>
                <h5>Detalle Ventas</h5>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="producto" class="form-label">Producto</label>
                        <select class="form-select" name="producto_id" id="producto_id">
                            <?php foreach ($productos as $producto): ?>
                                <option value="<?php echo $producto['id']; ?>"><?php echo $producto['producto']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="color" class="form-label">Color</label>
                        <select class="form-select" name="color_id" id="color_id" disabled>
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="stock" class="form-label">Stock</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="stock" name="stock" value="0" readonly>
                            <span class="input-group-text">MTS</span>
                        </div>
                        <input type="hidden" id="costo" name="costo" readonly>
                        <input type="hidden" id="categoria_id" name="categoria_id" readonly>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="cantidad" class="form-label">Cantidad</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="cantidad" name="cantidad">
                            <span class="input-group-text">MTS</span>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="precio" class="form-label">Precio</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="precio" name="precio">
                            <span class="input-group-text">BS</span>
                        </div>
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
                            <th>Ganancias</th>
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
            const cantidad = parseFloat(document.getElementById('cantidad').value);
            const stock = parseFloat(document.getElementById('stock').value);
            if (cantidad > stock) {
                alert('La cantidad supera el stock disponible.');
                return;
            }
            const productoId = document.getElementById('producto_id').value;
            const colorId = document.getElementById('color_id').value;
            const precio = parseFloat(document.getElementById('precio').value);
            const productoText = document.querySelector(`#producto_id option[value="${productoId}"]`).textContent;
            const colorText = document.querySelector(`#color_id option[value="${colorId}"]`).textContent;
            const totalInput = document.getElementById('total');
            const total_gananciasInput = document.getElementById('total_ganancias');
            const costo = parseFloat(document.getElementById('costo').value);
            const categoria_id = parseInt(document.getElementById('categoria_id').value);

            const ganancias = categoria_id != 2 ? (precio - costo) * cantidad : 0;

            const nuevoProducto = {
                producto: productoText,
                color: colorText,
                cantidad: cantidad,
                precio: precio,
                color_id: colorId,
                producto_id: productoId,
                subtotal: parseFloat((cantidad * precio).toFixed(2)),
                ganancias: ganancias
            };

            const producto = productos.find(p => p.producto_id === productoId && p.color_id === colorId);
            if (producto) {
                if (producto.cantidad + nuevoProducto.cantidad > stock) {
                    alert('La cantidad supera el stock disponible.');
                    return;
                }
                producto.cantidad += nuevoProducto.cantidad;
                producto.subtotal += nuevoProducto.subtotal;
                producto.ganancias += nuevoProducto.ganancias;
            } else {
                productos.push(nuevoProducto);
            }
            totalInput.value = (parseFloat(totalInput.value) + nuevoProducto.subtotal).toFixed(2);
            total_gananciasInput.value = (parseFloat(total_gananciasInput.value) + nuevoProducto.ganancias).toFixed(2);
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
                fila.insertCell(5).textContent = producto.ganancias;
                const celdaAcciones = fila.insertCell(6);
                celdaAcciones.innerHTML = `<button class="btn btn-danger" onclick="eliminarProducto(${index})">Eliminar</button>`;
            });
        }

        function eliminarProducto(index) {
            const total = document.getElementById('total');
            total.value = parseFloat(total.value) - productos[index].subtotal;
            const total_ganancias = document.getElementById('total_ganancias');
            total_ganancias.value = parseFloat(total_ganancias.value) - productos[index].ganancias;
            productos.splice(index, 1);
            actualizarTablaProductos();
        }

        document.getElementById('formVenta').addEventListener('submit', function(event) {
            event.preventDefault();
            const productosInput = document.getElementById('productos');
            productosInput.value = JSON.stringify(productos);
            this.submit();
        });

        document.getElementById('sucursal_id').addEventListener('change', function() {
            const sucursalId = this.value;
            const productoId = document.getElementById('producto_id').value;
            const colorId = document.getElementById('color_id').value;
            obtenerStock(sucursalId, productoId, colorId);
        });

        document.getElementById('producto_id').addEventListener('change', function() {
            const productoId = this.value;
            obtenerColoresPorProducto(productoId);
        });

        function obtenerColoresPorProducto(productoId) {
            fetch(`../controlador/ventaControlador.php?action=obtenerColoresRegistrados&producto_id=${productoId}`)
                .then(response => response.json())
                .then(data => {
                    const colorSelect = document.getElementById('color_id');
                    if (data.length > 0) {
                        colorSelect.innerHTML = '';
                        data.forEach(color => {
                            const option = document.createElement('option');
                            option.value = color.id;
                            option.textContent = color.color;
                            colorSelect.appendChild(option);
                        });
                        colorSelect.disabled = false;
                    } else {
                        colorSelect.innerHTML = '<option value="">No hay colores disponibles</option>';
                        colorSelect.disabled = true;
                    }
                    const color_id = document.getElementById('color_id').value;
                    const sucursal_id = document.getElementById('sucursal_id').value;
                    obtenerStock(sucursal_id, productoId, color_id);
                });
        }

        document.getElementById('color_id').addEventListener('change', function() {
            const sucursalId = document.getElementById('sucursal_id').value;
            const productoId = document.getElementById('producto_id').value;
            const colorId = this.value;
            obtenerStock(sucursalId, productoId, colorId);
        });

        function obtenerStock(sucursal_id, producto_id, color_id) {
            fetch(`../controlador/ventaControlador.php?action=obtenerStock`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        sucursal_id: sucursal_id,
                        producto_id: producto_id,
                        color_id: color_id
                    })
                })
                .then(response => response.json())
                .then(data => {
                    const stockInput = document.getElementById('stock');
                    const costoInput = document.getElementById('costo');
                    const categoriaInput = document.getElementById('categoria_id');
                    stockInput.value = data.stock ? data.stock : 0;
                    costoInput.value = data.costo ? data.costo : 0;
                    categoriaInput.value = data.categoria_id ? data.categoria_id : 0;
                })
                .catch(error => console.error('Error:', error));
        }

        const producto_id = document.getElementById('producto_id').value;
        obtenerColoresPorProducto(producto_id);
    </script>
</body>

</html>