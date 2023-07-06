var Index = (function () {
  const csrf_token = $('meta[name="csrf-token"]').attr("content");
  const idFrom = $("#emp_id").val();

  var getDataEmployee = function () {
    var results;
    $.ajax({
      type: "POST",
      url: url + "app/ajax/emp-personal-emergency.php",
      async: false,
      data: {
        id: idFrom,
        _token: csrf_token,
      },
      //   processData: false,
      //   contentType: false,
      success: function (response) {
        // let obj = response.success;
        $("#nama").attr("disabled", "disabled");
        $("#alamat").attr("disabled", "disabled");
        $("#no_telp").attr("disabled", "disabled");
        $("#hubungan").attr("disabled", "disabled");
        $("#btnUpdate").attr("disabled", "disabled");

        if (response.data_index === null) {
          document.location.href = url + "view/pages/employee/index.php";
          // console.log(response.data_index);
        } else {
          results = response;
          $("#karyawanName").html(results.nama_emp);
          $("#nama").val(results.nama_emergency);
          $("#alamat").val(results.alamat);
          $("#no_telp").val(results.no_telp);
          $("#hubungan").val(results.hubungan);
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
        $("#nama").removeAttr("disabled");
        $("#alamat").removeAttr("disabled");
        $("#no_telp").removeAttr("disabled");
        $("#hubungan").removeAttr("disabled");
        $("#btnUpdate").removeAttr("disabled");
      } else {
        $("#nama").attr("disabled", "disabled");
        $("#alamat").attr("disabled", "disabled");
        $("#no_telp").attr("disabled", "disabled");
        $("#hubungan").attr("disabled", "disabled");
        $("#btnUpdate").attr("disabled", "disabled");
      }
    });
  };

  var handleFormSubmit = function () {
    $("#formEmployeeEmergency").submit(function (e) {
      e.preventDefault();
      const form = $(this);
      let formData = new FormData(form[0]);

      if (confirm("Apakah Data Sudah Sesuai?!")) {
        $.ajax({
          type: "POST",
          url: url + "app/ajax/update-employee-personal-emergency.php",
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
    },
  };
})();

$(document).ready(function () {
  Index.init();
});
