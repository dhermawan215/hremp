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
        $("#karyawanName").html(response.nama);
        results = response;
      },
    });
    return results;
    // console.log(results);
  };

  var handleFormSubmit = function (DataId, DataStatus) {
    const dataId = DataId;
    const dataStatus = DataStatus;
    $("#formEmployeePersonal").submit(function (e) {
      e.preventDefault();
      const form = $(this);
      let formData = new FormData(form[0]);

      if (confirm("Apakah Data Sudah Sesuai?!")) {
        $.ajax({
          type: "POST",
          url: url + "app/ajax/employee-personal-address.php",
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
                  "view/pages/employee/employee-edu.php?dataId=" +
                  dataId +
                  "&dataStatus=" +
                  dataStatus;
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
      const DataId = getDataEmployee().id;
      const DataStatus = getDataEmployee().status;
      handleFormSubmit(DataId, DataStatus);
    },
  };
})();

$(document).ready(function () {
  Index.init();
});
