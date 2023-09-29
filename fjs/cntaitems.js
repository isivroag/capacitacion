$(document).ready(function () {
    var id, opcion
    opcion = 4
    $('[data-toggle="tooltip"]').tooltip()


    tabla1 = $('#tabla1').DataTable({

        dom:
            "<'row justify-content-center'<'col-sm-12 col-md-4 form-group'l><'col-sm-12 col-md-4 form-group'B><'col-sm-12 col-md-4 form-group'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",

        buttons: [
            {
                extend: 'excelHtml5',
                text: "<i class='fas fa-file-excel'> Excel</i>",
                titleAttr: 'Exportar a Excel',
                title: 'Listado de Productos y Servicios',
                className: 'btn bg-success ',
                exportOptions: { columns: [0, 1, 2, 3, 4, 5, 6, 7] },
            },
            {
                extend: 'pdfHtml5',
                text: "<i class='far fa-file-pdf'> PDF</i>",
                titleAttr: 'Exportar a PDF',
                title: 'Listado de Productos y Servicios',
                className: 'btn bg-danger',
                exportOptions: { columns: [0, 1, 2, 3, 4, 5, 6, 7] },
            },
        ],

        columnDefs: [
            {
                targets: -1,
                data: null,
                defaultContent:
                    "<div class='text-center'><button class='btn btn-sm btn-primary btnEditar' data-toggle='tooltip' data-placement='top' title='Editar'><i class='fas fa-edit'></i></button>\
                     <button class='btn btn-sm btn-danger btnBorrar' data-toggle='tooltip' data-placement='top' title='Eliminar'><i class='fas fa-trash-alt'></i></button></div>",
            },
            { className: 'hide_column', targets: [3] },
        ],

        //Para cambiar el lenguaje a español
        language: {
            lengthMenu: 'Mostrar _MENU_ registros',
            zeroRecords: 'No se encontraron resultados',
            info:
                'Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros',
            infoEmpty: 'Mostrando registros del 0 al 0 de un total de 0 registros',
            infoFiltered: '(filtrado de un total de _MAX_ registros)',
            sSearch: 'Buscar:',
            oPaginate: {
                sFirst: 'Primero',
                sLast: 'Último',
                sNext: 'Siguiente',
                sPrevious: 'Anterior',
            },
            sProcessing: 'Procesando...',
        },
    })

    $('#btnNuevo').click(function () {

        $('#formDatos').trigger('reset')
        $('.modal-title').text('NUEVO ITEM')
        $('#modalCRUD').modal('show')
        id = null
        opcion = 1
    })

    $(document).on('click', '.btnEditar', function () {
        fila = $(this).closest('tr')
        id = parseInt(fila.find('td:eq(0)').text())

        descripcion = fila.find('td:eq(1)').text()
        tipo = fila.find('td:eq(2)').text()
        precio = fila.find('td:eq(3)').text()
        costo = fila.find('td:eq(4)').text()
        existencia = fila.find('td:eq(5)').text()


        $('#descripcion').val(descripcion)
        $('#tipo').val(tipo)
        $('#precio').val(precio)
        $('#costo').val(costo)
        $('#existencia').val(existencia)


        opcion = 2 //editar


        $('.modal-title').text('EDITAR ITEM')
        $('#modalCRUD').modal('show')
    })


    $(document).on('click', '.btnBorrar', function () {
        fila = $(this)

        id = parseInt($(this).closest('tr').find('td:eq(0)').text())
        opcion = 3
        swal
            .fire({
                title: 'ELIMINAR',
                text: '¿Desea eliminar el registro seleccionado?',
                showCancelButton: true,
                icon: 'question',
                focusConfirm: true,
                confirmButtonText: 'Aceptar',
                cancelButtonText: 'Cancelar',
                confirmButtonColor: '#28B463',
                cancelButtonColor: '#d33',
            })
            .then(function (isConfirm) {
                if (isConfirm.value) {
                    $.ajax({
                        url: 'bd/cruditems.php',
                        type: 'POST',
                        dataType: 'json',
                        data: { id: id, opcion: opcion },
                        success: function (data) {
                            tabla1.row(fila.parents('tr')).remove().draw()
                        },
                    })
                } else if (isConfirm.dismiss === swal.DismissReason.cancel) {
                }
            })
    })



    $('#formDatos').submit(function (e) {
        e.preventDefault()
        var descripcion = $('#descripcion').val()
        var tipo = $('#tipo').val()
        var precio = $('#precio').val()
        var costo = $('#costo').val()
        var existencia = $('#existencia').val()




        if (descripcion.length == 0) {
            Swal.fire({
                title: 'Datos Faltantes',
                text: 'Debe ingresar todos los datos del Prospecto',
                icon: 'warning',
            })
            return false
        } else {
            $.ajax({
                url: 'bd/cruditems.php',
                type: 'POST',
                dataType: 'json',
                data: {
                    descripcion: descripcion,
                    tipo: tipo,
                    precio: precio,
                    costo: costo,
                    existencia: existencia,

                    id: id,
                    opcion: opcion,
                },
                success: function (data) {
                    id = data[0].id_item
                    descripcion = data[0].descripcion
                    tipo = data[0].tipo
                    precio = data[0].precio
                    costo = data[0].costo
                    existencia = data[0].existencia

                    if (opcion == 1) {
                        tabla1.row
                            .add([
                                id,
                                descripcion,
                                tipo,
                                precio,
                                costo,
                                existencia,

                            ])
                            .draw()
                    } else {
                        tabla1
                            .row(fila)
                            .data([
                                id,
                                descripcion,
                                tipo,
                                precio,
                                costo,
                                existencia,
                            ])
                            .draw()
                    }
                },
            })
            $('#modalCRUD').modal('hide')
        }
    })
})