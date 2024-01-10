var Index = (function () {
  const csrf_token = $('meta[name="csrf-token"]').attr("content");
  const idFrom = $("#emp_id").val();

  var getDataEmployee = function () {
    var results;
    $.ajax({
      type: "POST",
      url: url + "app/ajax/emp-personal-payroll.php",
      async: false,
      data: {
        id: idFrom,
        _token: csrf_token,
      },
      //   processData: false,
      //   contentType: false,
      success: function (response) {
        // let obj = response.success;
        $("#account").attr("disabled", "disabled");
        $("#payroll_name").attr("disabled", "disabled");
        $("#btnUpdate").attr("disabled", "disabled");

        if (response.data_index === null) {
          alert("Data payroll kosong!");
          $("#btnAddPayrollNull").removeAttr("disabled", "disabled");

          // console.log(response.data_index);
        } else {
          $("#btnAddPayrollNull").attr("disabled", "disabled");
          results = response;
          $("#karyawanName").html(results.nama);
          $("#account").val(results.account);
          $("#payroll_name").val(results.payroll_name);
          $("#idData").val(results.data_index);

          handleIsEdit();
        }
      },
    });
    // console.log(results);
  };

  var handleIsEdit = function () {
    $("#editControl").on("click", function () {
      if ($("#editControl").is(":checked")) {
        $("#account").removeAttr("disabled", "disabled");
        $("#payroll_name").removeAttr("disabled", "disabled");
        $("#btnUpdate").removeAttr("disabled", "disabled");
      } else {
        $("#account").attr("disabled", "disabled");
        $("#payroll_name").attr("disabled", "disabled");
        $("#btnUpdate").attr("disabled", "disabled");
      }
    });
  };

  var handleFormSubmit = function () {
    $("#formEmployeePayroll").submit(function (e) {
      e.preventDefault();
      const form = $(this);
      let formData = new FormData(form[0]);

      if (confirm("Apakah Data Sudah Sesuai?!")) {
        $.ajax({
          type: "POST",
          url: url + "app/ajax/update-employee-payroll.php",
          data: formData,
          processData: false,
          contentType: false,
          success: function (response) {
            let obj = response.success;

            if (obj === true) {
              toastr.success(response.data);

              setTimeout(() => {
                location.reload();
              }, 4500);
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

  var handleAddPayrollIfNull = function () {
    $("#formPayrollifNull").submit(function (e) {
      e.preventDefault();
      const form = $(this);
      let formData = new FormData(form[0]);

      if (confirm("Apakah Data Sudah Sesuai?!")) {
        $.ajax({
          type: "POST",
          url: url + "app/ajax/employee-payroll.php",
          data: formData,
          processData: false,
          contentType: false,
          success: function (response) {
            let obj = response.success;

            if (obj === true) {
              toastr.success(response.data);

              setTimeout(() => {
                location.reload();
              }, 4500);
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

  return {
    init: function () {
      getDataEmployee();
      handleFormSubmit();
      handleAddPayrollIfNull();
    },
  };
})();

$(document).ready(function () {
  Index.init();
});
