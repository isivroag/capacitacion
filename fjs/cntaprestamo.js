$(document).ready(function () {
  var id, opcion
  opcion = 4
  var fila

  tablaVis = $('#tablaV').DataTable({

    columnDefs: [
      {
        targets: -1,
        data: null,
        defaultContent:
          "<div class='text-center'><button class='btn btn-sm btn-primary  btnEditar'><i class='fa-solid fa-magnifying-glass'></i></button>\
            <button class='btn btn-sm bg-orange btnPdf' data-toggle='tooltip' data-placement='top' title='Imprimir'><i class='text-white fas fa-file-pdf'></i></button>\
              <button class='btn btn-sm btn-danger btnBorrar'><i class='fa-solid fa-ban'></i></button></div>",
      },
      { className: 'hide_column', targets: 5 }
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
    window.location.href = "prestamo.php";

  })


  $(document).on('click', '.btnEditar', function () {
    fila = $(this).closest('tr')
    folio = parseInt(fila.find('td:eq(0)').text())


    window.location.href = "prestamo.php?folio=" + folio;

  })

  //botón BORRAR
  $(document).on('click', '.btnBorrar', function () {
    fila = $(this)

    folio = parseInt($(this).closest('tr').find('td:eq(0)').text())
    estado = $(this).closest('tr').find('td:eq(6)').text()
    opcion = 3 //borrar
  
    if (estado == 'ACTIVO') {
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
              url: 'bd/crudprestamo.php',
              type: 'POST',
              dataType: 'json',
              data: { folio: folio, opcion: opcion },
              success: function (data) {
                tablaVis.row(fila.parents('tr')).remove().draw()
              },
            })
          } else if (isConfirm.dismiss === swal.DismissReason.cancel) {
          }
        })
    }else{
      swal.fire({
        title: 'Error',
        text: 'No es posible cancelar un prestamo que ya ha sido finalizado',
        icon: 'warning',
        confirmButtonText: 'Aceptar',

      })
    }



  })



  $(document).on("click", ".btnPdf", function () {
    fila = $(this).closest('tr')
    folio = parseInt(fila.find('td:eq(0)').text())
    var ancho = 1000;
    var alto = 800;
    var x = parseInt((window.screen.width / 2) - (ancho / 2));
    var y = parseInt((window.screen.height / 2) - (alto / 2));

    url = "formatos/pdfvale.php?folio=" + folio;

    window.open(url, "Vale", "left=" + x + ",top=" + y + ",height=" + alto + ",width=" + ancho + "scrollbar=si,location=no,resizable=si,menubar=no");

  });
})
