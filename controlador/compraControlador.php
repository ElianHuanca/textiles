<?php
require_once('../modelo/compraModelo.php');
require_once('../modelo/sucursalModelo.php');
require_once('../modelo/productoModelo.php');
require_once('../modelo/colorModelo.php');
require_once('../modelo/tipogastoModelo.php');

class CompraControlador
{
    private $compraModelo;
    private $sucursalModelo;
    private $productoModelo;
    private $colorModelo;
    private $tipoGastoModelo;

    public function __construct()
    {
        $this->compraModelo = new CompraModelo();
        $this->sucursalModelo = new SucursalModelo();
        $this->productoModelo = new ProductoModelo();
        $this->colorModelo = new ColorModelo();
        $this->tipoGastoModelo = new TipoGastoModelo();
    }

    public function obtenerCompras()
    {
        include '../vista/compras/index.php';
    }

    public function compras()
    {
        header('Content-Type: application/json');
        $search = $_POST["search"]["value"] ?? '';
        $orderColumnIndex = $_POST["order"][0]["column"] ?? 0;
        $orderDir = $_POST["order"][0]["dir"] ?? 'DESC';
        $start = $_POST["start"] ?? 0;
        $length = $_POST["length"] ?? 10;
        $data = [];
        $columnMap = ["id", "fecha", "total", "total_gastos", "sucursal"];
        $orderColumn = $columnMap[$orderColumnIndex] ?? "id";
        $compras = $this->compraModelo->obtenerComprasDatatable($search, $orderColumn, $orderDir, $start, $length);
        $recordsTotal = $this->compraModelo->obtenerCantidadCompras($search);
        foreach ($compras as $row) {
            $data[] = [
                "id" => $row["id"],
                "fecha" => $row["fecha"] ?? '',
                "total" => $row["total"] ?? '',
                "total_gastos" => $row["total_gastos"] ?? '',
                "sucursal" => $row["sucursal"] ?? '',
                "acciones" => '
                                <a href="../controlador/compraControlador.php?action=editar&id=' . $row['id'] . '" style="text-decoration: none;">
                                    <img src="../assets/editar.png" width="25px">
                                </a>
                                <a href="../controlador/compraControlador.php?action=eliminar&id=' . $row['id'] . '" style="text-decoration: none;"                        
                                    onclick="return confirm(\'¿Estás seguro de que deseas eliminar esta compra?\');">
                                    <img src="../assets/borrar.png" width="25px">
                                </a>'
            ];
        }

        $salida = [
            "draw" => intval($_POST["draw"] ?? 1),
            "recordsTotal" => $recordsTotal,
            "recordsFiltered" => $recordsTotal,
            "data" => $data
        ];

        echo json_encode($salida);
    }

    public function crear()
    {
        $sucursales = $this->sucursalModelo->obtenerSucursales();
        $productos = $this->productoModelo->obtenerProductos();
        $colores = $this->colorModelo->obtenerColores();
        $tipos_gastos = $this->tipoGastoModelo->obtenerTiposGastos();
        include '../vista/compras/crear.php';
    }

    public function crearCompra()
    {
        $dataCompra = [
            'fecha' => date('Y-m-d'),
            'total' => $_POST['total'],
            'total_gastos' => $_POST['total_gastos'],
            'sucursal_id' => $_POST['sucursal_id']
        ];
        $dataCompra = $this->compraModelo->crear($dataCompra, 'compras');
        $gastos = json_decode($_POST['gastos'], true);
        if ($gastos) {
            foreach ($gastos as $gasto) {
                $dataGasto = [
                    'compra_id' => $dataCompra['id'],
                    'tipo_gasto_id' => $gasto['tipo_gasto_id'],
                    'gasto' => $gasto['gasto']
                ];
                $this->compraModelo->crear($dataGasto, 'gastos');
            }
        }
        $productos = json_decode($_POST['productos'], true);
        if ($productos) {
            foreach ($productos as $producto) {
                $dataProducto = [
                    'compra_id' => $dataCompra['id'],
                    'producto_id' => $producto['producto_id'],
                    'color_id' => $producto['color_id'],
                    'cantidad' => $producto['cantidad'],
                    'precio' => $producto['precio'],
                    'subtotal' => $producto['subtotal']                    
                ];
                $dataProducto = $this->compraModelo->crear($dataProducto, 'compra_producto');            
                $dataProducto['gasto'] = $producto['subtotal'] / $dataCompra['total'] * $dataCompra['total_gastos'];
                $this->costoPromedioPonderado($dataProducto);
                $this->productoModelo->actualizarStock($dataProducto['producto_id'], $dataProducto['color_id'], $_POST['sucursal_id'], $producto['cantidad']);
            }
        }
        header('Location: ../controlador/compraControlador.php?action=obtenerCompras');
    }

    public function costoPromedioPonderado($dataProducto)
    {
        $stock = $this->sucursalModelo->obtenerStock($dataProducto['producto_id']);
        $costo = $this->productoModelo->obtenerCosto($dataProducto['producto_id']);
        $costoInventario = $stock * $costo;
        $costoCompra = $dataProducto['subtotal'] + $dataProducto['gasto'];
        $costoTotal = $costoInventario + $costoCompra;
        $stockTotal = $stock + $dataProducto['cantidad'];
        $costoUnitarioPromedio = $costoTotal / $stockTotal;
        $this->productoModelo->actualizarCosto($dataProducto['producto_id'], $costoUnitarioPromedio);
    }

    public function revertirCostoPromedioPonderado($dataProducto)
    {
        $stock = $this->sucursalModelo->obtenerStock($dataProducto['producto_id']);
        $costo = $this->productoModelo->obtenerCosto($dataProducto['producto_id']);

        $costoInventario = $stock * $costo;
        $costoCompra = $dataProducto['subtotal'] + $dataProducto['gasto'];
        $costoTotal = $costoInventario - $costoCompra;
        $stockTotal = $stock - $dataProducto['cantidad'];
        if ($stockTotal > 0) {
            $costoUnitarioPromedio = $costoTotal / $stockTotal;
        } else {        
            $costoUnitarioPromedio = 0;
        }
        $this->productoModelo->actualizarCosto($dataProducto['producto_id'], $costoUnitarioPromedio);
    }


    public function eliminar()
    {
        $id = $_GET['id'];
        $compra = $this->compraModelo->obtenerCompra($id);
        $productos = $this->compraModelo->obtenerCompraProducto($id);
        if ($productos) {
            foreach ($productos as $producto) {
                $dataProducto = [
                    'producto_id' => $producto['producto_id'],
                    'color_id' => $producto['color_id'],
                    'cantidad' => $producto['cantidad'],
                    'subtotal' => $producto['subtotal'],
                    'gasto' => $producto['subtotal'] / $compra['total'] * $compra['total_gastos']
                ];
                $this->revertirCostoPromedioPonderado($dataProducto);   
                $this->productoModelo->actualizarStock($producto['producto_id'], $producto['color_id'], $compra['sucursal_id'], -$producto['cantidad']);                             
            }            
        }
        $this->compraModelo->eliminar($id);
        header('Location: ../controlador/compraControlador.php?action=obtenerCompras');
    }
}

$controlador = new CompraControlador();
if (isset($_GET['action'])) {
    $action = $_GET['action'];

    if (method_exists($controlador, $action)) {
        $controlador->$action();
    } else {
        echo "Método no encontrado";
    }
} else {
    echo "No se especificó acción.";
}
