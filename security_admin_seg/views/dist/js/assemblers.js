$(document).ready(function () {
    /* Editar un ensamblador existente */
  $(document).on("click", ".btnEditAssembler", function () {
    var idAssembler = $(this).attr("idAssembler");
    var data = new FormData();
    data.append("idAssembler", idAssembler);
    $.ajax({
      url: "ajax/assemblers.ajax.php",
      method: "POST",
      data: data,
      cache: false,
      contentType: false,
      processData: false,
      dataType: "json",
      success: function (response) {
        $("#idAssembler").val(response["id"]);
        $("#namesEditAssembler").val(response["names"]);
      },
    });
  });

  /* Eliminar ensambladores */
  $(document).on("click", ".btnDeleteAssembler", function () {
    var idAssembler = $(this).attr("idAssembler");

    Swal.fire({
      title: "Esta seguro de eliminar el ensamblador?",
      icon: "warning",
      showConfirmButton: true,
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      cancelButtonText: "Cancelar",
      confirmButtonText: "Si, borrar el ensamblador!",
    }).then(function (result) {
      if (result.value) {
        window.location =
          "index.php?route=assemblers&idAssembler=" +
          idAssembler;
      }
    });
  });
});