$(document).ready(function() {


    tabla = $("#tabla").DataTable({
        searching:false,
        ordering:false,
        info:false,
        paging:false,

        columnDefs: [{
                targets: -1,
                data: null,
                defaultContent: "<div class='text-center'>\
                                    <div class='btn-group'>\
                                        <button class='btn btn-sm btn-primary  btnEditar'><i class='fas fa-edit'></i></button>\
                                        <button class='btn btn-sm btn-danger btnBorrar'><i class='fas fa-trash-alt'></i></button>\
                                    </div>\
                                </div>"
            },
            { className: 'text-center', targets: [0] },
            { className: 'text-center', targets: [1] },
            { className: 'text-right', targets: [2] },
            { className: 'text-right', targets: [3] },
            { className: 'text-right', targets: [4] },
            { className: 'text-right', targets: [5] },
        ],

        //Para cambiar el lenguaje a español
        "language": {
            "lengthMenu": "Mostrar _MENU_ registros",
            "zeroRecords": "No se encontraron resultados",
            "info": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "infoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
            "infoFiltered": "(filtrado de un total de _MAX_ registros)",
            "sSearch": "Buscar:",
            "oPaginate": {
                "sFirst": "Primero",
                "sLast": "Último",
                "sNext": "Siguiente",
                "sPrevious": "Anterior"
            },
            "sProcessing": "Procesando...",
        }
    });

    $("#btnCalcular").click(function() {
       
        vt=$('#vt').val()
        nmens=$('#nmens').val()
        tinteres=$('#tinteres').val()
        fechaini=$('#fechaini').val()

        tabla.clear()
        tabla.draw()

        $.ajax({

            url: "../bd/calcular.php",
            type: "POST",
            dataType: "json",
            data: { vt: vt, nmens: nmens, tinteres: tinteres, fechaini: fechaini },

            success: function(res) {
            
                for (var i = 0; i < res.length; i++) {
                    tabla.row
                      .add([
                        res[i].id,
                        res[i].fecha,
                        res[i].capital,
                        res[i].interes,
                        res[i].sumaTotal,
                        res[i].saldo,
                        
                      
                      ])
                      .draw()
                  }
            },
            error: function(){
                alert("Funcion Error")
            }
        });
       
    });

    $(".btnEditar").click(function() {
        alert("BOTON EDITAR");
       
    });

    

    $(".btnBorrar").click(function() {
        alert("BOTON BORRAR");
       
    });

})