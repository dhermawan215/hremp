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
          results = response;
          $("#namaSuamiIstri").attr("disabled", "disabled");
          $("#anak1").attr("disabled", "disabled");
          $("#anak2").attr("disabled", "disabled");
          $("#anak3").attr("disabled", "disabled");
          $("#anak4").attr("disabled", "disabled");
          $("#btnSave").attr("disabled", "disabled");
        }
      },
    });
    return results;
    // console.log(results);
  };

  var handleFormSubmit = function (DataId, DataStatus) {
    const dataId = DataId;
    const dataStatus = DataStatus;
    $("#formEmployeePersonalFm").submit(function (e) {
      e.preventDefault();
      const form = $(this);
      let formData = new FormData(form[0]);

      if (confirm("Apakah Data Sudah Sesuai?!")) {
        $.ajax({
          type: "POST",
          url: url + "app/ajax/employee-family.php",
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
                  "view/pages/employee/employee-emergency.php?dataId=" +
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

  var handleCheckBox = function (DataId, DataStatus) {
    const dataId = DataId;
    const dataStatus = DataStatus;
    $("#isFamilyCbxTrue").on("click", function () {
      if ($("#isFamilyCbxTrue").is(":checked")) {
        $("#namaSuamiIstri").removeAttr("disabled");
        $("#anak1").removeAttr("disabled");
        $("#anak2").removeAttr("disabled");
        $("#anak3").removeAttr("disabled");
        $("#anak4").removeAttr("disabled");
        $("#btnSave").removeAttr("disabled");
      } else {
        $("#namaSuamiIstri").attr("disabled", "disabled");
        $("#anak1").attr("disabled", "disabled");
        $("#anak2").attr("disabled", "disabled");
        $("#anak3").attr("disabled", "disabled");
        $("#anak4").attr("disabled", "disabled");
        $("#btnSave").attr("disabled", "disabled");
      }
    });
    $("#isFamilyCbxFalse").on("click", function () {
      if ($("#isFamilyCbxFalse").is(":checked")) {
        document.location.href =
          url +
          "view/pages/employee/employee-emergency.php?dataId=" +
          dataId +
          "&dataStatus=" +
          dataStatus;
      } else {
      }
    });
  };

  return {
    init: function () {
      getDataEmployee();
      const DataId = getDataEmployee().id;
      const DataStatus = getDataEmployee().status;
      handleFormSubmit(DataId, DataStatus);
      handleCheckBox(DataId, DataStatus);
    },
  };
})();

$(document).ready(function () {
  Index.init();
});
