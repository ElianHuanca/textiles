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
    }

    public function obtenerColores()
    {
        include '../vista/colores/index.php';
    }

    public function colores()
    {
        header('Content-Type: application/json');
        $search = $_POST["search"]["value"] ?? '';
        $orderColumnIndex = $_POST["order"][0]["column"] ?? 0;
        $orderDir = $_POST["order"][0]["dir"] ?? 'DESC';
        $start = $_POST["start"] ?? 0;
        $length = $_POST["length"] ?? 10;
        $data = [];
        $columnMap = ["id", "color", "codigo"];
        $orderColumn = $columnMap[$orderColumnIndex] ?? "id";
        $colores = $this->colorModelo->obtenerColoresDatatable($search, $orderColumn, $orderDir, $start, $length);
        $recordsTotal = $this->colorModelo->obtenerCantidadColores($search);
        foreach ($colores as $color) {
            $data[] = [
                "id" => $color["id"],
                "color" => $color["color"] ?? '',
                "codigo" => $color["codigo"] ?? '',
                "acciones" => '
                                <a class="btn btn-primary" href="../controlador/colorControlador.php?action=editar&id=' . $color['id'] . '">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <a href="../controlador/colorControlador.php?action=eliminar&id=' . $color['id'] . '"
                                    onclick="return confirm(\'¿Estás seguro de que deseas eliminar este color?\');" class="btn btn-danger">                                    
                                    <i class="bi bi-trash"></i>                                    
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
        include '../vista/colores/crear.php';
    }

    public function crearColor()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'color' => $_POST['color'],                
                'codigo' => $_POST['codigo'],
            ];
            $resultado = $this->colorModelo->crearColor($data);
            if ($resultado) {
                header('Location: ../controlador/colorControlador.php?action=obtenerColores&success=1');
            } else {
                header('Location: ../controlador/colorControlador.php?action=obtenerColores&error=1');
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
