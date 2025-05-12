<?php
require_once('../connection/mysqlConnection.php');
require_once('../model/ventaModelo.php');
require_once('../model/sucursalModelo.php');
require_once('../model/productoModelo.php');
require_once('../model/colorModelo.php');
require_once('../model/tipogastoModelo.php');

class VentaControlador
{
    private $ventaModelo;
    private $sucursalModelo;
    private $productoModelo;
    private $colorModelo;
    private $tipoGastoModelo;

    public function __construct()
    {
        $db = Conexion::connect();
        $this->ventaModelo = new VentaModelo($db);
        $this->sucursalModelo = new SucursalModelo($db);
        $this->productoModelo = new ProductoModelo($db);
        $this->colorModelo = new ColorModelo($db);
        $this->tipoGastoModelo = new TipoGastoModelo($db);
    }

    public function obtenerVentas()
    {
        include '../view/ventas/index.php';
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
        $columnMap = ["id", "fecha", "total", "descuento","total_ganancias", "sucursal"];
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