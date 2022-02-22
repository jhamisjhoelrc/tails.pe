$(document).ready(function () {
    /* CARGAR TABLA DINAMICA DE MOVILES EN DATATABLES */
    $(".tableMoviles").DataTable({
      ajax: "ajax/datatable-moviles.ajax.php",
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


  /* ACTIVAR O DESACTIVAR UN MOVIL */
  $(document).on("click", ".btnActivateMovil", function () {
    var idMovil = $(this).attr("idMovil");
    var statusMovil = $(this).attr("statusMovil");
    var data = new FormData();
    data.append("activateId", idMovil);
    data.append("activateMovil", statusMovil);
    $.ajax({
      url: "ajax/moviles.ajax.php",
      method: "POST",
      data: data,
      cache: false,
      contentType: false,
      processData: false,
      success: function (response) {
        if (window.matchMedia("(max-width:1300px)").matches) {
          Swal.fire({
            icon: "success",
            title: "El estado ha sido actualizado",
            confirmButtonText: "Cerrar",
          }).then(function (result) {
            if (result.value) {
              window.location = "moviles";
            }
          });
        }
      },
    });

    if (statusMovil == 5) {
      $(this).removeClass("btn-default");
      $(this).addClass("btn-success");
      $(this).html("Vendida");
      $(this).attr("statusMovil", 1);
    } else {
      $(this).addClass("btn-default");
      $(this).removeClass("btn-success");
      $(this).html("Stock");
      $(this).attr("statusMovil", 5);
    }
  });

  /* EDITAR MOVILES */
  $(document).on("click", ".btnAssembler", function () {
    var idMovil = $(this).attr("idMovil");
    var data = new FormData();
    data.append("idMovil", idMovil);
    $.ajax({
      url: "ajax/moviles.ajax.php",
      method: "POST",
      data: data,
      cache: false,
      contentType: false,
      processData: false,
      dataType: "json",
      success: function (response) {
        $("#idMovil").val(response["id"]);
        $("#modelAssembler").val(response["model"]);
        $("#motorAssembler").val(response["motor"]);
        $("#chasisAssembler").val(response["chasis"]);
        $("#dateAssembler").val(response["date_assembly"]);
        $("#nameAssemblerAsign").val(response["id_assembler"]);
        $("#nameAssemblerAsign").html(response["assembler"]);
        $("#detailAssembler").val(response["observation_assembly"]);
        
      },
    });
  });

  /* ELIMINAR MOVILES */
  $(document).on("click", ".btnDeleteMovil", function () {
    var idMovil = $(this).attr("idMovil");

    Swal.fire({
      title: "Esta seguro de eliminar el móvil?",
      icon: "warning",
      showConfirmButton: true,
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      cancelButtonText: "Cancelar",
      confirmButtonText: "Si, borrar el móvil!",
    }).then(function (result) {
      if (result.value) {
        window.location = "index.php?route=moviles&idMovil=" + idMovil;
      }
    });
  });

});