$(document).ready(function () {
  /* CARGAR TABLA DINAMICA DE CLIENTES EN DATATABLES */
  $(".tableCustomers").DataTable({
    ajax: "ajax/datatable-customers.ajax.php",
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

  /* Editar un cliente existente */
  $(document).on("click", ".btnEditCustomers", function () {
    var idCustomer = $(this).attr("customersView");
    var data = new FormData();
    data.append("idCustomer", idCustomer);
    $.ajax({
      url: "ajax/customers.ajax.php",
      method: "POST",
      data: data,
      cache: false,
      contentType: false,
      processData: false,
      dataType: "json",
      success: function (response) {
        $("#idCustomer").val(response["id"]);
        $("#nameEditCustomer").val(response["names"]);
        $("#documentTypeEditCustomer").html(response["document_type"]);
        $("#documentTypeEditCustomer").val(response["id_document"]);
        $("#numberDocumentEditCustomer").val(response["document_number"]);
        $("#emailEditCustomer").val(response["email"]);
        $("#phoneEditCustomer").val(response["phone"]);
        $("#addressEditCustomer").val(response["address"]);
        $("#typeCustomerEditCustomer").val(response["customer_type"]);
        $("#typeCustomerEditCustomer").html(response["customer_type"]);
      },
    });
  });

  /* Activar o desactivar un cliente */
  $(document).on("click", ".btnActivateCustomers", function () {
    var idCustomer = $(this).attr("idCustomer");
    var statusCustomer = $(this).attr("statusCustomer");
    var data = new FormData();
    data.append("activateId", idCustomer);
    data.append("activateUser", statusCustomer);
    $.ajax({
      url: "ajax/customers.ajax.php",
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
              window.location = "users";
            }
          });
        }
      },
    });

    if (statusCustomer == 2) {
      $(this).removeClass("btn-success");
      $(this).addClass("btn-danger");
      $(this).html("Desactivado");
      $(this).attr("statusCustomer", 1);
    } else {
      $(this).addClass("btn-success");
      $(this).removeClass("btn-danger");
      $(this).html("Activado");
      $(this).attr("statusCustomer", 2);
    }
  });

  /* ELIMINAR COMPRAS NACIONALES */
  $(document).on("click", ".btnDeleteCustomers", function () {
    var idCustomers = $(this).attr("idCustomers");

    Swal.fire({
      title: "Esta seguro de eliminar el cliente?",
      icon: "warning",
      showConfirmButton: true,
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      cancelButtonText: "Cancelar",
      confirmButtonText: "Si, borrar el cliente!",
    }).then(function (result) {
      if (result.value) {
        window.location =
          "index.php?route=customers&idCustomers=" + idCustomers;
      }
    });
  });
});
