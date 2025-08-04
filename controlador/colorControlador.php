<?php
require_once('../modelo/colorModelo.php');
require_once('../modelo/categoriaModelo.php');
                    
                    
class ColorControlador
{    
    private $categoriaModelo;
    private $colorModelo;
    
    public function __construct()
    {        
        $this->colorModelo = new ColorModelo();
        $this->categoriaModelo = new CategoriaModelo();
        $this->colorModelo = new ColorModelo();
    }

    public function obtenerColors()
    {
        include '../vista/colors/index.php';
    }

    public function colors()
    {
        header('Content-Type: application/json');
        $search = $_POST["search"]["value"] ?? '';
        $orderColumnIndex = $_POST["order"][0]["column"] ?? 0;
        $orderDir = $_POST["order"][0]["dir"] ?? 'DESC';
        $start = $_POST["start"] ?? 0;
        $length = $_POST["length"] ?? 10;
        $data = [];
        $columnMap = ["id", "color", "costo", "categoria"];
        $orderColumn = $columnMap[$orderColumnIndex] ?? "id";
        $colors = $this->colorModelo->obtenerColorsDatatable($search, $orderColumn, $orderDir, $start, $length);
        $recordsTotal = $this->colorModelo->obtenerCantidadColors($search);
        foreach ($colors as $color) {
            $data[] = [
                "id" => $color["id"],
                "color" => $color["color"] ?? '',
                "costo" => $color["costo"] ?? '',
                "categoria" => $color["categoria"] ?? '',
                "acciones" => '
                                <a href="../controlador/colorControlador.php?action=agregar&id=' . $color['id'] . '"
                                    <button class="btn btn-primary">
                                        <i class="bi bi-plus" title="Agregar color"></i>
                                    </button>
                                </a>
                                <a href="../controlador/colorControlador.php?action=editar&id=' . $color['id'] . '"
                                    <button class="btn btn-secondary">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                </a>
                                <a href="../controlador/colorControlador.php?action=eliminar&id=' . $color['id'] . '"
                                    onclick="return confirm(\'¿Estás seguro de que deseas eliminar este color?\');">
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
        include '../vista/colors/crear.php';
    }

    public function crearColor()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'color' => $_POST['color'],
                'categoria_id' => $_POST['categoria_id'],
                'costo' => 0
            ];
            $resultado = $this->colorModelo->crearColor($data);
            if ($resultado) {
                header('Location: ../controlador/colorControlador.php?action=obtenerColors&success=1');
            } else {
                header('Location: ../controlador/colorControlador.php?action=obtenerColors&error=1');
            }
        }
    }
}

$controller = new ColorControlador();
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
