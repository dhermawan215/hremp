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
  var handleDropdownCompany = function () {
    $("#company").select2({
      // minimumInputLength: 1,
      allowClear: true,
      placeholder: "Select company/Type company name",
      dataType: "json",
      ajax: {
        method: "POST",

        url: url + "app/ajax/data-company-dropdown.php",

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
    getCostCenter();
  };
  // ada bug jika di clear company dropdown, ajax get cost center terkirim
  var handleResetCompanydropdwon = function () {
    $("#company").on("select2:unselecting", function (e) {
      $("#cost-center").empty();
      $("#department").empty();
      toastr.success("reset selection success");
      $("#cost-center").select2({
        placeholder: "Select cost center/Type cost center name",
      });
      $("#department").select2({
        placeholder: "Select department/Type department name",
      });
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

  var getCostCenter = function () {
    $("#company").change(function (e) {
      e.preventDefault();
      const companyId = $(this).val();
      $.ajax({
        type: "post",
        url: url + "app/flexy-allowance/allowance-request-route.php",
        data: {
          company: companyId,
          _token: csrf_token,
          action: "get-cost-center",
        },
        dataType: "json",
        success: function (response) {
          const responseValue = response.item;
          // Check if the new data is different from the current data
          if (!arraysEqual(responseValue, $("#cost-center").select2())) {
            // Clear existing options
            $("#cost-center").empty();

            // Populate Select2 dropdown with new data
            $("#cost-center").select2({
              data: responseValue,
            });
          }
          getCostCenterDepartment();
        },
      });
    });
  };
  var getCostCenterDepartment = function () {
    $("#cost-center").change(function (e) {
      e.preventDefault();
      const costCenterId = $(this).val();
      $.ajax({
        type: "post",
        url: url + "app/flexy-allowance/allowance-request-route.php",
        data: {
          costcenter: costCenterId,
          _token: csrf_token,
          action: "get-cost-center-department",
        },
        dataType: "json",
        success: function (response) {
          const responseValue = response.item;
          // Check if the new data is different from the current data
          if (!arraysEqual(responseValue, $("#department").select2())) {
            // Clear existing options
            $("#department").empty();

            // Populate Select2 dropdown with new data
            $("#department").select2({
              data: responseValue,
            });
          }
        },
      });
    });
  };

  // Function to check if two arrays are equal
  function arraysEqual(arr1, arr2) {
    if (arr1.length !== arr2.length) return false;
    for (var i = 0; i < arr1.length; i++) {
      if (arr1[i].id !== arr2[i].id || arr1[i].text !== arr2[i].text)
        return false;
    }
    return true;
  }

  var handleSelect2 = function () {
    $("#cost-center").select2({
      placeholder: "Select cost center/Type cost center name",
    });
    $("#department").select2({
      placeholder: "Select department/Type department name",
    });
  };

  return {
    init: function () {
      handleSubmitAllowance();
      handleAllowanceNumber();
      handleDropdownCompany();
      handleSelect2();
      handleResetCompanydropdwon();
    },
  };
})();

$(document).ready(function () {
  Index.init();
});
