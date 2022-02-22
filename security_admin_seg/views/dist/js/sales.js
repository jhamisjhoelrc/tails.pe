$(document).ready(function () {
  /* CARGAR TABLA DINAMICA DE NATIONALS EN DATATABLES */
  $(".tableSales").DataTable({
    ajax: "ajax/datatable-sales.ajax.php",
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

  /* FUNCION AGREGAR DATOS AUTOCOMPLETADOS DE CLIENTE DESDE EL NAME */
  $("#nameCustomerAddSales").autocomplete({
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
            $("#documentTypeAddSales").val(json.id_document);
            $("#documentNumberAddSales").val(json.document_number);
            $("#phoneAddSales").val(json.phone);
            $("#emailAddSales").val(json.email);
            $("#customerTypeAddSales").val(json.customer_type);
            $("#addressCustomerAddSales").val(json.address);
            $("#idCustomer").val(json.id);
          }
        }
      );
    },
  });

  /* FUNCION AGREGAR DATOS AUTOCOMPLETADOS DE CLIENTE DESDE EL DOCUMENT NUMBER */
  $("#documentNumberAddSales").autocomplete({
    source: "controllers/c.documentCustomerComplete.php",
    select: function (event, item) {
      var params = {
        product: item.item.value,
      };
      $.get(
        "controllers/c.documentCustomerCompleteResponse.php",
        params,
        function (response) {
          var json = JSON.parse(response);
          if (json.status == 200) {
            
            $("#nameCustomerAddSales").val(json.names);
            $("#documentTypeAddSales").val(json.id_document);
            $("#phoneAddSales").val(json.phone);
            $("#emailAddSales").val(json.email);
            $("#customerTypeAddSales").val(json.customer_type);
            $("#addressCustomerAddSales").val(json.address);
            $("#idCustomer").val(json.id);
          }
        }
      );
    },
  });

  /* FUNCION BUSCAR DISTRITO, PROVINCIA Y DEPARTAMENTO */
  $("#districtAddSales").change(function () {
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
        $("#provinceAddSales").val(response["province"]);
        $("#departmentAddSales").val(response["department"]);
      },
    });
  });

  /* FUNCION AGREGAR MOVIL CON CODIGO DE MOTOR AUTOCOMPLETADO */
  $("#motorAddSales").autocomplete({
    source: "controllers/c.movilComplete.php",
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
            $number = parseInt($(".numberItem:last").html());
            if (isNaN($number)) {
              $number = 0;
            }
              
            $("#tableMovil").append(
              '<tr><th scope="row" class="numberItem">' +
                  ($number + 1) +
                  '</th><td><input type="text" name="category[]" class="form-control categorySales'+($number+1)+'" readonly></td><td><input type="text" name="brand[]" class="form-control brandSales'+($number+1)+'" readonly></td><td><input type="text" name="model[]" class="form-control modelSales'+($number+1)+'" readonly></td><td><input type="text" name="chasis[]" class="form-control chasisSales'+($number+1)+'" readonly></td><td><input type="text" name="motor[]"  class="form-control motorSales'+($number+1)+'" readonly></td><td><input type="text" name="colour[]" class="form-control colourSales'+($number+1)+'" readonly></td><td><input type="text" name="priceMovil[]" class="form-control priceSales'+($number+1)+'" required></td><td><div class="btn-group"><button class="btn btn-danger btnDeleteItem"><i class="fas fa-times"></i></button></div></td></tr><input type="hidden" name="idMovil[]" class="form-control idMovilSales'+($number+1)+'"><input type="hidden" name="fabricacion[]" class="form-control fabricacionSales'+($number+1)+'">'
              );
            $(".idMovilSales" + ($number + 1)).val(json.id);
            $(".categorySales" + ($number + 1)).val(json.category);
            $(".brandSales" + ($number + 1)).val(json.brand);
            $(".modelSales" + ($number + 1)).val(json.model);
            $(".chasisSales" + ($number + 1)).val(json.chasis);
            $(".motorSales" + ($number + 1)).val(json.motor);
            $(".colourSales" + ($number + 1)).val(json.colour);
            $(".fabricacionSales" + ($number + 1)).val(json.fabricacion);

            $("#motorAddSales").val("");  
          }
        }
      );
    },
  });
  /* FUNCION AGREGAR MOVIL CON CODIGO DE MOTOR AUTOCOMPLETADO PARA NOTAS */
  $("#motorAddNote").autocomplete({
    source: "controllers/c.movilCompleteFree.php",
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
            $number = parseInt($(".numberItem:last").html());
            if (isNaN($number)) {
              $number = 0;
            }
              
            $("#tableMovil").append(
              '<tr><th scope="row" class="numberItem">' +
                  ($number + 1) +
                  '</th><td><input type="text" name="category[]" class="form-control categorySales'+($number+1)+'" readonly></td><td><input type="text" name="brand[]" class="form-control brandSales'+($number+1)+'" readonly></td><td><input type="text" name="model[]" class="form-control modelSales'+($number+1)+'" readonly></td><td><input type="text" name="chasis[]" class="form-control chasisSales'+($number+1)+'" readonly></td><td><input type="text" name="motor[]"  class="form-control motorSales'+($number+1)+'" readonly></td><td><input type="text" name="colour[]" class="form-control colourSales'+($number+1)+'" readonly></td><td><input type="text" name="priceMovil[]" class="form-control priceSales'+($number+1)+'" required></td><td><div class="btn-group"><button class="btn btn-danger btnDeleteItem"><i class="fas fa-times"></i></button></div></td></tr><input type="hidden" name="idMovil[]" class="form-control idMovilSales'+($number+1)+'"><input type="hidden" name="fabricacion[]" class="form-control fabricacionSales'+($number+1)+'">'
              );
            $(".idMovilSales" + ($number + 1)).val(json.id);
            $(".categorySales" + ($number + 1)).val(json.category);
            $(".brandSales" + ($number + 1)).val(json.brand);
            $(".modelSales" + ($number + 1)).val(json.model);
            $(".chasisSales" + ($number + 1)).val(json.chasis);
            $(".motorSales" + ($number + 1)).val(json.motor);
            $(".colourSales" + ($number + 1)).val(json.colour);
            $(".fabricacionSales" + ($number + 1)).val(json.fabricacion);

            $("#motorAddSales").val("");  
          }
        }
      );
    },
  });


  /* FUNCION AGREGAR MOVIL CON CODIGO DE MOTOR AUTOCOMPLETADO */
  $("#chasisAddSales").autocomplete({
    source: "controllers/c.movilChasisComplete.php",
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
            $number = parseInt($(".numberItem:last").html());
            if (isNaN($number)) {
              $number = 0;
            }
              
            $("#tableMovil").append(
              '<tr><th scope="row" class="numberItem">' +
                  ($number + 1) +
                  '</th><td><input type="text" name="category[]" class="form-control categorySales'+($number+1)+'" readonly></td><td><input type="text" name="brand[]" class="form-control brandSales'+($number+1)+'" readonly></td><td><input type="text" name="model[]" class="form-control modelSales'+($number+1)+'" readonly></td><td><input type="text" name="chasis[]" class="form-control chasisSales'+($number+1)+'" readonly></td><td><input type="text" name="motor[]"  class="form-control motorSales'+($number+1)+'" readonly></td><td><input type="text" name="colour[]" class="form-control colourSales'+($number+1)+'" readonly></td><td><input type="text" name="priceMovil[]" class="form-control priceSales'+($number+1)+'" required></td><td><div class="btn-group"><button class="btn btn-danger btnDeleteItem"><i class="fas fa-times"></i></button></div></td></tr><input type="hidden" name="idMovil[]" class="form-control idMovilSales'+($number+1)+'"><input type="hidden" name="fabricacion[]" class="form-control fabricacionSales'+($number+1)+'">'
              );
            $(".idMovilSales" + ($number + 1)).val(json.id);
            $(".categorySales" + ($number + 1)).val(json.category);
            $(".brandSales" + ($number + 1)).val(json.brand);
            $(".modelSales" + ($number + 1)).val(json.model);
            $(".chasisSales" + ($number + 1)).val(json.chasis);
            $(".motorSales" + ($number + 1)).val(json.motor);
            $(".colourSales" + ($number + 1)).val(json.colour);
            $(".fabricacionSales" + ($number + 1)).val(json.fabricacion);
            
            $("#chasisAddSales").val("");  
          }
        }
      );
    },
  });
  /* FUNCION AGREGAR MOVIL CON CODIGO DE MOTOR AUTOCOMPLETADO PARA NOTAS */
  $("#chasisAddNote").autocomplete({
    source: "controllers/c.movilChasisCompleteFree.php",
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
            $number = parseInt($(".numberItem:last").html());
            if (isNaN($number)) {
              $number = 0;
            }
              
            $("#tableMovil").append(
              '<tr><th scope="row" class="numberItem">' +
                  ($number + 1) +
                  '</th><td><input type="text" name="category[]" class="form-control categorySales'+($number+1)+'" readonly></td><td><input type="text" name="brand[]" class="form-control brandSales'+($number+1)+'" readonly></td><td><input type="text" name="model[]" class="form-control modelSales'+($number+1)+'" readonly></td><td><input type="text" name="chasis[]" class="form-control chasisSales'+($number+1)+'" readonly></td><td><input type="text" name="motor[]"  class="form-control motorSales'+($number+1)+'" readonly></td><td><input type="text" name="colour[]" class="form-control colourSales'+($number+1)+'" readonly></td><td><input type="text" name="priceMovil[]" class="form-control priceSales'+($number+1)+'" required></td><td><div class="btn-group"><button class="btn btn-danger btnDeleteItem"><i class="fas fa-times"></i></button></div></td></tr><input type="hidden" name="idMovil[]" class="form-control idMovilSales'+($number+1)+'"><input type="hidden" name="fabricacion[]" class="form-control fabricacionSales'+($number+1)+'">'
              );
            $(".idMovilSales" + ($number + 1)).val(json.id);
            $(".categorySales" + ($number + 1)).val(json.category);
            $(".brandSales" + ($number + 1)).val(json.brand);
            $(".modelSales" + ($number + 1)).val(json.model);
            $(".chasisSales" + ($number + 1)).val(json.chasis);
            $(".motorSales" + ($number + 1)).val(json.motor);
            $(".colourSales" + ($number + 1)).val(json.colour);
            $(".fabricacionSales" + ($number + 1)).val(json.fabricacion);
            
            $("#chasisAddSales").val("");  
          }
        }
      );
    },
  });

  /* FUNCION PARA ELIMINAR EL ITEM DEL MOVIL */
  $(document).on("click", ".btnDeleteItem", function () {
    $fila = $(this).parent().parent().parent();
    /*console.log("consiguiendo la fila", $fila);*/
    $fila.remove();
    $contador = parseInt($(".numberItem:last").html());
  });

  // GENERAR GUIA
  $(document).on("click", ".btnGuia", function () {
    var idSale = $(this).attr("idSale");
    window.location = "index.php?route=addGuia&idSale=" + idSale;
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

  // EDITAR SALES
  $(document).on("click", ".btnEditSales", function () {
    var salesView = $(this).attr("salesView");
    window.location = "index.php?route=editSales&salesView=" + salesView;
  });

  // VER SALES
  $(document).on("click", ".btnShowSales", function () {
    var salesView = $(this).attr("salesView");
    window.location = "index.php?route=showSale&salesView=" + salesView;
  });

  /* FUNCION PARA AGREGAR FILAS A LA TABLA DE PAGOS DE LA VENTA */
  $(document).on("click", ".btnAddPaydSales", function () {
    $number = parseInt($(".numberPayd:last").html());
            if (isNaN($number)) {
              $number = 0;
            }
            $("#tablePayd").append(
                      `<tr>
                        <th scope="row" class="numberPayd">`+ ($number +1) +`</th>
                        <td>
                          <div class="input-group date datePayd" data-target-input="nearest">
                              <div class="input-group-append" data-target="#datePayd" data-toggle="datetimepicker">
                              </div>
                              <input type="text" class="form-control datetimepicker-input" name="dateAddPayment[]" data-target="#datePayd" />
                          </div>
                        </td>
                        <td>
                           <select class="form-control" name="paymentMethodAddPayment[]">
                              <option value="Efectivo" >Efectivo</option>
                              <option value="Tarjeta de crédito">Tarjeta de crédito</option>
                              <option value="Tarjeta de débito">Tarjeta de débito</option>
                              <option value="Transferencia">Transferencia</option>
                           </select>
                        </td>
                        <td>
                           <select class="form-control" name="destinyAddPayment[]">
                              <option value="BCP" >BCP</option>
                              <option value="BBVA">BBVA</option>
                              <option value="Scotiabank">Scotiabank</option>
                              <option value="Interbank">Interbank</option>
                           </select>
                        </td>
                        <td><input type="text" name="referenceAddPayment[]" class="form-control"></td>
                        <td><input type="text" name="amountAddPayment[]" class="form-control"></td>
                        <td>
                           <div class="btn-group">
                              <button class="btn btn-danger btnDeleteItem"><i class="fas fa-times"></i></button>
                           </div>
                        </td>
                     </tr>`
            );
              $(".datePayd")
              .datepicker({
                format: "yyyy-mm-dd",
                weekStart: 0,
                autoClose: true,
                language: "es",
              })
              .datepicker("setDate", new Date());
  });
  
  var totalPagar = 0;

  // CONSULTAR MONTO TOTAL A PAGAR
  $(document).on("click", ".btnPayd", function () {
    var idSales = $(this).attr("idSales");
    $("#idSale").val(idSales);
    var data = new FormData();
    data.append("idSales", idSales);
    $.ajax({
      url: "ajax/sales.ajax.php",
      method: "POST",
      data: data,
      cache: false,
      contentType: false,
      processData: false,
      dataType: "json",
      success: function (response) {
        totalPagar = response.total_price;
        $("#total_pagar").html(response.total_price);
      },
    });
  });

  // CONSULTAR MOVIMIENTOS DE PAGO
  $(document).on("click", ".btnPayd", function () {
    $("#total_pendiente").empty();
    $("#tablePayd").empty();
    var idSalePayd = $(this).attr("idSales");
    var data = new FormData();
    data.append("idSalePayd", idSalePayd);
    $.ajax({
      url: "ajax/sales.ajax.php",
      method: "POST",
      data: data,
      cache: false,
      contentType: false,
      processData: false,
      dataType: "json",
      success: function (response) {
        var totalPagado = 0;
        $.each(response, (index, value) => {
          totalPagado = (parseFloat(totalPagado) + parseFloat(value.amount))
          $("#tablePayd").append(
            '<tr><th scope="row" class="numberPayd">' +
              (Number(index) + 1) +
              "</th><td>" +
              value.payment_date +
              "</td><td>" +
              value.payment_method +
              "</td><td>" +
              value.destiny +
              "</td><td>" +
              value.reference +
              "</td><td>" +
              value.amount +
              "</td><td></td></tr>"
          );
        });
        
        $("#total_pagado").html(totalPagado.toFixed(2));
        $("#total_pendiente").html((totalPagar - totalPagado).toFixed(2));
        

      },
    });
  });

  // FUNCION PARA AGREGAR TABLA DE CRONOGRAMA DE PAGOS A CREDITO
  $("#paymentConditionAddSales").change(function () {
    var forma_pago = $(this).val();
    if(forma_pago == 'Crédito'){
      $(".btnAddCredito").removeClass("d-none");
      $(".grupotablacronograma").removeClass("d-none");
      
      $number = parseInt($(".numberCredito:last").html());
      if (isNaN($number)) {
        $number = 0;
      }

      $("#tableCredito").append("<tr><th scope='row' class='numberCredito'>"+ ($number +1) +"</th><td><input type='text' class='form-control dateCronograma' name='dateCronograma[]'/></td><td><input type='text' class='form-control' name='montoCronograma[]'/></td><td><div class='btn-group'><button class='btn btn-danger btnDeleteCronograma'><i class='fas fa-times'></i></button></div></td></tr><tr><th scope='row' class='numberCredito'>"+ ($number +2) +"</th><td><input type='text' class='form-control dateCronograma' name='dateCronograma[]'/></td><td><input type='text' class='form-control' name='montoCronograma[]'/></td><td><div class='btn-group'><button class='btn btn-danger btnDeleteCronograma'><i class='fas fa-times'></i></button></div></td></tr>");

      $(".dateCronograma")
      .datepicker({
        format: "yyyy-mm-dd",
        weekStart: 0,
        autoClose: true,
        language: "es",
      })
      .datepicker("setDate", new Date());

    } else {
      $(".btnAddCredito").addClass("d-none");
      $(".grupotablacronograma").addClass("d-none");
    }
  });

  // FUNCION PARA AGREGAR ITEM A CRONOGRAMA DE PAGOS
  $(document).on("click", ".btnAddCredito", function () {
    $number = parseInt($(".numberCredito:last").html());
      if (isNaN($number)) {
        $number = 0;
      }

      $("#tableCredito").append("<tr><th scope='row' class='numberCredito'>"+ ($number +1) +"</th><td><input type='text' class='form-control dateCronograma' name='dateCronograma[]'/></td><td><input type='text' class='form-control' name='montoCronograma[]'/></td><td><div class='btn-group'><button class='btn btn-danger btnDeleteCronograma'><i class='fas fa-times'></i></button></div></td></tr>");


      $(".dateCronograma")
      .datepicker({
        format: "yyyy-mm-dd",
        weekStart: 0,
        autoClose: true,
        language: "es",
      })
      .datepicker("setDate", new Date());
  });



/*   <!-- ENTRADA PARA LA FECHA EMISION -->
                                    <div class="form-group col-md-3">
                                        <label for="dateSale">Fecha venta</label>
                                        <div class="input-group date" id="dateSale" data-target-input="nearest">
                                            <div class="input-group-append" data-target="#dateSale" data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="far fa-calendar-alt"></i></div>
                                            </div>
                                            <input type="text" class="form-control datetimepicker-input" name="dateAddSales" data-target="#dateSale" required/>
                                        </div>
                                    </div>

 */



  /* FUNCION PARA ELIMINAR EL ITEM DEL CRONOGRAMA */
  $(document).on("click", ".btnDeleteCronograma", function () {
    $fila = $(this).parent().parent().parent();
    /*console.log("consiguiendo la fila", $fila);*/
    $fila.remove();
  });

  // FUNCION PARA CONSULTA RUC
  $(document).on("click", ".consultaruc", function () {
    var document_number = $("#documentNumberAddSales").val();
    if(document_number.length == 8){
      var document_type = 1;
    }else {
      var document_type = 6;
    }

    var data = new FormData();
    data.append("document_number", document_number);
    data.append("document_type", document_type);
    $.ajax({
      url: "ajax/sales.ajax.php",
      method: "POST",
      data: data,
      cache: false,
      contentType: false,
      processData: false,
      dataType: "json",
      success: function (response) {
        if(response['tipoDocumento'] == 6){
          $("#documentTypeAddSales").val(3);
          $("#nameCustomerAddSales").val(response['nombre']);
        }else if (response['tipoDocumento'] == 1) {
          $("#documentTypeAddSales").val(1);
          $("#nameCustomerAddSales").val(response['nombre']);
        } 
        $("#phoneAddSales").val('');
        $("#emailAddSales").val('');
        $("#addressCustomerAddSales").val('');
        $("#idCustomer").val('');
      },
    });
  });
  // FUNCION PARA CONSULTA RUC DESDE EL EDIT SALES
  $(document).on("click", ".consultarucEdit", function () {
    var document_number = $("#documentNumberAddSales").val();
    if(document_number.length == 8){
      var document_type = 1;
    }else {
      var document_type = 6;
    }

    var data = new FormData();
    data.append("document_number", document_number);
    data.append("document_type", document_type);
    $.ajax({
      url: "ajax/sales.ajax.php",
      method: "POST",
      data: data,
      cache: false,
      contentType: false,
      processData: false,
      dataType: "json",
      success: function (response) {
        if(response['tipoDocumento'] == 6){
          $("#tipo_documento").val(3);
          $("#tipo_documento").html('RUC');
        }else if (response['tipoDocumento'] == 1) {
          $("#tipo_documento").val(1);
          $("#tipo_documento").html('DNI');
        }
        
        $("#nameCustomerAddSales").val(response['nombre']);
        $("#phoneAddSales").val('');
        $("#emailAddSales").val('');
        $("#tipo_cliente").val('');
        $("#tipo_cliente").html('seleccionar tipo');
        $("#addressCustomerAddSales").val('');
        $("#idCustomer").val('');


      },
    });
  });

});
