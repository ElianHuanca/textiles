<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css" rel="stylesheet">
    <title>Lista De Colores</title>
    <link rel="stylesheet" href="../vista/css/tablestyle.css">
</head>

<body data-bs-theme="dark" style="color: #FFFFFF;">
    <?php if (isset($_GET['successfull'])): ?>
        <div id="message" class="alert alert-success" role="alert" style="margin-bottom: 0;">
            Realizado Correctamente
        </div>
    <?php elseif (isset($_GET['error'])): ?>
        <div id="message" class="alert alert-danger" role="alert" style="margin-bottom: 0;">
            Error al realizar la operación
        </div>
    <?php endif; ?>

    <?php
    include '../vista/componentes/navbar.php';
    ?>

    <div class="d-flex" id="wrapper">
        <div class="w-100 p-4">
            <?php include '../vista/componentes/header.php'; ?>
            <h4>Lista De Colores</h4>
            <div class="float-end d-flex gap-2 align-items-center">
                <a href="../controlador/colorControlador.php?action=crear" class="btn btn-primary">Registrar Color</a>
            </div>
            <br>
            <br>
            <table class="table table-striped w-100" id="miTabla">
                <thead class="thead-light">
                    <tr>
                        <th>id</th>
                        <th>Color</th>
                        <th>Código</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

    <script src="../vista/js/datatableconfig.js"></script>
    <script>
        $(document).ready(function() {
            const urlColores = "../controlador/colorControlador.php?action=colors";
            const columnsColores = [{
                    data: "id"
                },
                {
                    data: "color"
                },
                {
                    data: "codigo"
                },
                {
                    data: "acciones",
                    orderable: false,
                    searchable: false
                }
            ];
            $('#miTabla').DataTable(getBaseDataTableConfig(urlColores, columnsColores));
        });
    </script>
</body>

</html>