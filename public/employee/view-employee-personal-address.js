var Index = (function () {
  const csrf_token = $('meta[name="csrf-token"]').attr("content");
  const idFrom = $("#emp_id").val();

  var getDataEmployee = function () {
    var results;
    $.ajax({
      type: "POST",
      url: url + "app/ajax/emp-personal-address.php",
      async: false,
      data: {
        id: idFrom,
        _token: csrf_token,
      },
      //   processData: false,
      //   contentType: false,
      success: function (response) {
        // let obj = response.success;
        $("#alamatKtp").attr("disabled", "disabled");
        $("#kelurahan").attr("disabled", "disabled");
        $("#rt").attr("disabled", "disabled");
        $("#rw").attr("disabled", "disabled");
        $("#kecamatan").attr("disabled", "disabled");
        $("#kota").attr("disabled", "disabled");
        $("#provinsi").attr("disabled", "disabled");
        $("#alamatLengkap").attr("disabled", "disabled");
        $("#noTelp").attr("disabled", "disabled");
        $("#btnUpdate").attr("disabled", "disabled");

        if (response.data_index === null) {
          document.location.href = url + "view/pages/employee/index.php";
          // console.log(response.data_index);
        } else {
          results = response;
          $("#karyawanName").html(results.nama);
          $("#alamatKtp").val(results.alamat_ktp);
          $("#kelurahan").val(results.kelurahan);
          $("#rt").val(results.rt);
          $("#rw").val(results.rw);
          $("#kecamatan").val(results.kecamatan);
          $("#kota").val(results.kota);
          $("#provinsi").val(results.provinsi);
          $("#alamatLengkap").val(results.alamat_lengkap);
          $("#noTelp").val(results.no_telp);
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
        $("#alamatKtp").removeAttr("disabled");
        $("#kelurahan").removeAttr("disabled");
        $("#rt").removeAttr("disabled");
        $("#rw").removeAttr("disabled");
        $("#kecamatan").removeAttr("disabled");
        $("#kota").removeAttr("disabled");
        $("#provinsi").removeAttr("disabled");
        $("#alamatLengkap").removeAttr("disabled");
        $("#noTelp").removeAttr("disabled");
        $("#btnUpdate").removeAttr("disabled");
      } else {
        $("#alamatKtp").attr("disabled", "disabled");
        $("#kelurahan").attr("disabled", "disabled");
        $("#rt").attr("disabled", "disabled");
        $("#rw").attr("disabled", "disabled");
        $("#kecamatan").attr("disabled", "disabled");
        $("#kota").attr("disabled", "disabled");
        $("#provinsi").attr("disabled", "disabled");
        $("#alamatLengkap").attr("disabled", "disabled");
        $("#noTelp").attr("disabled", "disabled");
        $("#btnUpdate").attr("disabled", "disabled");
      }
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
          url: url + "app/ajax/update-employee-personal-address.php",
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
