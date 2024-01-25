var Index = (function () {
  const csrf_token = $('meta[name="csrf-token"]').attr("content");
  const idFrom = $("#emp_id").val();

  var getDataEmployee = function () {
    var results;
    $.ajax({
      type: "POST",
      url: url + "app/ajax/emp-personal-edu.php",
      async: false,
      data: {
        id: idFrom,
        _token: csrf_token,
      },
      //   processData: false,
      //   contentType: false,
      success: function (response) {
        $("#pendidikanTerakhir").attr("disabled", "disabled");
        $("#jurusan").attr("disabled", "disabled");
        $("#asal_sekolah").attr("disabled", "disabled");
        $("#btnUpdated").attr("disabled", "disabled");

        // let obj = response.success;
        if (response.data_index === null) {
          alert("Data Education Null!");
          $("#editControl").attr("disabled", "disabled");
          $("#btnEduNull").removeAttr("disabled");
        } else {
          $("#editControl").removeAttr("disabled");
          $("#btnEduNull").attr("disabled", "disabled");
          $("#karyawanName").html(response.nama);
          results = response;
          $("#idData").val(response.data_index);
          $("#pendidikanTerakhir").val(response.pendidikan_terakhir);
          $("#jurusan").val(response.jurusan);
          $("#asal_sekolah").val(response.asal_sekolah);
          handleIsEdit(results);
        }
      },
    });
    // return results;
    // console.log(results);
  };

  var handleIsEdit = function (results) {
    const pendidikan_value = results.pendidikan_terakhir;
    const pendidikan_name = results.pendidikan_terakhir;
    // $("#StatusEmp").val("val2").change();
    $("#pendidikanTerakhir").append(
      $("<option>", {
        value: pendidikan_value,
        text: pendidikan_name,
        attr: "selected",
      })
    );
    //kondisi cek box true false

    $("#editControl").on("click", function () {
      if ($("#editControl").is(":checked")) {
        $("#pendidikanTerakhir").removeAttr("disabled", "disabled");
        $("#jurusan").removeAttr("disabled", "disabled");
        $("#asal_sekolah").removeAttr("disabled", "disabled");
        $("#btnUpdated").removeAttr("disabled");
        handlePendidikan();
      } else {
        $("#pendidikanTerakhir").attr("disabled", "disabled");
        $("#jurusan").attr("disabled", "disabled");
        $("#asal_sekolah").attr("disabled", "disabled");
        $("#btnUpdated").attr("disabled", "disabled");
      }
    });

    // $("#StatusEmp").on("click", function (ev) {
    // });
  };

  var handlePendidikan = function () {
    var data = [
      {
        id: "SD",
        text: "SD",
      },
      {
        id: "SMP",
        text: "SMP",
      },
      {
        id: "SMA/SMK",
        text: "SMA/SMK",
      },
      {
        id: "D3",
        text: "D3",
      },
      {
        id: "D4",
        text: "D4",
      },
      {
        id: "S1",
        text: "S1",
      },
      {
        id: "S2",
        text: "S2",
      },
    ];

    $("#pendidikanTerakhir").select2({
      data: data,
    });
  };

  var handleFormSubmit = function () {
    $("#formEmployeePersonalEdu").submit(function (e) {
      e.preventDefault();
      const form = $(this);
      let formData = new FormData(form[0]);

      if (confirm("Apakah Data Sudah Sesuai?!")) {
        $.ajax({
          type: "POST",
          url: url + "app/ajax/update-employee-personal-edu.php",
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

  var handleAddIfNull = function () {
    $("#formAddEdu").submit(function (e) {
      e.preventDefault();
      const form = $(this);
      let formData = new FormData(form[0]);

      if (confirm("Apakah Data Sudah Sesuai?!")) {
        $.ajax({
          type: "POST",
          url: url + "app/ajax/employee-personal-edu.php",
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
      handleAddIfNull();
    },
  };
})();

$(document).ready(function () {
  Index.init();
});
