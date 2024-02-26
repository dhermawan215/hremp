var Index = (function () {
  const csrf_token = $('meta[name="csrf-token"]').attr("content");
  var handleLimitEdit = function () {
    const formValue = $("#formValue").val();
    $.ajax({
      type: "POST",
      url: url + "app/flexy-allowance/limit-reset.php",
      data: {
        _token: csrf_token,
        formValue: formValue,
      },
      dataType: "json",
      success: function (response) {
        if (response.limits !== null) {
          $("#allowance-limit").append(
            $("<option>", {
              value: response.limits,
              text: response.nama_limit,
              attr: "selected",
            })
          );
          $("#periode-saldo").append(
            $("<option>", {
              value: response.periode_saldo,
              text: response.periode_saldo,
              attr: "selected",
            })
          );

          handlPeriodeSaldo();

          $("#saldo-awal").val(response.saldo_awal);
        }
      },
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

  var handleUpdate = function () {
    $("#btnBack").click(function (e) {
      e.preventDefault();
      window.location.href = url + "view/admin-flexy/account-limit-index.php";
    });

    $("#form-reset-user-wallet").submit(function (e) {
      e.preventDefault();
      const form = $(this);
      let formData = new FormData(form[0]);

      if (confirm("Apakah Data Sudah Sesuai?!")) {
        $.ajax({
          type: "POST",
          url: url + "app/flexy-allowance/limit-reseted.php",
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

  var handlPeriodeSaldo = function () {
    var dataTahun = [];
    const tahunSekarang = new Date().getFullYear();

    for (let t = tahunSekarang; t <= tahunSekarang + 1; t++) {
      let objectTahun = { id: t, text: t };
      dataTahun.push(objectTahun);
    }
    $("#periode-saldo").select2({
      // minimumInputLength: 1,
      allowClear: true,
      placeholder: "Pilih Tahun",
      data: dataTahun,
    });
  };
  return {
    init: function () {
      handleLimitEdit();
      handleUpdate();
      handleLimit();
      handleGetDropdown();
    },
  };
})();

$(document).ready(function () {
  Index.init();
});
