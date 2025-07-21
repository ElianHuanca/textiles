<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css" rel="stylesheet">
    <title>Lista De Ventas</title>
    <link rel="stylesheet" href="../view/css/tablestyle.css">
</head>

<body data-bs-theme="dark" style="color: #FFFFFF;">
    <?php if (isset($_GET['successfull'])): ?>
        <div id="message" class="alert alert-success" role="alert" style="margin-bottom: 0;">
            Realizado Correctamente
        </div>
    <?php endif; ?>

    <?php
    include '../view/components/navbar.php';
    ?>

    <div class="d-flex" id="wrapper">
        <div class="w-100 p-4">
            <?php include '../view/components/header.php'; ?>
            <h4>Lista De Ventas</h4>
            <div class="float-end d-flex gap-2 align-items-center">
                <a href="../controller/ventaControlador.php?action=crear" class="btn btn-primary">Registrar Venta</a>
            </div>
            <br>
            <br>
            <table class="table table-striped w-100" id="miTabla">
                <thead class="thead-light">
                    <tr>
                        <th>id</th>
                        <th>Fecha</th>
                        <th>Total</th>
                        <th>Descuento</th>
                        <th>Ganancias</th>
                        <th>Sucursal</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    
    <script src="../view/js/datatableconfig.js"></script>
    <script>
        $(document).ready(function() {
            const url = "../controller/ventaControlador.php?action=ventas";
            const columns = [{
                    data: "id"
                },
                {
                    data: "fecha"
                },
                {
                    data: "total"
                },
                {
                    data: "descuento"
                },
                {
                    data: "total_ganancias"
                },
                {
                    data: "sucursal"
                },
                {
                    data: "acciones",
                    orderable: false,
                    searchable: false
                }
            ];
            $('#miTabla').DataTable(getBaseDataTableConfig(url,columns));
        });
    </script>
</body>

</html>