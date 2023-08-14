var Index = (function () {
  const csrf_token = $('meta[name="csrf-token"]').attr("content");
  const idFrom = $("#emp_id").val();
  var table;
  var handleDataKontakDarurat = function () {
    table = $("#tableKontakDarurat").DataTable({
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
        url: url + "app/ajax/emp-personal-emergency-datatable.php",
        type: "POST",
        data: {
          _token: csrf_token,
          empId: idFrom,
        },
      },
      columns: [
        { data: "nama", orderable: false },
        { data: "alamat", orderable: false },
        { data: "no_telp", orderable: false },
        { data: "hubungan", orderable: false },
        { data: "action", orderable: false },
      ],
    });
    $("#tableKontakDarurat tbody").on("click", "tr", function () {
      // console.log(table.row(this).data());
      handleShowInModal(table.row(this).data());
    });
  };

  //fungsi menampilkan data di modal
  var handleShowInModal = function (param) {
    $("#idData").val(param.data_index);
    $("#nama").val(param.nama);
    $("#alamat").val(param.alamat);
    $("#no_telp").val(param.no_telp);
    $("#hubungan").val(param.hubungan);
  };

  // untuk update data setelah edit
  var handleFormSubmitUpdate = function () {
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

  //untuk tambah data kontak darurat
  var handleAddKontakDarurat = function () {
    $("#formEmployeeAddEmergency").submit(function (e) {
      e.preventDefault();
      const form = $(this);
      let formData = new FormData(form[0]);

      if (confirm("Apakah Data Sudah Sesuai?!")) {
        $.ajax({
          type: "POST",
          url: url + "app/ajax/employee-emergency.php",
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
      handleDataKontakDarurat();
      handleFormSubmitUpdate();
      handleAddKontakDarurat();
    },
  };
})();

$(document).ready(function () {
  Index.init();
});
