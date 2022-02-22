$(document).ready(function () {
    /* Editar un modelo existente */
  $(document).on("click", ".btnEditModel", function () {
    var idModel = $(this).attr("idModel");
    var data = new FormData();
    data.append("idModel", idModel);
    $.ajax({
      url: "ajax/models.ajax.php",
      method: "POST",
      data: data,
      cache: false,
      contentType: false,
      processData: false,
      dataType: "json",
      success: function (response) {
        $("#idModel").val(response["id"]);
        $("#nameduaEditModel").val(response["name_dua"]);
        $("#nameluckiEditModel").val(response["name_lucki"]);
        $("#brandEditModel").html(response["brand"]);
        $("#brandEditModel").val(response["id_brand"]);
        $("#categoryEditModel").html(response["category"]);
        $("#categoryEditModel").val(response["id_categories"]);
      },
    });
  });

  /* Eliminar modelo */
  $(document).on("click", ".btnDeleteModel", function () {
    var idModel = $(this).attr("idModel");

    Swal.fire({
      title: "Esta seguro de eliminar el modelo?",
      icon: "warning",
      showConfirmButton: true,
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      cancelButtonText: "Cancelar",
      confirmButtonText: "Si, borrar el modelo!",
    }).then(function (result) {
      if (result.value) {
        window.location =
          "index.php?route=modelo&idModel=" +
          idModel;
      }
    });
  });
});