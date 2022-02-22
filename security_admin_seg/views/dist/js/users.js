$(document).ready(function () {
  /* Validar email repetido */
  $("#addUserEmail").change(function () {
    $(".invalid-feedback").remove();
    $("#addUserEmail").removeClass("is-invalid");

    var userEmail = $(this).val();
    var data = new FormData();
    data.append("userEmail", userEmail);
    $.ajax({
      url: "ajax/users.ajax.php",
      method: "POST",
      data: data,
      cache: false,
      contentType: false,
      processData: false,
      dataType: "json",
      success: function (response) {
        if (response) {
          $("#addUserEmail").addClass("is-invalid");
          $("#addUserEmail").after(
            '<div class="invalid-feedback">El email ya existe</div>'
          );
          $("#addUserEmail").val("");
        }
      },
    });
  });

  /* subiendo nueva foto de usuario */
  $(".newPhoto").change(function () {
    var image = this.files[0];

    //validación de formato imaggen
    if (image["type"] != "image/jpeg" && image["type"] != "image/png") {
      $(".newPhoto").val("");
      Swal.fire({
        icon: "error",
        title: "Error al subir la imagen",
        text: "La imagen debe estar en formato JPG o PNG!",
        confirmButtonText: "Cerrar",
      });
    } else if (image["size"] > 2000000) {
      $(".newPhoto").val("");
      Swal.fire({
        icon: "error",
        title: "Error al subir la imagen",
        text: "La imagen no debe superar más de 2MB!",
        confirmButtonText: "Cerrar",
      });
    } else {
      var dataImagen = new FileReader();
      dataImagen.readAsDataURL(image);

      $(dataImagen).on("load", function (event) {
        var ruteImage = event.target.result;
        $(".preview").attr("src", ruteImage);
      });
    }
  });

  /* Activar o desactivar un usuario */
  $(document).on("click", ".btnActivateUser", function () {
    var idUser = $(this).attr("idUser");
    var statusUser = $(this).attr("statusUser");
    var data = new FormData();
    data.append("activateId", idUser);
    data.append("activateUser", statusUser);
    $.ajax({
      url: "ajax/users.ajax.php",
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

    if (statusUser == 2) {
      $(this).removeClass("btn-success");
      $(this).addClass("btn-danger");
      $(this).html("Desactivado");
      $(this).attr("statusUser", 1);
    } else {
      $(this).addClass("btn-success");
      $(this).removeClass("btn-danger");
      $(this).html("Activado");
      $(this).attr("statusUser", 2);
    }
  });

  /* Editar un usuario existente */
  $(document).on("click", ".btnEditUser", function () {
    var idUser = $(this).attr("idUser");
    var data = new FormData();
    data.append("idUser", idUser);
    $.ajax({
      url: "ajax/users.ajax.php",
      method: "POST",
      data: data,
      cache: false,
      contentType: false,
      processData: false,
      dataType: "json",
      success: function (response) {
        $("#nameEditUser").val(response["names"]);
        $("#lastNameEditUser").val(response["last_name"]);
        $("#emailEditUser").val(response["email"]);
        $("#phoneEditUser").val(response["phone"]);
        $("#documentTypeEditUser").html(response["document"]);
        $("#documentTypeEditUser").val(response["id_document"]);
        $("#numberDocumentEditUser").val(response["document_number"]);
        $("#profileEditUser").html(response["profile"]);
        $("#profileEditUser").val(response["id_profile"]);
        $("#subsidiaryEditUser").html(response["subsidiary"]);
        $("#subsidiaryEditUser").val(response["id_subsidiary"]);
        $("#passwordPresent").val(response["password"]);
        $("#photoPresent").val(response["photo"]);
        if (response["photo"] != "") {
          $(".preview").attr("src", response["photo"]);
        }
      },
    });
  });

  /* Eliminar usuario */
  $(document).on("click", ".btnDeleteUser", function () {
    var idUser = $(this).attr("idUser");
    var photo = $(this).attr("photo");
    var email = $(this).attr("email");

    Swal.fire({
      title: "Esta seguro de eliminar el usuario?",
      icon: "warning",
      showConfirmButton: true,
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      cancelButtonText: "Cancelar",
      confirmButtonText: "Si, borrar el usuario!",
    }).then(function (result) {
      if (result.value) {
        window.location =
          "index.php?route=users&idUser=" +
          idUser +
          "&email=" +
          email +
          "&photo=" +
          photo;
      }
    });
  });
});
