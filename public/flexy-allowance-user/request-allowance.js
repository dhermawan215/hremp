var Index = (function () {
  const csrf_token = $('meta[name="csrf-token"]').attr("content");

  var handleSubmitAllowance = function () {
    $("#form-add-user-wallet").submit(function (e) {
      e.preventDefault();
      const form = $(this);
      let formData = new FormData(form[0]);

      if (confirm("Apakah data sudah sesuai?")) {
        $.ajax({
          type: "POST",
          url: url + "app/flexy-allowance/allowance-request-submit.php",
          data: formData,
          processData: false,
          contentType: false,
          success: function (response) {
            toastr.success(response.data);
            toastr.success(response.content);
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

  var handleAllowanceNumber = function () {
    $.ajax({
      type: "post",
      url: url + "app/flexy-allowance/allowance-request-callback.php",
      data: {
        _token: csrf_token,
      },
      dataType: "json",
      success: function (response) {
        $("#nomer-allowance").val(response.newAllowanceNo);
      },
    });
  };

  //codingan ambil dropdown departemen
  var handleDropdownDepartemen = function () {
    $("#departemen").select2({
      // minimumInputLength: 1,
      allowClear: true,
      placeholder: "Type Department",
      dataType: "json",
      ajax: {
        method: "POST",

        url: url + "app/flexy-allowance/allowance-request-departemen.php",

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
              more: true,
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
  return {
    init: function () {
      handleSubmitAllowance();
      handleAllowanceNumber();
      handleDropdownDepartemen();
    },
  };
})();

$(document).ready(function () {
  Index.init();
});
