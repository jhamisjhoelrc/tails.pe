$(document).ready(function () {
  /* FUNCION ACTUALIZAR MOTIVO DE AFECTACIÓN DE LA NOTA */
  $("#typeVoucherAddSales").change(function () {
      $("#motive").empty();
      if($(this).val() == '08'){
        $("#motive").html(
          "<option value='01'>Interes por mora</option><option value='02'>Aumento en el valor</option><option value='03'>Penalidades / otros conceptos</option><option value='11'>Ajustes de operaciones de exportación</option><option value='12'>Ajustes afectos al IVAP</option>"
        );
      } else {
        $("#motive").html(
          "<option value='01'>Anulación de la operación</option><option value='02'>Anulación por error en el RUC</option><option value='03'>Corrección por error en la descripción</option><option value='04'>Descuento global</option><option value='05'>Descuento por item</option><option value='06'>Devolución total</option><option value='07'>Devolución por item</option><option value='08'>Bonificación</option><option value='09'>Disminución en el valor</option><option value='10'>Otros conceptos</option><option value='11'>Ajustes de operaciones de exportación</option><option value='12'>Ajustes afectos al IVAP</option>"
        );
      }
      
  });



  /* CARGAR TABLA DINAMICA DE NOTAS EN DATATABLES */
  $(".tableNotas").DataTable({
    ajax: "ajax/datatable-notas.ajax.php",
    deferRender: true,
    retrieve: true,
    processing: true,

    language: {
      sProcessing: "Procesando...",
      sLengthMenu: "Mostrar _MENU_ registros",
      sZeroRecords: "No se encontraron resultados",
      sEmptyTable: "Ningún dato disponible en esta tabla",
      sInfo: "Mostrando registros del _START_ al _END_ de un total de _TOTAL_",
      sInfoEmpty: "Mostrando registros del 0 al 0 de un total de 0",
      sInfoFiltered: "(filtrado de un total de _MAX_ registros)",
      sInfoPostFix: "",
      sSearch: "Buscar:",
      sUrl: "",
      sInfoThousands: ",",
      sLoadingRecords: "Cargando...",
      oPaginate: {
        sFirst: "Primero",
        sLast: "Último",
        sNext: "Siguiente",
        sPrevious: "Anterior",
      },
      oAria: {
        sSortAscending:
          ": Activar para ordenar la columna de manera ascendente",
        sSortDescending:
          ": Activar para ordenar la columna de manera descendente",
      },
    },
  });

  // VISUALIZAR NOTAS
  $(document).on("click", ".btnShowNotas", function () {
    var salesView = $(this).attr("idNota");
    window.location = "index.php?route=showNota&salesView=" + salesView;
  });

    // VISUALIZAR RESPUESTA DE OBSERVACIONES - FACTURACION ELECTRONICA
    $(document).on("click", ".btnShowObs", function () {
      var idInvoicing = $(this).attr("idInvoicing");
      var data = new FormData();
      data.append("idInvoicing", idInvoicing);
      $.ajax({
        url: "ajax/sales.ajax.php",
        method: "POST",
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function (response) {
          $("#messageObs").val(response.message_response);
        },
      });
    });

});
