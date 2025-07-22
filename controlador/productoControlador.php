<?php
require_once('../model/productoModelo.php');

class ProductoControlador
{
    private $productoModelo;

    public function __construct()
    {        
        $this->productoModelo = new ProductoModelo();
    }

    public function obtenerProductos()
    {
        include '../view/productos/index.php';
    }

    public function productos()
    {
        header('Content-Type: application/json');
        $search = $_POST["search"]["value"] ?? '';
        $orderColumnIndex = $_POST["order"][0]["column"] ?? 0;
        $orderDir = $_POST["order"][0]["dir"] ?? 'DESC';
        $start = $_POST["start"] ?? 0;
        $length = $_POST["length"] ?? 10;
        $data = [];
        $columnMap = ["id", "producto", "costo"];
        $orderColumn = $columnMap[$orderColumnIndex] ?? "id";
        $tickets = $this->productoModelo->obtenerProductosDatatable($search, $orderColumn, $orderDir, $start, $length);
        $recordsTotal = $this->productoModelo->obtenerCantidadProductos($search);
        foreach ($tickets as $row) {
            $data[] = [
                "id" => $row["id"],
                "producto" => $row["producto"] ?? '',
                "costo" => $row["costo"] ?? '',
                "acciones" => '
                                <a href="../controller/productoControlador.php?action=editar&id=' . $row['id'] . '" style="text-decoration: none;">
                                    <img src="../assets/editar.png" width="25px">
                                </a>
                                <a href="../controller/productoControlador.php?action=eliminar&id=' . $row['id'] . '" style="text-decoration: none;"                        
                                    onclick="return confirm(\'¿Estás seguro de que deseas eliminar este producto?\');">
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

$controller = new ProductoControlador();
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
