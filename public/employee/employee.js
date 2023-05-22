var Index = (function () {
  const csrf_token = $('meta[name="csrf-token"]').attr("content");

  var handleDataStatus = function () {
    $("#StatusEmp").select2({
      // minimumInputLength: 1,
      allowClear: true,
      placeholder: "pilih item status",
      dataType: "json",
      ajax: {
        method: "POST",

        url: url + "app/ajax/data-status-dropdown.php",

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
  var handleDataDepartemen = function () {
    $("#Dept").select2({
      // minimumInputLength: 1,
      allowClear: true,
      placeholder: "pilih item departemen",
      dataType: "json",
      ajax: {
        method: "POST",

        url: url + "app/ajax/data-departemen-dropdown.php",

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

  var handleStatusEmp = function () {
    $("#StatusEmp").change(function (e) {
      e.preventDefault();
      const nilai = $(this).val();

      if (nilai == 1) {
        $("#tgl_kartap").removeAttr("disabled");
        $("#tgl_kartap").val("");
      } else {
        $("#tgl_kartap").attr("disabled", "disabled");
      }
    });
  };

  var handleFormSubmit = function () {
    $("#btnBack").click(function (e) {
      e.preventDefault();
      window.location.href = url + "view/pages/employee/index.php";
    });

    handleStatusEmp();

    $("#formEmployee").submit(function (e) {
      e.preventDefault();
      const form = $(this);
      let formData = new FormData(form[0]);

      $.ajax({
        type: "POST",
        url: url + "app/ajax/employee-emp.php",
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
          let obj = response.success;

          if (obj === true) {
            $.each(response.data, function (key, value) {
              toastr.success(value);
            });
            setTimeout(() => {
              location.reload(true);
            }, 4000);
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
      handleDataStatus();
      handleDataCompany();
      handleDataDepartemen();
      handleFormSubmit();
    },
  };
})();

$(document).ready(function () {
  Index.init();
});
