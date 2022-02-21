const dropArea = document.querySelector(".drag-area");
const dragText = document.querySelector("h4");
const button = document.querySelector("#photo");
const input = document.querySelector("#input-file");
const deleteImage = document.querySelector(".deleteImage");
let files;

button.addEventListener("click", (e) => {
  input.click();
});

input.addEventListener("change", (e) => {
  files = input.files;
  dropArea.classList.add("active");
  showFiles(files);
  dropArea.classList.remove("active");
});

dropArea.addEventListener("dragover", (e) => {
  e.preventDefault();
  dropArea.classList.add("active");
  dragText.textContent = "Suelta para subir los archivos";
});

dropArea.addEventListener("dragleave", (e) => {
  dropArea.classList.remove("active");
  dragText.textContent = "Suelta para subir los archivos";
});

dropArea.addEventListener("drop", (e) => {
  e.preventDefault();
  files = e.dataTransfer.files;
  showFiles(files);
  dropArea.classList.remove("active");
  dragText.textContent = "Arrastra o seleccione sus imágenes";
});

function showFiles(files) {
  if (files.length === undefined) {
    processFile(files);
  } else {
    for (const file of files) {
      processFile(file);
    }
  }
}

var fileTotal = [];
var contador = 0;

function processFile(file) {
  const docType = file.type;
  const validExntesions = ["image/jpeg", "image/jpg", "image/png"];

  if (validExntesions.includes(docType)) {
    // archivo valido
    const fileReader = new FileReader();
    const id = `file-${Math.random().toString(32).substring(7)}`;

    fileReader.addEventListener("load", (e) => {
      const fileUrl = fileReader.result;
      const image = `
                    <figure class="figure mt-3 m-2" onclick="delImage()" idCou="${contador++}">
                      <img id="${id}" src="${fileUrl}" alt="${file.name}" />
                      <div class="capa d-flex justify-content-center align-items-center">
                      <i class="fas fa-trash-alt"></i>
                      </div>
                    </figure>`;

      const html = document.querySelector("#preview").innerHTML;
      document.querySelector("#preview").innerHTML = image + html;
    });

    fileReader.readAsDataURL(file);
    fileTotal = fileTotal.concat(file);
    console.log(fileTotal);
    uploadFile(file, id);
  } else {
    // no es un archivo valido
    alert("No es un archivo valido");
  }
}

function delImage() {
  /* $(this).remove(); */
  /* const figure = document.querySelector(".figure").children();*/
  /* figure.remove(); */
  const elemento = document.getElementsByClassName("figure");
}

/* $(".figure").click(function () {
  console.log("hico clic para eliminar");
}); */

function uploadFile(file) {
  /* console.log(file); */
}

$(document).ready(function () {
  $(document).on("click", ".figure", function () {
    /* $fila = $(this).parent().parent().parent();
    console.log("consiguiendo la fila", $fila);
    $fila.remove();
    $contador = parseInt($(".numberItemGuia:last").html()); */
    const figure = $(this);

    const figureCount = $(this).attr("idCou");
    fileTotal.splice(figureCount, 1);

    console.log(fileTotal);

    figure.remove();
  });
});
