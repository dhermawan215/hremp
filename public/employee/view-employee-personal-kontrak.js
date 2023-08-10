var Index = (function () {
  const csrf_token = $('meta[name="csrf-token"]').attr("content");
  const idFrom = $("#emp_id").val();

  var handleDataKontrak = function () {
    table = $("#tebleDataKontrak").DataTable({
      responsive: true,
      autoWidth: true,
      pageLength: 10,
      searching: true,
      paging: true,
      lengthMenu: [
        [10, 25, 50],
        [10, 25, 50],
      ],
      language: {
        info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
        infoEmpty: "Menampilkan 0 - 0 dari 0 data",
        infoFiltered: "",
        zeroRecords: "Data tidak di temukan",
        loadingRecords: "Loading...",
        processing: "Processing...",
      },
      columnsDefs: [
        { searchable: false, target: [0, 1] },
        { orderable: false, target: 0 },
      ],
      processing: true,
      serverSide: true,
      ajax: {
        url: url + "app/ajax/emp-personal-kontrak.php",
        type: "POST",
        data: {
          _token: csrf_token,
          empId: idFrom,
        },
      },
      columns: [
        { data: "rnum", orderable: false },
        { data: "awal_kontrak", orderable: false },
        { data: "akhir_kontrak", orderable: false },
        { data: "keterangan", orderable: false },
        { data: "action", orderable: false },
      ],
      // rowCallback: function (row, data) {
      //   console.log(row);
      //   console.log(data);
      // },
    });
    $("#tebleDataKontrak tbody").on("click", "tr", function () {
      // console.log(table.row(this).data());
      handleShowInModal(table.row(this).data());
    });
  };

  var handleShowInModal = function (param) {
    // console.log(param);
    $("#idData").val(param.data_index);
    $("#awal_kontrak").val(param.awal_kontrak);
    $("#akhir_kontrak").val(param.akhir_kontrak);
    $("#keterangan").val(param.keterangan);
  };

  var getDataEmployee = function () {
    var results;
    $.ajax({
      type: "POST",
      url: url + "app/ajax/emp-personal-kontrak2.php",
      async: false,
      data: {
        id: idFrom,
        _token: csrf_token,
      },
      //   processData: false,
      //   contentType: false,
      success: function (response) {
        $("#karyawanName").html(response.nama);
        $("#statusContent").append(response.content);
        $("#btnAddKontrak").prop("disabled", response.disabled_btn);
      },
    });
    // console.log(results);
  };

  var handleIsEdit = function () {
    $("#editControl").on("click", function () {
      if ($("#editControl").is(":checked")) {
        $("#awal_kontrak").removeAttr("disabled", "disabled");
        $("#akhir_kontrak").removeAttr("disabled", "disabled");
        $("#keterangan").removeAttr("disabled", "disabled");
        $("#btnUpdate").removeAttr("disabled", "disabled");
      } else {
        $("#awal_kontrak").attr("disabled", "disabled");
        $("#akhir_kontrak").attr("disabled", "disabled");
        $("#keterangan").attr("disabled", "disabled");
        $("#btnUpdate").attr("disabled", "disabled");
      }
    });
  };

  var handleFormSubmit = function () {
    $("#formEmployeeKontrak").submit(function (e) {
      e.preventDefault();
      const form = $(this);
      let formData = new FormData(form[0]);

      if (confirm("Apakah Data Sudah Sesuai?!")) {
        $.ajax({
          type: "POST",
          url: url + "app/ajax/update-employee-kontrak.php",
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

  var handleFormAddKontrak = function () {
    $("#formEmployeeAddKontrak").submit(function (e) {
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
      handleDataKontrak();
      handleFormSubmit();
      handleFormAddKontrak();
    },
  };
})();

$(document).ready(function () {
  Index.init();
});
