$(document).ready(function () {
  /* CARGAR TABLA DINAMICA DE NATIONALS EN DATATABLES */
  $(".tableNational").DataTable({
    ajax: "ajax/datatable-national.ajax.php",
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

  // VISUALIZAR COMPRAS NACIONALES
  $(document).on("click", ".btnShowNational", function () {
    var idNational = $(this).attr("idNational");
    var provider = $(this).attr("provider");
    var subsidiary = $(this).attr("subsidiary");
    var data = new FormData();
    data.append("idNational", idNational);
    $.ajax({
      url: "ajax/nationals.ajax.php",
      method: "POST",
      data: data,
      cache: false,
      contentType: false,
      processData: false,
      dataType: "json",
      success: function (response) {
        $("#nameProviderNational").val(provider);
        $("#subsidiaryNational").val(subsidiary);

        $.each(response, (index, value) => {
          $(".bodyShow").append(
            '<tr><th scope="row">' +
              (Number(index) + 1) +
              "</th><td>" +
              value.dam +
              "</td><td>" +
              value.chasis +
              "</td><td>" +
              value.motor +
              "</td><td>" +
              value.color +
              "</td><td>" +
              value.fabricacion +
              "</td></tr>"
          );
        });
      },
    });
  });

  // EDITAR COMPRAS NACIONALES
  $(document).on("click", ".btnEditNational", function () {
    var nationalsView = $(this).attr("nationalsView");
    window.location =
      "index.php?route=editNational&nationalsView=" + nationalsView;
  });

  /* ELIMINAR COMPRAS NACIONALES */
  $(document).on("click", ".btnDeleteNational", function () {
    var idNational = $(this).attr("idNational");

    Swal.fire({
      title: "Esta seguro de eliminar la compra nacional?",
      icon: "warning",
      showConfirmButton: true,
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      cancelButtonText: "Cancelar",
      confirmButtonText: "Si, borrar la compra nacional!",
    }).then(function (result) {
      if (result.value) {
        window.location = "index.php?route=nationals&idNational=" + idNational;
      }
    });
  });
});
