<?php
require_once('../modelo/productoModelo.php');
require_once('../modelo/categoriaModelo.php');
                    
                    
class ProductoControlador
{
    private $productoModelo;
    private $categoriaModelo;
    private $colorModelo;
    public function __construct()
    {        
        $this->productoModelo = new ProductoModelo();
        $this->categoriaModelo = new CategoriaModelo();
        $this->colorModelo = new ColorModelo();
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
                                <a href="../controlador/productoControlador.php?action=agregar&id=' . $producto['id'] . '"
                                    <button class="btn btn-primary">
                                        <i class="bi bi-plus" title="Agregar color"></i>
                                    </button>
                                </a>
                                <a href="../controlador/productoControlador.php?action=editar&id=' . $producto['id'] . '"
                                    <button class="btn btn-secondary">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                </a>
                                <a href="../controlador/productoControlador.php?action=eliminar&id=' . $producto['id'] . '"
                                    onclick="return confirm(\'¿Estás seguro de que deseas eliminar este producto?\');">
                                    <button class="btn btn-danger">
                                        <i class="bi bi-trash"></i>
                                    </button>
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

    public function agregar()
    {
        $productoId = $_GET['id'] ?? null;
        if ($productoId) {
            $producto = $this->productoModelo->obtenerProducto($productoId);
            $colores = $this->colorModelo->obtenerColoresDisponibles($productoId);
            $coloresRegistrados = $this->colorModelo->obtenerColoresRegistrados($productoId);
            include '../vista/productos/agregar.php';
        } else {
            header('Location: ../controlador/productoControlador.php?action=obtenerProductos');
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
