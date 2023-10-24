$(document).ready(function () {
    $('[data-toggle="tooltip"]').tooltip()
  
    var id, opcion
    var operacion = $('#opcion').val()
  
    var textopermiso = permisos()
  
    document.getElementById('cantidaditem').onblur = function () {
      this.value = parseFloat(this.value.replace(/,/g, ''))
        .toFixed(2)
        .toString()
        .replace(/\B(?=(\d{3})+(?!\d))/g, ',')
    }
    document.getElementById('precioitem').onblur = function () {
      this.value = parseFloat(this.value.replace(/,/g, ''))
        .toFixed(2)
        .toString()
        .replace(/\B(?=(\d{3})+(?!\d))/g, ',')
    }
    document.getElementById('descuentoitem').onblur = function () {
      this.value = parseFloat(this.value.replace(/,/g, ''))
        .toFixed(2)
        .toString()
        .replace(/\B(?=(\d{3})+(?!\d))/g, ',')
    }
  
  
    function permisos() {
      if (operacion == 1) {
        columnas =
          "<div class='text-center'><button class='btn btn-sm btn-danger btnBorrar'><i class='fas fa-trash-alt'></i></button></div>"
      } else {
        columnas = 
        "<div class='text-center'><button class='btn btn-sm btn-danger btnBorrar'><i class='fas fa-trash-alt'></i></button></div>"
      }
      return columnas
    }
  
    tablaC = $('#tablaC').DataTable({
      columnDefs: [
        {
          targets: -1,
          data: null,
          defaultContent:
            "<div class='text-center'><div class='btn-group'><button class='btn btn-sm btn-success btnSelCliente'><i class='fas fa-hand-pointer'></i></button></div></div>",
        },
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
  
    tablaCon = $('#tablaCon').DataTable({
      columnDefs: [
        {
          targets: -1,
          data: null,
          defaultContent:
            "<div class='text-center'><div class='btn-group'><button class='btn btn-sm btn-success btnSelConcepto'><i class='fas fa-hand-pointer'></i></button></div></div>",
        },
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
  
    //TABLA DETALLE DE desechables
    tablaDet = $('#tablaDet').DataTable({
      paging: false,
      ordering: false,
      info: false,
      searching: false,
  
      columnDefs: [
        {
          targets: -1,
          data: null,
          defaultContent: textopermiso,
        },
        { className: 'hide_column', targets: [0] },
        { className: 'hide_column', targets: [1] }
      ],
  
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
  
      rowCallback: function (row, data) {
        $($(row).find('td')[3]).addClass('text-right')
        val = numeral(data[3]).format('0,0.00')
  
  
        $($(row).find('td')[3]).text(val)
  
        val2 = numeral(data[5]).format('0,0.00')
  
        $($(row).find('td')[5]).addClass('text-right')
        $($(row).find('td')[5]).text(val2)
  
        val3 = numeral(data[6]).format('0,0.00')
  
        $($(row).find('td')[6]).addClass('text-right')
        $($(row).find('td')[6]).text(val3)
      },
    })
  
    //TABLA DESECHABLE
    tablaItem = $('#tablaItem').DataTable({
      columnDefs: [
        {
          targets: -1,
          data: null,
          defaultContent:
            "<div class='text-center'><div class='btn-group'><button class='btn btn-sm btn-success btnSelItem'><i class='fas fa-hand-pointer'></i></button></div></div>",
        },
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
  
    $(document).on('click', '#bproveedor', function () {
      $('.modal-header').css('background-color', '#007bff')
      $('.modal-header').css('color', 'white')
  
      $('#modalProspecto').modal('show')
    })
  
    $(document).on('click', '#bproveedorplus', function () {
      window.location.href = 'cntacliente.php'
    })
  
    $(document).on('click', '#bproyectoplus', function () {
      window.location.href = 'cntaproyecto.php'
    })
  
    $(document).on('click', '#bproyecto', function () {
      $('.modal-header').css('background-color', '#007bff')
      $('.modal-header').css('color', 'white')
  
      $('#modalProyecto').modal('show')
  
      $('#claveconcepto').val('')
      $('#concepto').val('')
      $('#id_umedida').val('')
      $('#usomat').val('')
      $('#nom_umedida').val('')
      $('#bmaterial').prop('disabled', true)
      $('#clavemat').val('')
      $('#material').val('')
      $('#clave').val('')
      $('#idprecio').val('')
      $('#unidad').val('')
  
      $('#precio').val('')
      $('#cantidad').val('')
      $('#cantidad').prop('disabled', true)
    })
  
    $(document).on('click', '.btnSelCliente', function () {
      fila = $(this).closest('tr')
  
      idcliente = fila.find('td:eq(0)').text()
      nomcliente = fila.find('td:eq(2)').text()
  
      opcion = 1
  
      $('#id_cliente').val(idcliente)
      $('#nombre').val(nomcliente)
      $('#modalProspecto').modal('hide')
    })
  
    $(document).on('click', '#btnGuardar', function () {
      folio = $('#folior').val()
      fecha = $('#fecha').val()
  
      id_cliente = $('#id_cliente').val()
      // proveedor = $('#nombre').val()
      // id_item = $('#id_item').val()
      descripcion = $('#descripcion').val()
  
      // importe = $('#importe').val().replace(/,/g, '')
      subtotal = $('#subtotal').val().replace(/,/g, '')
      iva = $('#iva').val().replace(/,/g, '')
      total = $('#total').val().replace(/,/g, '')
      descuento = $('#descuento').val().replace(/,/g, '')
      gtotal = $('#gtotal').val().replace(/,/g, '')
      tipo = $('#tipo').val()
     
      usuario = $('#nameuser').val()
  
      tokenid = $('#tokenid').val()
      opcion = $('#opcion').val()
  
      console.log(folio)
      console.log(fecha)
      console.log(id_cliente)
      console.log(descripcion)
      console.log(subtotal)
      console.log(iva)
      console.log(total)
      console.log(descuento)
      console.log(gtotal)
      console.log(usuario)
  
  
      if (
        folio.length != 0 &&
        fecha.length != 0 &&
        id_cliente.length != 0 &&
        descripcion.length != 0 &&
        gtotal.lenght != 0
        
      ) {
        $.ajax({
          type: 'POST',
          url: 'bd/crudcxc.php',
          dataType: 'json',
          data: {
            fecha: fecha,
            folio: folio,
            id_cliente: id_cliente,
            //proveedor: proveedor,
            descripcion: descripcion,
            subtotal: subtotal,
            //importe: importe,
            iva: iva,
            total: total,
            descuento: descuento,
            gtotal: gtotal,
            tipo: tipo,
            usuario: usuario,
            tokenid: tokenid,
            opcion: opcion,
          },
          success: function (res) {
            if (res == 0) {
              Swal.fire({
                title: 'Error al Guardar',
                text: 'No se pudo guardar los datos de la cuenta por pagar',
                icon: 'error',
              })
            } else {
              Swal.fire({
                title: 'Operación Exitosa',
                text: 'Cuenta por pagar registrada',
                icon: 'success',
              })
  
              window.setTimeout(function () {
                window.location.href = 'cntacxp.php'
              }, 1500)
            }
          },
        })
      } else {
        Swal.fire({
          title: 'Datos Faltantes',
          text: 'Debe ingresar todos los datos del Item',
          icon: 'warning',
        })
        return false
      }
    })
  
    $(document).on('click', '.btnSelConcepto', function () {
      fila = $(this).closest('tr')
      idpartida = fila.find('td:eq(0)').text()
      partida = fila.find('td:eq(2)').text()
      $('#id_proy').val(idpartida)
      $('#proyecto').val(partida)
      $('#modalProyecto').modal('hide')
    })
  
    //BOTON BUSCAR DESECHABLE
    $(document).on('click', '#btnItem', function () {
      $('#modalItem').modal('show')
    })
  
    // SELECCIONAR  DESECHABLE
    $(document).on('click', '.btnSelItem', function () {
      fila = $(this).closest('tr')
      iditem = fila.find('td:eq(0)').text()
      concepto = fila.find('td:eq(1)').text()
      precio = fila.find('td:eq(2)').text()
  
      $('#iditem').val(iditem)
      $('#nomitem').val(concepto)
      $('#precioitem').val(precio)
      $('#descuentoitem').val(0)
  
      $('#precioitem').prop('disabled', false)
  
      $('#cantidaditem').prop('disabled', false)
      $('#descuentoitem').prop('disabled', false)
  
  
      $('#modalItem').modal('hide')
    })
  
    $(document).on('change', '#cantidaditem,#descuentoitem,#precioitem ', function () {
      cantidad = $('#cantidaditem').val().replace(/,/g, '')
      precio = $('#precioitem').val().replace(/,/g, '')
      descuento = $('#descuentoitem').val().replace(/,/g, '')
  
      calcular(cantidad, precio, descuento)
    })
    function calcular(cantidad, precio, descuento) {
      importe = cantidad * precio
      gimporte = importe - descuento
      $('#importeitem').val(Intl.NumberFormat('es-MX', { minimumFractionDigits: 2 }).format(
        parseFloat(importe).toFixed(2),
      ),)
      $('#gimporteitem').val(Intl.NumberFormat('es-MX', { minimumFractionDigits: 2 }).format(
        parseFloat(gimporte).toFixed(2),
      ),)
  
    }
  
        //BOTON LIMPIAR DESECHABLE
    $(document).on('click', '#btnLimpiar', function () {
      limpiardes()
    })
  
    //AGREGAR DESECHABLE
    $(document).on('click', '#btnAgregar', function () {
      folio = $('#folior').val()
      iditem = $('#iditem').val()
      cantidad = $('#cantidaditem').val().replace(/,/g, '')
      precio = $('#precioitem').val().replace(/,/g, '')
      importe = $('#importeitem').val().replace(/,/g, '')
      descuento = $('#descuentoitem').val().replace(/,/g, '')
      gimporte = $('#gimporteitem').val().replace(/,/g, '')
  
      opcion = 1
  
      if (
        folio.length != 0 &&
        iditem.length != 0 &&
        cantidad.length != 0 &&
        precio.length != 0 &&
        descuento.lenght != 0
      ) {
        $.ajax({
          type: 'POST',
          url: 'bd/detallecxc.php',
          dataType: 'json',
          //async: false,
          data: {
            folio: folio,
            iditem: iditem,
            cantidad: cantidad,
            precio: precio,
            importe: importe,
            descuento: descuento,
            gimporte: gimporte,
            opcion: opcion,
  
          },
          success: function (data) {
            id_reg = data[0].id_reg
            iditem = data[0].id_item
            concepto = data[0].concepto
            cantidad = data[0].cantidad
            precio = data[0].precio
            importe = data[0].importe
            descuento = data[0].descuento
            gimporte = data[0].gimporte
  
            tablaDet.row
              .add([id_reg, iditem, concepto, cantidad, precio, importe, descuento, gimporte])
              .draw()
            tipo = 4
            $.ajax({
              url: 'bd/sumadetallev.php',
              type: 'POST',
              dataType: 'json',
              async: false,
              data: { folio: folio },
              success: function (data) {
                subtotal = data
  
                var myNumeral = numeral(subtotal)
                var valor = myNumeral.format('0,0.00')
  
                $('#subtotal').val(valor)
                calcular2 (subtotal)
              },
            })
            limpiardes()
          },
        })
      } else {
        Swal.fire({
          title: 'Datos Faltantes',
          text: 'Debe ingresar todos los datos del Item',
          icon: 'warning',
        })
        return false
      }
    })
  
    function limpiar() {
      var today = new Date()
      var dd = today.getDate()
  
      var mm = today.getMonth() + 1
      var yyyy = today.getFullYear()
      if (dd < 10) {
        dd = '0' + dd
      }
  
      if (mm < 10) {
        mm = '0' + mm
      }
  
      today = yyyy + '-' + mm + '-' + dd
  
      $('#id_prov').val('')
      $('#nombre').val('')
      $('#fecha').val(today)
      $('#folio').val('')
      $('#folior').val('')
      $('#id_partida').val('')
      $('#partida').val('')
      $('#ccredito').val(false)
      $('#fechal').val(today)
      $('#cfactura').val(false)
      $('#referencia').val('')
      $('#proyecto').val('')
      $('#subtotal').val('')
      $('#iva').val('')
      $('#total').val('')
      $('#cinverso').val(false)
    }
  
    function limpiardes() {
      $('#iditem').val('')
      $('#cantidaditem').val('')
      $('#nomitem').val('')
      $('#precioitem').val('')
      $('#importeitem').val('')
      $('#descuentoitem').val('')
      $('#gimporteitem').val('')
  
      $('#precioitem').prop('disabled', true)
      $('#cantidaditem').prop('disabled', true)
      $('#descuentoitem').prop('disabled', true)
  
    }
  
    function round(value, decimals) {
      return Number(Math.round(value + 'e' + decimals) + 'e-' + decimals)
    }
  
    // BORRAR MATERIAL
    $(document).on('click', '.btnBorrar', function (e) {
      e.preventDefault()
      fila = $(this)
      folio = $('#folior').val()
      id = parseInt($(this).closest('tr').find('td:eq(0)').text())
  
  
      tipooperacion = 2
  
      $.ajax({
        type: 'POST',
        url: 'bd/detallecxc.php',
        dataType: 'json',
        data: { id: id, opcion: tipooperacion, folio: folio },
        success: function (data) {
          if (data == 1) {
            tablaDet.row(fila.parents('tr')).remove().draw()
            tipo = 4
            $.ajax({
              url: 'bd/sumadetallev.php',
              type: 'POST',
              dataType: 'json',
              async: false,
              data: { folio: folio, tipo: tipo },
              success: function (data) {
                subtotal = data
  
                var myNumeral = numeral(subtotal)
                var valor = myNumeral.format('0,0.00')
  
                $('#subtotal').val(valor)
                calcular2 (subtotal)
  
              },
            })
          } else {
            mensajeerror()
          }
        },
      })
    })
  
    function calcular2(subtotal) {
  
      tipo=$('#tipo').val()
      if (tipo == 1){
        total = parseFloat(subtotal)*1.16
        iva = total-subtotal
  
      }
      else{
  
        total=subtotal
        iva=0
      }
      
      $('#total').val(Intl.NumberFormat('es-MX', { minimumFractionDigits: 2 }).format(
        parseFloat(total).toFixed(2),
      ),)
      $('#iva').val(Intl.NumberFormat('es-MX', { minimumFractionDigits: 2 }).format(
        parseFloat(iva).toFixed(2),
      ),)
  
      descuento = $('#descuento').val().replace(/,/g, '')
      gtotal = total-descuento
  
      $('#gtotal').val(Intl.NumberFormat('es-MX', { minimumFractionDigits: 2 }).format(
        parseFloat(gtotal).toFixed(2),
        ),)
  
    }
  
    $(document).on('change', '#descuento, #tipo', function () {
      subtotal = $('#subtotal').val().replace(/,/g, '')
      
      calcular2(subtotal)
    })
  
    function mensajeerror() {
      swal.fire({
        title: 'Operacion No exitosa',
        icon: 'error',
        focusConfirm: true,
        confirmButtonText: 'Aceptar',
      })
    }
  })
  
  function filterFloat(evt, input) {
    // Backspace = 8, Enter = 13, ‘0′ = 48, ‘9′ = 57, ‘.’ = 46, ‘-’ = 43
    var key = window.Event ? evt.which : evt.keyCode
    var chark = String.fromCharCode(key)
    var tempValue = input.value + chark
    var isNumber = key >= 48 && key <= 57
    var isSpecial = key == 8 || key == 13 || key == 0 || key == 46
    if (isNumber || isSpecial) {
      return filter(tempValue)
    }
  
    return false
  }
  function filter(__val__) {
    var preg = /^([0-9]+\.?[0-9]{0,2})$/
    return preg.te
    st(__val__) === true
  }
  
  function addCommas(nStr) {
    nStr += ''
    x = nStr.split('.')
    x1 = x[0]
    x2 = x.length > 1 ? '.' + x[1] : ''
    var rgx = /(\d+)(\d{3})/
    while (rgx.test(x1)) {
      x1 = x1.replace(rgx, '$1' + ',' + '$2')
    }
    return x1 + x2
  }
  