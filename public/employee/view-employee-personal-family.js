var Index = (function () {
  const csrf_token = $('meta[name="csrf-token"]').attr("content");
  const idFrom = $("#emp_id").val();

  var getDataEmployee = function () {
    var results;
    $.ajax({
      type: "POST",
      url: url + "app/ajax/emp-personal-fam.php",
      async: false,
      data: {
        id: idFrom,
        _token: csrf_token,
      },
      //   processData: false,
      //   contentType: false,
      success: function (response) {
        // let obj = response.success;
        $("#namaSuamiIstri").attr("disabled", "disabled");
        $("#anak1").attr("disabled", "disabled");
        $("#anak2").attr("disabled", "disabled");
        $("#anak3").attr("disabled", "disabled");
        $("#anak4").attr("disabled", "disabled");
        $("#btnUpdate").attr("disabled", "disabled");

        if (response.data_index === null) {
          $("#editControl").attr("disabled", "disabled");
          // console.log(response.data_index);
          $("#karyawanName").html(response.nama);
          $("#namaSuamiIstri").attr("placeholder", "data kosong");
          $("#anak1").attr("placeholder", "data kosong");
          $("#anak2").attr("placeholder", "data kosong");
          $("#anak3").attr("placeholder", "data kosong");
          $("#anak4").attr("placeholder", "data kosong");
        } else {
          $("#editControl").removeAttr("disabled");
          results = response;
          $("#karyawanName").html(results.nama);
          $("#namaSuamiIstri").val(results.nama_suami_istri);
          $("#anak1").val(results.anak1);
          $("#anak2").val(results.anak2);
          $("#anak3").val(results.anak3);
          $("#anak4").val(results.anak4);
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
        $("#namaSuamiIstri").removeAttr("disabled");
        $("#anak1").removeAttr("disabled");
        $("#anak2").removeAttr("disabled");
        $("#anak3").removeAttr("disabled");
        $("#anak4").removeAttr("disabled");
        $("#btnUpdate").removeAttr("disabled");
      } else {
        $("#namaSuamiIstri").attr("disabled", "disabled");
        $("#anak1").attr("disabled", "disabled");
        $("#anak2").attr("disabled", "disabled");
        $("#anak3").attr("disabled", "disabled");
        $("#anak4").attr("disabled", "disabled");
        $("#btnUpdate").attr("disabled", "disabled");
      }
    });
  };

  var handleFormSubmit = function () {
    $("#formEmployeePersonalFm").submit(function (e) {
      e.preventDefault();
      const form = $(this);
      let formData = new FormData(form[0]);

      if (confirm("Apakah Data Sudah Sesuai?!")) {
        $.ajax({
          type: "POST",
          url: url + "app/ajax/update-employee-personal-family.php",
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
