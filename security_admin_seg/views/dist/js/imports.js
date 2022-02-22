$(document).ready(function () {
  /* CARGAR TABLA DINAMICA DE IMPORT EN DATATABLES */
  $(".tableImport").DataTable({
    ajax: "ajax/datatable-import.ajax.php",
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

  /* FUNCION PARA VERIFICAR SI EL CHECK AGREGAR NUMERO INVOICE ESTA SELECCIONADO */
  $("#addNumberInvoice").change(function () {
    let addNumberinvoice = $("#addNumberInvoice").is(":checked");
    if (addNumberinvoice) {
      $(".numberInvoiceAddImport").removeClass("d-none");
    } else {
      $(".numberInvoiceAddImport").addClass("d-none");
    }
  });

  /* FUNCION PARA VERIFICAR SI EL PROVEEDOR ES POMO PARA AGREGAR CODIGO CHINA */
  $("#providerAddImport").change(function () {
    let provider = $(this).val();

    if (provider == 1) {
      $(".codeChine").removeClass("d-none");
    } else {
      $(".codeChine").addClass("d-none");
    }
  });

  /* FUNCION PARA CALCULAR AUTOMÁTICAMENTE EL PRECIO TOTAL DAM */
  $(document).on("focusout", "#damMoto", function () {
    damMoto = $(this).val();
    damRepuesto = $("#damRepuesto").val();
    let numeroDamMoto = Number(damMoto);
    let numeroDamRepuesto = Number(damRepuesto);

    let totalDam = numeroDamMoto + numeroDamRepuesto;
    $("#damTotal").val(totalDam.toFixed(2));
    calcularDiferencia();
  });
  $(document).on("focusout", "#damRepuesto", function () {
    damRepuesto = $(this).val();
    damMoto = $("#damMoto").val();
    let numeroDamMoto = Number(damMoto);
    let numeroDamRepuesto = Number(damRepuesto);

    let totalDam = numeroDamMoto + numeroDamRepuesto;
    $("#damTotal").val(totalDam.toFixed(2));
    calcularDiferencia();
  });

  /* FUNCION PARA CALCULAR AUTOMÁTICAMENTE EL PRECIO TOTAL REAL */
  $(document).on("focusout", "#realMoto", function () {
    realMoto = $(this).val();
    realRepuesto = $("#realRepuesto").val();
    let numeroRealMoto = Number(realMoto);
    let numeroRealRepuesto = Number(realRepuesto);

    let totalReal = numeroRealMoto + numeroRealRepuesto;
    $("#realTotal").val(totalReal.toFixed(2));
    calcularDiferencia();
  });
  $(document).on("focusout", "#realRepuesto", function () {
    realRepuesto = $(this).val();
    realMoto = $("#realMoto").val();
    let numeroRealMoto = Number(realMoto);
    let numeroRealRepuesto = Number(realRepuesto);

    let totalReal = numeroRealMoto + numeroRealRepuesto;
    $("#realTotal").val(totalReal.toFixed(2));
    calcularDiferencia();
  });
  // FUNCION PARA CALCULAR LA DIFERENCIA
  function calcularDiferencia() {
    let damTotal = Number($("#damTotal").val());
    let realTotal = Number($("#realTotal").val());
    let calcular = damTotal - realTotal;
    $("#diferent").val(calcular.toFixed(2));
  }

  // EDITAR IMPORTACIONES
  $(document).on("click", ".btnEditImport", function () {
    var importsView = $(this).attr("importsView");
    window.location = "index.php?route=editImports&importsView=" + importsView;
  });

  // VISUALIZAR IMPORTACIONES
  $(document).on("click", ".btnShowImport", function () {
    $(".bodyShow").empty();
    var idImport = $(this).attr("idImport");
    var provider = $(this).attr("provider");
    var subsidiary = $(this).attr("subsidiary");
    var data = new FormData();
    data.append("idImport", idImport);
    $.ajax({
      url: "ajax/imports.ajax.php",
      method: "POST",
      data: data,
      cache: false,
      contentType: false,
      processData: false,
      dataType: "json",
      success: function (response) {
        $("#nameProviderImport").val(provider);
        $("#subsidiaryImport").val(subsidiary);

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

  /* ELIMINAR IMPORTACIONES */
  $(document).on("click", ".btnDeleteImport", function () {
    var idImport = $(this).attr("idImport");

    Swal.fire({
      title: "Esta seguro de eliminar la importación?",
      icon: "warning",
      showConfirmButton: true,
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      cancelButtonText: "Cancelar",
      confirmButtonText: "Si, borrar la importación!",
    }).then(function (result) {
      if (result.value) {
        window.location = "index.php?route=imports&idImport=" + idImport;
      }
    });
  });
});
