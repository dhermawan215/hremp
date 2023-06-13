var Index = (function () {
  const csrf_token = $('meta[name="csrf-token"]').attr("content");
  const idFrom = $("#emp_id").val();

  var getDataEmployee = function () {
    var results;
    $.ajax({
      type: "POST",
      url: url + "app/ajax/data-emp-personal.php",
      async: false,
      data: {
        id: idFrom,
        _token: csrf_token,
      },
      //   processData: false,
      //   contentType: false,
      success: function (response) {
        $("#tempatLahir").attr("disabled", "disabled");
        $("#tanggalLahir").attr("disabled", "disabled");
        $("#statusPernikahan").attr("disabled", "disabled");
        $("#agama").attr("disabled", "disabled");
        $("#gender").attr("disabled", "disabled");
        $("#nik").attr("disabled", "disabled");
        $("#golonganDarah").attr("disabled", "disabled");
        $("#email").attr("disabled", "disabled");
        $("#no_hp").attr("disabled", "disabled");
        $("#domisili").attr("disabled", "disabled");
        $("#btnUpdated").attr("disabled", "disabled");
        // let obj = response.success;
        if (response.data_index === null) {
          document.location.href = url + "view/pages/employee/index.php";
          // console.log(response.data_index);
        } else {
          $("#karyawanName").html(response.nama);
          results = response;
          $("#idData").val(response.data_index);
          $("#tempatLahir").val(response.tempat_lahir);
          $("#tanggalLahir").val(response.tanggal_lahir);
          $("#statusPernikahan").val(response.status_pernikahan);
          $("#agama").val(response.agama);
          $("#gender").val(response.gender);
          $("#nik").val(response.nik);
          $("#golonganDarah").val(response.golongan_darah);
          $("#email").val(response.email);
          $("#no_hp").val(response.no_hp);
          $("#domisili").val(response.domisili);
          handleIsEdit(results);
        }
      },
    });
    // return results;
    // console.log(results);
  };

  var handleIsEdit = function (results) {
    const golDarah_value = results.golongan_darah;
    const golDarah_name = results.golongan_darah;
    const gender_value = results.gender;
    const gender_name = results.gender;
    const sp_value = results.status_pernikahan;
    const sp_name = results.status_pernikahan;
    // $("#StatusEmp").val("val2").change();
    $("#golonganDarah").append(
      $("<option>", {
        value: golDarah_value,
        text: golDarah_name,
        attr: "selected",
      })
    );
    $("#gender").append(
      $("<option>", {
        value: gender_value,
        text: gender_name,
        attr: "selected",
      })
    );
    $("#statusPernikahan").append(
      $("<option>", { value: sp_value, text: sp_name, attr: "selected" })
    );

    //kondisi cek box true false

    $("#editControl").on("click", function () {
      if ($("#editControl").is(":checked")) {
        $("#tempatLahir").removeAttr("disabled");
        $("#tanggalLahir").removeAttr("disabled");
        $("#statusPernikahan").removeAttr("disabled");
        $("#agama").removeAttr("disabled");
        $("#gender").removeAttr("disabled");
        $("#nik").removeAttr("disabled");
        $("#golonganDarah").removeAttr("disabled");
        $("#email").removeAttr("disabled");
        $("#no_hp").removeAttr("disabled");
        $("#domisili").removeAttr("disabled");
        $("#btnUpdated").removeAttr("disabled");
        handleGender();
        handleGolDarah();
        handleStatusPernikahan();
      } else {
        $("#tempatLahir").attr("disabled", "disabled");
        $("#tanggalLahir").attr("disabled", "disabled");
        $("#statusPernikahan").attr("disabled", "disabled");
        $("#agama").attr("disabled", "disabled");
        $("#gender").attr("disabled", "disabled");
        $("#nik").attr("disabled", "disabled");
        $("#golonganDarah").attr("disabled", "disabled");
        $("#email").attr("disabled", "disabled");
        $("#no_hp").attr("disabled", "disabled");
        $("#domisili").attr("disabled", "disabled");
        $("#btnUpdated").attr("disabled", "disabled");
      }
    });

    // $("#StatusEmp").on("click", function (ev) {
    // });
  };

  var handleGender = function () {
    var data = [
      {
        id: "Laki-Laki",
        text: "Laki-Laki",
      },
      {
        id: "Perempuan",
        text: "Perempuan",
      },
    ];

    $("#gender").select2({
      data: data,
    });
  };

  var handleGolDarah = function () {
    var data = [
      {
        id: "O",
        text: "O",
      },
      {
        id: "A",
        text: "A",
      },
      {
        id: "B",
        text: "B",
      },
      {
        id: "AB",
        text: "AB",
      },
    ];

    $("#golonganDarah").select2({
      data: data,
    });
  };

  var handleStatusPernikahan = function () {
    var data = [
      {
        id: "Belum Menikah",
        text: "Belum Menikah",
      },
      {
        id: "Menikah",
        text: "Menikah",
      },
      {
        id: "Cerai Hidup",
        text: "Cerai Hidup",
      },
      {
        id: "Cerai Mati",
        text: "Cerai Mati",
      },
    ];

    $("#statusPernikahan").select2({
      data: data,
    });
  };

  var handleFormSubmit = function () {
    $("#formEmployeePersonal").submit(function (e) {
      e.preventDefault();
      const form = $(this);
      let formData = new FormData(form[0]);

      if (confirm("Apakah Data Sudah Sesuai?!")) {
        $.ajax({
          type: "POST",
          url: url + "app/ajax/update-employee-personal.php",
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
