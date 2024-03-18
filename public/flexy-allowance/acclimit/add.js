var Index = (function () {
  const csrf_token = $('meta[name="csrf-token"]').attr("content");
  var handleDataEmp = function () {
    $("#nama-karyawan").select2({
      // minimumInputLength: 1,
      allowClear: true,
      placeholder: "Pilih Karyawan",
      dataType: "json",
      ajax: {
        method: "POST",

        url: url + "app/flexy-allowance/user-employee.php",

        data: function (params) {
          return {
            _token: csrf_token,
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
  var handleLimit = function () {
    $("#allowance-limit").select2({
      // minimumInputLength: 1,
      allowClear: true,
      placeholder: "Pilih Limit",
      dataType: "json",
      ajax: {
        method: "POST",

        url: url + "app/flexy-allowance/limit-dropdown.php",

        data: function (params) {
          return {
            _token: csrf_token,
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
      window.location.href = url + "view/admin-flexy/account-limit-index.php";
    });

    $("#form-add-user-wallet").submit(function (e) {
      e.preventDefault();
      const form = $(this);
      let formData = new FormData(form[0]);

      if (confirm("Is it correct?")) {
        $.ajax({
          type: "POST",
          url: url + "app/flexy-allowance/limit-submit.php",
          data: formData,
          processData: false,
          contentType: false,
          success: function (response) {
            let obj = response.success;

            if (obj === true) {
              toastr.success(response.data);

              setTimeout(() => {
                document.location.href =
                  url + "view/admin-flexy/account-limit-index.php";
              }, 3500);
            }
          },
          error: function (response) {
            $.each(response.responseJSON.data, function (key, value) {
              toastr.error(value);
            });
          },
        });
      }
    });
  };

  var handleGetDropdown = function () {
    $("#allowance-limit").change(function (e) {
      e.preventDefault();
      const valueDropdown = $(this).val();
      $.ajax({
        type: "post",
        url: url + "app/flexy-allowance/limit-callback.php",
        data: {
          _token: csrf_token,
          limit: valueDropdown,
        },
        dataType: "json",
        success: function (response) {
          $("#saldo-awal").val(response.saldo_limit);
        },
      });
    });
  };
  return {
    init: function () {
      handleDataEmp();
      handleFormSubmit();
      handleLimit();
      handleGetDropdown();
    },
  };
})();

$(document).ready(function () {
  Index.init();
});
