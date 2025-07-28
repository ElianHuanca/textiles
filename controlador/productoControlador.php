<?php
require_once('../modelo/productoModelo.php');
require_once('../modelo/categoriaModelo.php');
                    
                    
class ProductoControlador
{
    private $productoModelo;
    private $categoriaModelo;

    public function __construct()
    {        
        $this->productoModelo = new ProductoModelo();
        $this->categoriaModelo = new CategoriaModelo();
    }

    public function obtenerProductos()
    {
        include '../vista/productos/index.php';
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
        $columnMap = ["id", "producto", "costo", "categoria"];
        $orderColumn = $columnMap[$orderColumnIndex] ?? "id";
        $productos = $this->productoModelo->obtenerProductosDatatable($search, $orderColumn, $orderDir, $start, $length);
        $recordsTotal = $this->productoModelo->obtenerCantidadProductos($search);
        foreach ($productos as $producto) {
            $data[] = [
                "id" => $producto["id"],
                "producto" => $producto["producto"] ?? '',
                "costo" => $producto["costo"] ?? '',
                "categoria" => $producto["categoria"] ?? '',
                "acciones" => '
                                <a href="../controlador/productoControlador.php?action=editar&id=' . $producto['id'] . '" style="text-decoration: none;">
                                    <img src="../assets/editar.png" width="25px">
                                </a>
                                <a href="../controlador/productoControlador.php?action=eliminar&id=' . $producto['id'] . '" style="text-decoration: none;"                        
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

    public function crear()
    {
        $categorias = $this->categoriaModelo->obtenerCategorias();
        include '../vista/productos/crear.php';
    }

    public function crearProducto()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'producto' => $_POST['producto'],
                'categoria_id' => $_POST['categoria_id'],
                'costo' => 0
            ];
            $resultado = $this->productoModelo->crearProducto($data);
            if ($resultado) {
                header('Location: ../controlador/productoControlador.php?action=obtenerProductos&success=1');
            } else {
                header('Location: ../controlador/productoControlador.php?action=obtenerProductos&error=1');
            }
        }
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
