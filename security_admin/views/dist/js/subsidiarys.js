$(document).ready(function () {
  /* Conseguir la datos del ubigeo */
  $(".districtSubsidiary").change(function () {
    var idDistrict = $(this).val();
    var data = new FormData();
    data.append("idDistrict", idDistrict);
    $.ajax({
      url: "ajax/subsidiarys.ajax.php",
      method: "POST",
      data: data,
      cache: false,
      contentType: false,
      processData: false,
      dataType: "json",
      success: function (response) {
        $(".provinceSubsidiary").val(response["province"]);
        $(".departmentSubsidiary").val(response["department"]);
      },
    });
  });

  /* Editar una sucursal existente */
  $(document).on("click", ".btnEditSubsidiary", function () {
    var idSubsidiary = $(this).attr("idSubsidiary");
    var data = new FormData();
    data.append("idSubsidiary", idSubsidiary);
    $.ajax({
      url: "ajax/subsidiarys.ajax.php",
      method: "POST",
      data: data,
      cache: false,
      contentType: false,
      processData: false,
      dataType: "json",
      success: function (response) {
        $("#idSubsidiary").val(response["id"]);
        $("#descriptionEditSubsidiary").val(response["description"]);
        $("#addressEditSubsidiary").val(response["address"]);
        $("#phoneEditSubsidiary").val(response["phone"]);
        $("#responsibleEditSubsidiary").val(response["responsible"]);
        $("#districtEditSubsidiary").val(response["id_district"]);
        $("#districtEditSubsidiary").html(response["district"]);
        $(".provinceSubsidiary").val(response["province"]);
        $(".departmentSubsidiary").val(response["department"]);
      },
    });
  });

  /* Eliminar sucursal */
  $(document).on("click", ".btnDeleteSubsidiary", function () {
    var idSubsidiary = $(this).attr("idSubsidiary");

    Swal.fire({
      title: "Esta seguro de eliminar la sucursal?",
      icon: "warning",
      showConfirmButton: true,
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      cancelButtonText: "Cancelar",
      confirmButtonText: "Si, borrar la sucursal!",
    }).then(function (result) {
      if (result.value) {
        window.location =
          "index.php?route=subsidiarys&idSubsidiary=" + idSubsidiary;
      }
    });
  });
});
