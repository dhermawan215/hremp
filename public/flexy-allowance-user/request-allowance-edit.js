var Index = (function () {
  const csrf_token = $('meta[name="csrf-token"]').attr("content");

  var getEditAllowance = function () {
    $.ajax({
      type: "POST",
      url: url + "app/flexy-allowance/allowance-request-route.php",
      data: {
        _token: csrf_token,
        action: "edit",
        nomer: noAllowance,
      },
      dataType: "json",
      success: function (response) {
        $("#formValue").val(response.allowance);
        $("#nomer-allowance").val(response.nomer);
        $("#transaction-date").val(response.transaction_date);
        $("#request-allowance").val(response.subject);

        $("#periode").append(
          $("<option>", {
            value: response.period,
            text: response.period,
            attr: "selected",
          })
        );
        $("#company").append(
          $("<option>", {
            value: response.company,
            text: response.company_name,
            attr: "selected",
          })
        );
        $("#cost-center").append(
          $("<option>", {
            value: response.cost_center,
            text: response.cost_center_name,
            attr: "selected",
          })
        );
        $("#department").append(
          $("<option>", {
            value: response.dept,
            text: response.dept_name,
            attr: "selected",
          })
        );
      },
    });
  };

  var handleUpdateAllowance = function () {
    $("#form-edit-user-wallet").submit(function (e) {
      e.preventDefault();
      const form = $(this);
      let formData = new FormData(form[0]);
      formData.append("action", "update");

      if (confirm("Is it correct?")) {
        $.ajax({
          type: "POST",
          url: url + "app/flexy-allowance/allowance-request-route.php",
          data: formData,
          processData: false,
          contentType: false,
          success: function (response) {
            toastr.success(response.data);
            setTimeout(() => {
              window.location.href =
                url + "view/flexy-allowance/allowance-user-index.php";
            }, 3500);
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
      // saat onchange jika data di edit maka reset dropdown
      $("#cost-center").empty();
      $("#department").empty();
      $("#cost-center").select2({
        placeholder: "Select cost center/Type cost center name",
      });
      $("#department").select2({
        placeholder: "Select department/Type department name",
      });
      // baru nanti menjalankan aajx request
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

  var handlePeriodEdit = function () {
    var dataPeriod = [];

    var currentYear = new Date().getFullYear();

    for (var index = currentYear; index <= currentYear; index++) {
      var yearLoop = dataPeriod.push({ id: index, text: index });
    }
    // console.log(dataPeriod);
    $("#periode").select2({
      data: dataPeriod,
    });
  };
  return {
    init: function () {
      handleUpdateAllowance();
      handleDropdownCompany();
      handleSelect2();
      handleResetCompanydropdwon();
      getEditAllowance();
      handlePeriodEdit();
    },
  };
})();

$(document).ready(function () {
  Index.init();
});
