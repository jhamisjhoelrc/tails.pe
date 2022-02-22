$(document).ready(function () {
  /* FUNCION BUSCAR DISTRITO, PROVINCIA Y DEPARTAMENTO */
  $("#districtPartida").change(function () {
    var idDistrict = $(this).val();
    var data = new FormData();
    data.append("idDistrict", idDistrict);
    $.ajax({
      url: "ajax/sales.ajax.php",
      method: "POST",
      data: data,
      cache: false,
      contentType: false,
      processData: false,
      dataType: "json",
      success: function (response) {
        console.log(response);
        $("#provincePartida").val(response["province"]);
        $("#departmentPartida").val(response["department"]);
      },
    });
  });
  $("#districtLlegada").change(function () {
    var idDistrict = $(this).val();
    var data = new FormData();
    data.append("idDistrict", idDistrict);
    $.ajax({
      url: "ajax/sales.ajax.php",
      method: "POST",
      data: data,
      cache: false,
      contentType: false,
      processData: false,
      dataType: "json",
      success: function (response) {
        console.log(response);
        $("#provinceLlegada").val(response["province"]);
        $("#departmentLlegada").val(response["department"]);
      },
    });
  });

  /* CARGAR TABLA DINAMICA DE NATIONALS EN DATATABLES */
  $(".tableGuias").DataTable({
    ajax: "ajax/datatable-guias.ajax.php",
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


  /* FUNCION AGREGAR MOVIL CON CODIGO DE MOTOR AUTOCOMPLETADO PARA GUIAS */
  $("#motorAddGuia").autocomplete({
    source: "controllers/c.allMovilComplete.php",
    select: function (event, item) {
      var params = {
        product: item.item.value,
      };
      $.get(
        "controllers/c.movilCompleteResponse.php",
        params,
        function (response) {
          var json = JSON.parse(response);
          if (json.status == 200) {
            $number = parseInt($(".numberItemMovil:last").html());
            if (isNaN($number)) {
              $number = 0;
            }
              
            $("tbody").append(
              '<tr><th scope="row" class="numberItemMovil">' +
                  ($number + 1) +
                  '</th><td><input type="text" name="category[]" class="form-control categoryGuia'+($number+1)+'" readonly></td><td><input type="text" name="brand[]" class="form-control brandGuia'+($number+1)+'" readonly></td><td><input type="text" name="model[]" class="form-control modelGuia'+($number+1)+'" readonly></td><td><input type="text" name="chasis[]" class="form-control chasisGuia'+($number+1)+'" readonly></td><td><input type="text" name="motor[]"  class="form-control motorGuia'+($number+1)+'" readonly></td><td><input type="text" name="colour[]" class="form-control colourGuia'+($number+1)+'" readonly></td><td><div class="btn-group"><button class="btn btn-danger btnDeleteItem"><i class="fas fa-times"></i></button></div></td></tr><input type="hidden" name="idMovil[]" class="form-control idMovilGuia'+($number+1)+'"><input type="hidden" name="fabricacion[]" class="form-control fabricacionGuia'+($number+1)+'">'
              );
            $(".idMovilGuia" + ($number + 1)).val(json.id);
            $(".categoryGuia" + ($number + 1)).val(json.category);
            $(".brandGuia" + ($number + 1)).val(json.brand);
            $(".modelGuia" + ($number + 1)).val(json.model);
            $(".chasisGuia" + ($number + 1)).val(json.chasis);
            $(".motorGuia" + ($number + 1)).val(json.motor);
            $(".colourGuia" + ($number + 1)).val(json.colour);
            $(".fabricacionGuia" + ($number + 1)).val(json.fabricacion);

            $("#motorAddGuia").val("");  
          }
        }
      );
    },
  });

  /* FUNCION AGREGAR MOVIL CON CODIGO DE MOTOR AUTOCOMPLETADO */
  $("#chasisAddGuia").autocomplete({
    source: "controllers/c.allMovilChasisComplete.php",
    select: function (event, item) {
      var params = {
        product: item.item.value,
      };
      $.get(
        "controllers/c.movilChasisCompleteResponse.php",
        params,
        function (response) {
          var json = JSON.parse(response);
          if (json.status == 200) {
            $number = parseInt($(".numberItemGuia:last").html());
            if (isNaN($number)) {
              $number = 0;
            }
              
            $("tbody").append(
              '<tr><th scope="row" class="numberItemGuia">' +
                  ($number + 1) +
                  '</th><td><input type="text" name="category[]" class="form-control categoryGuia'+($number+1)+'" readonly></td><td><input type="text" name="brand[]" class="form-control brandGuia'+($number+1)+'" readonly></td><td><input type="text" name="model[]" class="form-control modelGuia'+($number+1)+'" readonly></td><td><input type="text" name="chasis[]" class="form-control chasisGuia'+($number+1)+'" readonly></td><td><input type="text" name="motor[]"  class="form-control motorGuia'+($number+1)+'" readonly></td><td><input type="text" name="colour[]" class="form-control colourGuia'+($number+1)+'" readonly></td><td><div class="btn-group"><button class="btn btn-danger btnDeleteItem"><i class="fas fa-times"></i></button></div></td></tr><input type="hidden" name="idMovil[]" class="form-control idMovilGuia'+($number+1)+'"><input type="hidden" name="fabricacion[]" class="form-control fabricacionGuia'+($number+1)+'">'
              );
            $(".idMovilGuia" + ($number + 1)).val(json.id);
            $(".categoryGuia" + ($number + 1)).val(json.category);
            $(".brandGuia" + ($number + 1)).val(json.brand);
            $(".modelGuia" + ($number + 1)).val(json.model);
            $(".chasisGuia" + ($number + 1)).val(json.chasis);
            $(".motorGuia" + ($number + 1)).val(json.motor);
            $(".colourGuia" + ($number + 1)).val(json.colour);
            $(".fabricacionGuia" + ($number + 1)).val(json.fabricacion);
            
            $("#chasisAddGuia").val("");  
          }
        }
      );
    },
  });

  /* FUNCION PARA ELIMINAR EL ITEM DEL MOVIL DE GUIAS */
  $(document).on("click", ".btnDeleteItem", function () {
    $fila = $(this).parent().parent().parent();
    /*console.log("consiguiendo la fila", $fila);*/
    $fila.remove();
    $contador = parseInt($(".numberItemGuia:last").html());
  });

  /* FUNCION AGREGAR DATOS AUTOCOMPLETADOS DE CLIENTE */
  $("#nameCustomer").autocomplete({
    source: "controllers/c.customersComplete.php",
    select: function (event, item) {
      var params = {
        product: item.item.value,
      };
      $.get(
        "controllers/c.customersCompleteResponse.php",
        params,
        function (response) {
          var json = JSON.parse(response);
          if (json.status == 200) {
            $("#nameCustomer").val(json.names);
            $("#id_customer").val(json.id);
          }
        }
      );
    },
  });

  /* FUNCION PARA IDENTIFICAR EL CLIENTE DE UN COMPROBANTE AFECTO */
  $("#voucherAffected").change(function () {
    var idInvoicing = $(this).val();
    var data = new FormData();
    data.append("idInvoicing", idInvoicing);
    $.ajax({
      url: "ajax/guia.ajax.php",
      method: "POST",
      data: data,
      cache: false,
      contentType: false,
      processData: false,
      dataType: "json",
      success: function (response) {
        $("#nameCustomer").val(response["customer"]);
        $concatenate = response['serial_number'] +'-'+ response['correlative'];
        $("#comprobante").val($concatenate);
        $("#type_voucher").val(response["type_voucher"]);
        $("#id_customer").val(response["id_customer"]);
      },
    });
  });

  // VISUALIZAR RESPUESTA DE OBSERVACIONES - FACTURACION ELECTRONICA
  $(document).on("click", ".btnShowObsGuia", function () {
    var idInvoicingGuia = $(this).attr("idInvoicing");
    var data = new FormData();
    data.append("idInvoicingGuia", idInvoicingGuia);
    $.ajax({
      url: "ajax/guia.ajax.php",
      method: "POST",
      data: data,
      cache: false,
      contentType: false,
      processData: false,
      dataType: "json",
      success: function (response) {
        $("#messageObsGuia").val(response.message_response);
      },
    });
  });

  // VISUALIZAR NOTAS
  $(document).on("click", ".btnShowGuias", function () {
    var guiasView = $(this).attr("guiasView");
    window.location = "index.php?route=showGuia&guiasView=" + guiasView;
  });

  /* FUNCION AGREGAR DATOS AUTOCOMPLETADOS DE CLIENTE */
  $("#nameCustomer").autocomplete({
    source: "controllers/c.customersComplete.php",
    select: function (event, item) {
      var params = {
        product: item.item.value,
      };
      $.get(
        "controllers/c.customersCompleteResponse.php",
        params,
        function (response) {
          var json = JSON.parse(response);
          if (json.status == 200) {
            $("#id_customer").val(json.id);
          }
        }
      );
    },
  });
});
