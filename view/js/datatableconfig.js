function getBaseDataTableConfig(url, columns) {
    return {
        processing: true,
        serverSide: true,
        ajax: {
            url: url,
            type: "POST",
            dataType: "json",
        },
        columns: columns,
        paging: true,
        searching: true,
        info: true,
        lengthChange: true,
        lengthMenu: [5, 10, 25, 50, 100],
        pageLength: 10,
        language: {
            search: "Buscador:",
            paginate: {
                first: "Primero",
                last: "Último",
                next: "Siguiente",
                previous: "Anterior"
            },
            zeroRecords: "No se encontraron resultados",
            emptyTable: "No hay datos disponibles en la tabla",
            info: "Mostrando _START_ a _END_ de _TOTAL_ registros",
            infoEmpty: "Mostrando 0 a 0 de 0 registros",
            lengthMenu: "Mostrar _MENU_ registros por página",
            infoFiltered: "(filtrado de _MAX_ registros en total)"
        }
    };
}