var Index = (function () {
  const csrf_token = $('meta[name="csrf-token"]').attr("content");

  //fungsi dropdown data company
  var handleDataCompany = function () {
    $("#Company").select2({
      // minimumInputLength: 1,
      allowClear: true,
      placeholder: "pilih item company",
      dataType: "json",
      ajax: {
        method: "POST",

        url: url + "app/ajax/data-company-dropdown.php",

        data: function (params) {
          return {
            search: params.term,
            page: params.page || 1, // search term
          };
        },
        processResults: function (data, params) {
          params.page = params.page || 1;
          // var datas = JSON.parse(data);
          return {
            results: data.items,
            pagination: {
              more: false,
            },
          };
        },
      },
      templateResult: format,
      templateSelection: formatSelection,
    });
  };

  function format(repo) {
    if (repo.loading) {
      return repo.text;
    }

    var $container = $(
      "<div class='select2-result-repository clearfix'>" +
        "<div class='select2-result-repository__title'></div>" +
        "</div>"
    );

    $container.find(".select2-result-repository__title").text(repo.text);
    return $container;
  }

  function formatSelection(repo) {
    return repo.text;
  }

  var handleFormSubmit = function () {
    $("#btnBack").click(function (e) {
      e.preventDefault();
      window.location.href = url + "view/pages/employee/index.php";
    });

    $("#formEmployeeMutasi").submit(function (e) {
      e.preventDefault();
      const form = $(this);
      let formData = new FormData(form[0]);

      if (confirm("Apakah Data Sudah Sesuai?!")) {
        $.ajax({
          type: "POST",
          url: url + "app/ajax/employee-mutasi.php",
          data: formData,
          processData: false,
          contentType: false,
          success: function (response) {
            let obj = response.success;

            if (obj === true) {
              toastr.success("Data Saved!");
              setTimeout(() => {
                document.location.href =
                  url +
                  "view/pages/employee/view-employee-history.php?dataId=" +
                  response.data;
              }, 4000);
            } else {
              $.each(response.data, function (key, value) {
                toastr.error(value);
              });
            }
          },
        });
      }
    });
  };

  // fungsi ambil data karyawan
  var handleGetKaryawan = function () {
    const karyawan = $("#emp_id").val();
    $.ajax({
      type: "POST",
      url: url + "app/ajax/emp-employee-mutasi.php",
      async: false,
      data: {
        karyawan: karyawan,
        _token: csrf_token,
      },
      //   processData: false,
      //   contentType: false,
      success: function (response) {
        $("#karyawanName").html(response.nama);
        $("#periode_masuk").val(response.tgl_masuk);
        $("#jabatan").val(response.jabatan);

        $("#Company").append(
          $("<option>", {
            value: response.company,
            text: response.company_name,
            attr: "selected",
          })
        );
      },
    });
  };
  return {
    init: function () {
      handleDataCompany();
      handleFormSubmit();
      handleGetKaryawan();
    },
  };
})();

$(document).ready(function () {
  Index.init();
});
