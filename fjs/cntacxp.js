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
            "<div class='text-center'><button class='btn btn-sm btn-primary  btnEditar'><i class='fas fa-edit'></i></button>\
            <button class='btn btn-sm bg-orange btnPdf' data-toggle='tooltip' data-placement='top' title='Imprimir'><i class='text-white fas fa-file-pdf'></i></button>\
              <button class='btn btn-sm btn-danger btnBorrar'><i class='fas fa-trash-alt'></i></button></div>",
        },
        { className: 'hide_column', targets: [6] },
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
      window.location.href = "cxp.php";
     
    })
  
    
    $(document).on('click', '.btnEditar', function () {
      fila = $(this).closest('tr')
      folio = parseInt(fila.find('td:eq(0)').text())
      foliotmp= parseInt(fila.find('td:eq(6)').text())

      window.location.href = "cxp.php?folio=" + foliotmp;
   
    })
  
    //botón BORRAR
    $(document).on('click', '.btnBorrar', function () {
      fila = $(this)
  
      id = parseInt($(this).closest('tr').find('td:eq(0)').text())
      opcion = 3 //borrar
  
      //agregar codigo de sweatalert2
      var respuesta = confirm('¿Está seguro de eliminar el registro: ' + id + '?')
  
      if (respuesta) {
        $.ajax({
          url: 'bd/detallecxp.php',
          type: 'POST',
          dataType: 'json',
          data: { id: id, opcion: opcion },
  
          success: function (data) {
            console.log(fila)
  
            tablaVis.row(fila.parents('tr')).remove().draw()
          },
        })
      }
    })
  
    $('#formDatos').submit(function (e) {
      e.preventDefault()
  
      razon = $('#razon').val()
  
      rfc = $('#rfc').val()
      direccion = $('#dir').val()
  
      if (razon.length == 0 || rfc.length == 0) {
        Swal.fire({
          title: 'Datos Faltantes',
          text: 'Debe ingresar todos los datos del Prospecto',
          icon: 'warning',
        })
        return false
      } else {
        $.ajax({
          url: 'bd/crudempresa.php',
          type: 'POST',
          dataType: 'json',
          data: {
            razon: razon,
            rfc: rfc,
            direccion: direccion,
            id: id,
            opcion: opcion,
          },
          success: function (data) {
            id = data[0].id_emp
            razon = data[0].razon_emp
  
            rfc = data[0].rfc_emp
            dir = data[0].dir_emp
            tel = data[0].telefono
  
            if (opcion == 1) {
              tablaVis.row.add([id, rfc, razon, dir]).draw()
            } else {
              tablaVis.row(fila).data([id, rfc, razon, dir]).draw()
            }
          },
        })
        $('#modalCRUD').modal('hide')
      }
    })
  
    $(document).on("click", ".btnPdf", function() {
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
  