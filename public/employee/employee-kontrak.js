var Index = (function () {
  const csrf_token = $('meta[name="csrf-token"]').attr("content");
  const idFrom = $("#emp_id").val();

  var getDataEmployee = function () {
    var results;
    $.ajax({
      type: "POST",
      url: url + "app/ajax/employee-data.php",
      async: false,
      data: {
        id: idFrom,
        _token: csrf_token,
      },
      //   processData: false,
      //   contentType: false,
      success: function (response) {
        // let obj = response.success;
        if (response.id === null && response.status === null) {
          document.location.href = url + "view/pages/employee/index.php";
        } else {
          $("#karyawanName").html(response.nama);
          $("#statusKerja").html(response.status_name);
          results = response;
        }
      },
    });
    return results;
  };

  var handleFormSubmit = function () {
   
    $("#formEmployeeKontrak").submit(function (e) {
      e.preventDefault();
      const form = $(this);
      let formData = new FormData(form[0]);

      if (confirm("Apakah Data Sudah Sesuai?!")) {
        $.ajax({
          type: "POST",
          url: url + "app/ajax/employee-kontrak.php",
          data: formData,
          processData: false,
          contentType: false,
          success: function (response) {
            let obj = response.success;

            if (obj === true) {
              toastr.success(response.data);

              setTimeout(() => {
                document.location.href =
                  url +
                  "view/pages/employee/success.php";
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
