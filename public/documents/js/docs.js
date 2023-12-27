var Index = (function () {
  const csrf_token = $('meta[name="csrf-token"]').attr("content");
  var table;

  var isMobile = window.matchMedia(
    "only screen and (max-width: 767px)"
  ).matches;

  var handleDataCompany = function () {
    table = $("#tableDocs").DataTable({
      responsive: true,
      autoWidth: true,
      pageLength: 10,
      searching: true,
      paging: true,
      lengthMenu: [
        [10, 25, 50],
        [10, 25, 50],
      ],
      language: {
        info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
        infoEmpty: "Menampilkan 0 - 0 dari 0 data",
        infoFiltered: "",
        zeroRecords: "Data tidak di temukan",
        loadingRecords: "Loading...",
        processing: "Processing...",
      },
      columnsDefs: [
        { searchable: false, target: [0, 1] },
        { orderable: false, target: 0 },
      ],
      processing: true,
      serverSide: true,
      ajax: {
        url: url + "app/ajax/documents-data.php",
        type: "POST",
        data: {
          _token: csrf_token,
        },
      },
      columns: [
        { data: "rnum", orderable: false },
        { data: "name", orderable: false },
        { data: "upload_time", orderable: false },
        { data: "action", orderable: false },
      ],
    });
    if (isMobile) {
      $("#tableDocs tbody").on("click", "tr", function () {
        handleShowPdfinMobile(table.row(this).data());
        // console.log(table.row(this).data());
      });
    } else {
      $("#tableDocs tbody").on("click", "tr", function () {
        // console.log(table.row(this).data());
        handleShowPdfinDesktop(table.row(this).data());
      });
    }
  };

  var handleShowPdfinMobile = function (param) {
    const pathMobile = param.path;
    const nameMobile = param.name;
    const pathMobileDownload = param.path;

    $(document).on("click", "#btnShowDocs", function () {
      $("#docsName").html(nameMobile);
      $("#downloadDocs").attr("href", pathMobileDownload);
      // $("#pdfObject").attr("src", param.path);

      // Create either <iframe> or <object> based on device type

      pdfElement =
        "<iframe src=" +
        pathMobile +
        ' type="application/pdf" width="100%" height="350px"></iframe>';

      $("#pdfContainer").html(pdfElement);
    });
  };

  var handleShowPdfinDesktop = function (param) {
    $("#docsName").html(param.name);
    $("#downloadDocs").attr("href", param.path);
    // $("#pdfObject").attr("src", param.path);

    // Create either <iframe> or <object> based on device type

    pdfElement =
      "<object data=" +
      param.path +
      ' type="application/pdf" width="100%" height="350px"></object>';

    $("#pdfContainer").html(pdfElement);
  };

  var handleDelete = function () {
    $(document).on("click", ".btndel", function () {
      const id = $(this).data("id");
      Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!",
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            type: "POST",
            url: url + "/app/ajax/documents-delete.php",
            data: {
              _token: csrf_token,
              ids: id,
            },
            success: function (response) {
              if (response.success === true) {
                Swal.fire("Deleted!", "Your file has been deleted.", "success");
                table.ajax.reload();
              } else {
                Swal.fire({
                  icon: "error",
                  title: "Oops...",
                  text: "Internal Server Error",
                });
              }
            },
            error: function (response) {
              // Swal.fire({
              //   icon: "error",
              //   title: "Oops...",
              //   text: "Internal Server Error",
              // });
            },
          });
        }
      });
    });
  };

  var handleSubmitForm = function () {
    $("#formUploadDoc").submit(function (e) {
      e.preventDefault();

      const form = $(this);
      let formData = new FormData(form[0]);

      $.ajax({
        type: "POST",
        url: url + "app/ajax/documents-upload.php",
        data: formData,
        processData: false,
        contentType: false,
        Cache: false,
        success: function (response) {
          let obj = response.success;

          if (obj === true) {
            $.each(response.data, function (key, value) {
              toastr.success(value);
            });
            setTimeout(() => {
              location.reload();
            }, 2000);
          } else {
            $.each(response.data, function (key, value) {
              toastr.error(value);
            });
          }
        },
      });
    });
  };

  return {
    init: function () {
      handleDataCompany();
      handleDelete();
      handleSubmitForm();
    },
  };
})();

$(document).ready(function () {
  Index.init();
});
