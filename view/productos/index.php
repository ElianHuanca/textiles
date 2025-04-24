<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css" rel="stylesheet">
    <title>Lista De Productos</title>
</head>

<body data-bs-theme="dark">
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
            <h4>Lista De Productos</h4>
            <div class="float-end d-flex gap-2 align-items-center">
                <a href="../controller/productoControlador.php?action=crear" class="btn bt-primary">Registrar Producto</a>
                <!-- <form method="post" action="../controlador/ticketControlador.php?action=crear">
                    <button type="submit" class="btn btn-primary">Registrar Ticket</button>
                </form> -->
            </div>
            <br>
            <br>
            <table class="table table-striped w-100" id="myTabla">
                <thead class="thead-light">
                    <tr>
                        <th>id</th>
                        <th>Producto</th>
                        <th>Costo Promedio Ponderado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#myTabla').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": {
                    url: "../controller/productoControlador.php?action=productos",
                    type: "POST",
                    dataType: "json",
                },
                "columns": [{
                        "data": "id"
                    },
                    {
                        "data": "producto"
                    },
                    {
                        "data": "costo"
                    },
                    {
                        "data": "acciones",
                        "orderable": false,
                        "searchable": false
                    }
                ],
                "paging": true,
                "searching": true,
                "info": true,
                "lengthChange": true,
                "lengthMenu": [5, 10, 25, 50, 100],
                "pageLength": 10,
                "language": {
                    "search": "Buscador:",
                    "paginate": {
                        "first": "Primero",
                        "last": "Último",
                        "next": "Siguiente",
                        "previous": "Anterior"
                    },
                    "zeroRecords": "No se encontraron resultados",
                    "emptyTable": "No hay datos disponibles en la tabla",
                    "info": "Mostrando _START_ a _END_ de _TOTAL_ registros",
                    "infoEmpty": "Mostrando 0 a 0 de 0 registros",
                    "lengthMenu": "Mostrar _MENU_ registros por página",
                    "infoFiltered": "(filtrado de _MAX_ registros en total)"
                }
            });
        });
    </script>
</body>

</html>