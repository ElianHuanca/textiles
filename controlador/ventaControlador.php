<?php
require_once('../modelo/ventaModelo.php');
require_once('../modelo/sucursalModelo.php');
require_once('../modelo/productoModelo.php');
require_once('../modelo/colorModelo.php');
require_once('../modelo/tipogastoModelo.php');

class VentaControlador
{
    private $ventaModelo;
    private $sucursalModelo;
    private $productoModelo;
    private $colorModelo;
    private $tipoGastoModelo;

    public function __construct()
    {
        $this->ventaModelo = new VentaModelo();
        $this->sucursalModelo = new SucursalModelo();
        $this->productoModelo = new ProductoModelo();
        $this->colorModelo = new ColorModelo();
        $this->tipoGastoModelo = new TipoGastoModelo();
    }

    public function obtenerVentas()
    {
        include '../vista/ventas/index.php';
    }

    public function ventas()
    {
        header('Content-Type: application/json');
        $search = $_POST["search"]["value"] ?? '';
        $orderColumnIndex = $_POST["order"][0]["column"] ?? 0;
        $orderDir = $_POST["order"][0]["dir"] ?? 'DESC';
        $start = $_POST["start"] ?? 0;
        $length = $_POST["length"] ?? 10;
        $data = [];
        $columnMap = ["id", "fecha", "total", "descuento", "total_ganancias", "sucursal"];
        $orderColumn = $columnMap[$orderColumnIndex] ?? "id";
        $tickets = $this->ventaModelo->obtenerVentasDatatable($search, $orderColumn, $orderDir, $start, $length);
        $recordsTotal = $this->ventaModelo->obtenerCantidadVentas($search);
        foreach ($tickets as $row) {
            $data[] = [
                "id" => $row["id"],
                "fecha" => $row["fecha"] ?? '',
                "total" => $row["total"] ?? '',
                "descuento" => $row["descuento"] ?? '',
                "total_ganancias" => $row["total_ganancias"] ?? '',
                "sucursal" => $row["sucursal"] ?? '',
                "acciones" => '
                                <a href="../controller/ventaControlador.php?action=editar&id=' . $row['id'] . '" style="text-decoration: none;">
                                    <img src="../assets/editar.png" width="25px">
                                </a>
                                <a href="../controller/ventaControlador.php?action=eliminar&id=' . $row['id'] . '" style="text-decoration: none;"                        
                                    onclick="return confirm(\'¿Estás seguro de que deseas eliminar esta venta?\');">
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
        include '../vista/ventas/crear.php';
    }

    public function crearVenta(){
        $venta = $this->ventaModelo->obtenerVentaHoy($_POST['sucursal_id']);
        if (!$venta) {
            $data =  [
                'sucursal_id' => $_POST['sucursal_id'],
                'total' => $_POST['total'],
                'descuento' => $_POST['descuento'],
                'total_ganancias' => $_POST['total_ganancias']                
            ];
            $this->ventaModelo->crearVenta($data);
        }else{
            $data =  [                                
                'total' => $venta['total'] + $_POST['total'],
                'descuento' => $venta['descuento'] + $_POST['descuento'],
                'total_ganancias' => $venta['total_ganancias'] + $_POST['total_ganancias']
            ];
            $this->ventaModelo->actualizarVenta($venta['id'],$data);
        }
        $productos = $_POST['productos'];
        foreach ($productos as $producto) {
            $productoVenta = $this->productoModelo->obtenerProductoPorVenta($venta['id'],$producto['producto_id'], $producto['color_id'],$producto['precio']);
            if($productoVenta){
                $data = [
                    'cantidad' => $productoVenta['cantidad'] + $producto['cantidad'],
                    'subtotal' => $productoVenta['subtotal'] + $producto['subtotal'],
                    'ganancias' => $productoVenta['ganancias'] + $producto['ganancias']
                ];
                $this->ventaModelo->actualizarProductoVenta($venta['id'],$producto['producto_id'], $producto['color_id'],$producto['precio'], $data);
            }else{
                $data = [
                    'venta_id' => $venta['id'],
                    'producto_id' => $producto['producto_id'],
                    'color_id' => $producto['color_id'],
                    'cantidad' => $producto['cantidad'],
                    'precio' => $producto['precio'],
                    'subtotal' => $producto['subtotal'],
                    'ganancias' => $producto['ganancias']
                ];
                $this->ventaModelo->crearProductoVenta($data);
            }
        }
    }
    public function obtenerColoresRegistrados()
    {
        header('Content-Type: application/json');        
        $producto_id = isset($_GET['producto_id']) ? intval($_GET['producto_id']) : null;
        $colores = $this->colorModelo->obtenerColoresRegistrados($producto_id);
        echo json_encode($colores);
    }

    public function obtenerStock()
    {
        header('Content-Type: application/json');
        $input = json_decode(file_get_contents('php://input'), true);
        $sucursal_id = $input['sucursal_id'] ?? null;
        $producto_id = $input['producto_id'] ?? null;
        $color_id = $input['color_id'] ?? null;

        $producto = $this->productoModelo->obtenerStock($sucursal_id, $producto_id, $color_id);
        echo json_encode($producto);
    }
}

$controller = new VentaControlador();
if (isset($_GET['action'])) {
    $action = $_GET['action'];
    if (method_exists($controller, $action)) {
        $controller->$action();
    } else {
        echo "Método no encontrado";
    }
} else {
    echo "No se especificó acción.";
}
