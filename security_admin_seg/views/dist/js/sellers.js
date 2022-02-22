$(document).ready(function () {
  /* Validar n° documento repetido */
  $("#numberDocumentEditSeller").change(function () {
    $(".invalid-feedback").remove();
    $("#numberDocumentEditSeller").removeClass("is-invalid");

    var numberDocumentSeller = $(this).val();
    var data = new FormData();
    data.append("numberDocumentSeller", numberDocumentSeller);
    $.ajax({
      url: "ajax/sellers.ajax.php",
      method: "POST",
      data: data,
      cache: false,
      contentType: false,
      processData: false,
      dataType: "json",
      success: function (response) {
        if (response) {
          $("#numberDocumentEditSeller").addClass("is-invalid");
          $("#numberDocumentEditSeller").after(
            '<div class="invalid-feedback">El n° documento ya existe</div>'
          );
          $("#numberDocumentEditSeller").val("");
        }
      },
    });
  });

  /* Activar o desactivar un vendedor */
  $(document).on("click", ".btnActivateSeller", function () {
    var idSeller = $(this).attr("idSeller");
    var statusSeller = $(this).attr("statusSeller");
    var data = new FormData();
    data.append("activateId", idSeller);
    data.append("activateSeller", statusSeller);
    $.ajax({
      url: "ajax/sellers.ajax.php",
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
              window.location = "sellers";
            }
          });
        }
      },
    });

    if (statusSeller == 2) {
      $(this).removeClass("btn-success");
      $(this).addClass("btn-danger");
      $(this).html("Desactivado");
      $(this).attr("statusSeller", 1);
    } else {
      $(this).addClass("btn-success");
      $(this).removeClass("btn-danger");
      $(this).html("Activado");
      $(this).attr("statusSeller", 2);
    }
  });

  /* Editar un vendedor existente */
  $(document).on("click", ".btnEditSeller", function () {
    var idSeller = $(this).attr("idSeller");
    var data = new FormData();
    data.append("idSeller", idSeller);
    $.ajax({
      url: "ajax/sellers.ajax.php",
      method: "POST",
      data: data,
      cache: false,
      contentType: false,
      processData: false,
      dataType: "json",
      success: function (response) {
        $("#nameEditSeller").val(response["names"]);
        $("#emailEditSeller").val(response["email"]);
        $("#phoneEditSeller").val(response["phone"]);
        $("#documentTypeEditSeller").html(response["document"]);
        $("#documentTypeEditSeller").val(response["id_document"]);
        $("#numberDocumentEditSeller").val(response["document_number"]);
      },
    });
  });

  /* Eliminar vendedor */
  $(document).on("click", ".btnDeleteSeller", function () {
    var idSeller = $(this).attr("idSeller");

    Swal.fire({
      title: "Esta seguro de eliminar el vendedor?",
      icon: "warning",
      showConfirmButton: true,
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      cancelButtonText: "Cancelar",
      confirmButtonText: "Si, borrar el vendedor!",
    }).then(function (result) {
      if (result.value) {
        window.location = "index.php?route=sellers&idSeller=" + idSeller;
      }
    });
  });
});
