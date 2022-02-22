$(document).ready(function () {
  $(".tablas").DataTable({
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

  /* Inicializando select2 en bootstrap */
  $(".select2bs4").select2({
    theme: "bootstrap4",
  });

  /* Autocomplete */
  autocomplete = document.querySelectorAll("[autocomplete=off]");
  if ((autocomplete.tagName = "FORM"))
    autocomplete = document.querySelectorAll("input");

  if (autocomplete.length) {
    var elm = document.getElementById("autocomplete") || {};
    if (elm.name == "autocomplete") {
      elm.addEventListener("change", setAutocomplete);
      // elm.checked = ( "true" === localStorage.getItem( 'autocomplete' ) );
    }
    setAutocomplete(elm);
  }

  function setAutocomplete(elm) {
    elm = elm.target || elm;
    // if ( elm.name == "autocomplete" )
    //  localStorage.setItem('autocomplete', elm.defaultChecked = elm.checked);

    if (!elm.checked) {
      autocomplete.forEach(function (elm) {
        elm.oldReadOnly = elm.readOnly;
        elm.readOnly = true;
        elm.value = elm.defaultValue;
      });
      setTimeout(function () {
        autocomplete.forEach(function (elm) {
          elm.readOnly = elm.oldReadOnly;
        });
      }, 1000);
    }
  }

  /* Inicializando fecha venta date picker */
  $("#datePicker")
    .datepicker({
      format: "yyyy-mm-dd",
      weekStart: 0,
      autoClose: true,
      language: "es",
    })
    .datepicker("setDate", new Date());

  /* Inicializando fecha venta date picker */
  $("#dateSale")
    .datepicker({
      format: "yyyy-mm-dd",
      weekStart: 0,
      autoClose: true,
      language: "es",
    })
    .datepicker("setDate", new Date());

    $("#dateEditSale").datepicker({
      format: "yyyy-mm-dd",
      weekStart: 0,
      autoClose: true,
      language: "es",
    });

    /* Inicializando fecha crongorama negociales date picker */
  $(".dateCronograma")
  .datepicker({
    format: "yyyy-mm-dd",
    weekStart: 0,
    autoClose: true,
    language: "es",
  })
  .datepicker("setDate", new Date());

  $(".dateEditCronograma").datepicker({
    format: "yyyy-mm-dd",
    weekStart: 0,
    autoClose: true,
    language: "es",
  });


  /* Inicializando fecha invoice date picker */
  $("#dateInvoice")
    .datepicker({
      format: "yyyy-mm-dd",
      weekStart: 0,
      autoClose: true,
      language: "es",
    })
    .datepicker("setDate", new Date());

  $("#dateEditInvoice").datepicker({
    format: "yyyy-mm-dd",
    weekStart: 0,
    autoClose: true,
    language: "es",
  });
  /* Inicializando fecha zarpe callao date picker */
  $("#dateZarpe")
    .datepicker({
      format: "yyyy-mm-dd",
      weekStart: 0,
      autoClose: true,
      language: "es",
    })
    .datepicker("setDate", new Date());
  $("#dateEditZarpe").datepicker({
    format: "yyyy-mm-dd",
    weekStart: 0,
    autoClose: true,
    language: "es",
  });
  /* Inicializando fecha arribo callao date picker */
  $("#dateArribo")
    .datepicker({
      format: "yyyy-mm-dd",
      weekStart: 0,
      autoClose: true,
      language: "es",
    })
    .datepicker("setDate", new Date());
  $("#dateEditArribo").datepicker({
    format: "yyyy-mm-dd",
    weekStart: 0,
    autoClose: true,
    language: "es",
  });
  /* Inicializando fecha numeración date picker */
  $("#dateNumeration")
    .datepicker({
      format: "yyyy-mm-dd",
      weekStart: 0,
      autoClose: true,
      language: "es",
    })
    .datepicker("setDate", new Date());
  $("#dateEditNumeration").datepicker({
    format: "yyyy-mm-dd",
    weekStart: 0,
    autoClose: true,
    language: "es",
  });
  /* Inicializando fecha emision date picker */
  $("#dateEmision")
    .datepicker({
      format: "yyyy-mm-dd",
      weekStart: 0,
      autoClose: true,
      language: "es",
    })
    .datepicker("setDate", new Date());
  $("#dateEditEmision").datepicker({
    format: "yyyy-mm-dd",
    weekStart: 0,
    autoClose: true,
    language: "es",
  });
  /* Inicializando fecha llegada date picker */
  $("#dateLlegada")
    .datepicker({
      format: "yyyy-mm-dd",
      weekStart: 0,
      autoClose: true,
      language: "es",
    })
    .datepicker("setDate", new Date());
  $("#dateEditLlegada").datepicker({
    format: "yyyy-mm-dd",
    weekStart: 0,
    autoClose: true,
    language: "es",
  });

  /* Inicializando fecha inicio traslado date picker */
  $("#dateInicioTraslado")
    .datepicker({
      format: "yyyy-mm-dd",
      weekStart: 0,
      autoClose: true,
      language: "es",
    })
    .datepicker("setDate", new Date());
  $("#dateEditInicioTraslado").datepicker({
    format: "yyyy-mm-dd",
    weekStart: 0,
    autoClose: true,
    language: "es",
  });
});
