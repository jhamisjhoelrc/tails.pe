$(document).ready(function () {
  /* CARGAR TABLA DINAMICA DE TIPO DE CAMBIO EN DATATABLES */
  $(".tableExchange").DataTable({
    ajax: "ajax/datatable-exchange.ajax.php",
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

  /* EDITAR UN TIPO DE CAMBIO */
  $(document).on("click", ".btnEditExchange", function () {
    var idExchange = $(this).attr("exchangeView");
    var data = new FormData();
    data.append("idExchange", idExchange);
    $.ajax({
      url: "ajax/exchange.ajax.php",
      method: "POST",
      data: data,
      cache: false,
      contentType: false,
      processData: false,
      dataType: "json",
      success: function (response) {
        $("#valueExchangeEdit").val(response["value_exchange"]);
        $("#dateExchangeEdit").val(response["date_exchange"]);
        $("#idExchange").val(response["id"]);
      },
    });
  });

});