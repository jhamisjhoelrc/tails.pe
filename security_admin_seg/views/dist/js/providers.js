$(document).ready(function () {
  /* Editar un proveedor existente */
  $(document).on("click", ".btnEditProvider", function () {
    var idProvider = $(this).attr("idProvider");
    var data = new FormData();
    data.append("idProvider", idProvider);
    $.ajax({
      url: "ajax/providers.ajax.php",
      method: "POST",
      data: data,
      cache: false,
      contentType: false,
      processData: false,
      dataType: "json",
      success: function (response) {
        $("#idProvider").val(response["id"]);
        $("#nameEditProvider").val(response["name"]);
        $("#documentTypeEditProvider").val(response["id_document"]);
        $("#documentTypeEditProvider").html(response["document"]);
        $("#numberDocumentEditProvider").val(response["document_number"]);
        $("#providerTypeEditProvider").val(response["provider_type"]);
        $("#providerTypeEditProvider").html(response["provider_type"]);
        $("#addressEditProvider").val(response["address"]);
        $("#emailEditProvider").val(response["email"]);
        $("#phoneEditProvider").val(response["phone"]);
      },
    });
  });

  /* Eliminar proveedor */
  $(document).on("click", ".btnDeleteProvider", function () {
    var idProvider = $(this).attr("idProvider");

    Swal.fire({
      title: "Esta seguro de eliminar el proveedor?",
      icon: "warning",
      showConfirmButton: true,
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      cancelButtonText: "Cancelar",
      confirmButtonText: "Si, borrar el proveedor!",
    }).then(function (result) {
      if (result.value) {
        window.location = "index.php?route=providers&idProvider=" + idProvider;
      }
    });
  });
});
