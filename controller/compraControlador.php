<?php
require_once('../connection/mysqlConnection.php');
require_once('../model/compraModelo.php');
require_once('../model/sucursalModelo.php');
require_once('../model/productoModelo.php');
require_once('../model/colorModelo.php');
require_once('../model/tipogastoModelo.php');

class CompraControlador
{
    private $compraModelo;
    private $sucursalModelo;
    private $productoModelo;
    private $colorModelo;
    private $tipoGastoModelo;

    public function __construct()
    {
        $db = Conexion::connect();
        $this->compraModelo = new CompraModelo($db);
        $this->sucursalModelo = new SucursalModelo($db);
        $this->productoModelo = new ProductoModelo($db);
        $this->colorModelo = new ColorModelo($db);
        $this->tipoGastoModelo = new TipoGastoModelo($db);
    }

    public function obtenerCompras()
    {
        include '../view/compras/index.php';
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
        $tickets = $this->compraModelo->obtenerComprasDatatable($search, $orderColumn, $orderDir, $start, $length);
        $recordsTotal = $this->compraModelo->obtenerCantidadCompras($search);
        foreach ($tickets as $row) {
            $data[] = [
                "id" => $row["id"],
                "fecha" => $row["fecha"] ?? '',
                "total" => $row["total"] ?? '',
                "total_gastos" => $row["total_gastos"] ?? '',
                "sucursal" => $row["sucursal"] ?? '',
                "acciones" => '
                                <a href="../controller/compraControlador.php?action=editar&id=' . $row['id'] . '" style="text-decoration: none;">
                                    <img src="../assets/editar.png" width="25px">
                                </a>
                                <a href="../controller/compraControlador.php?action=eliminar&id=' . $row['id'] . '" style="text-decoration: none;"                        
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
        include '../view/compras/crear.php';
    }
}

$controller = new CompraControlador();
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
