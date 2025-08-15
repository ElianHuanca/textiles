<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Color</title>
    <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">
</head>

<body data-bs-theme="dark" style="color: #FFFFFF;">
    <div class="container mt-5">
        <h2>Registrar Color</h2>
        <form action="../controlador/colorControlador.php?action=crearColor" method="POST">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="color" class="form-label">Color</label>
                    <input type="text" class="form-control" id="color" name="color" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="codigo" class="form-label">Código</label>
                    <input type="text" class="form-control" id="codigo" name="codigo" required>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Registrar</button>
        </form>
    </div>
</body>

</html>