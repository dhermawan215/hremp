var Index = (function () {
  const csrf_token = $('meta[name="csrf-token"]').attr("content");
  const idFrom = $("#emp_id").val();

  var handleDataPengalaman = function () {
    table = $("#tablePengalamanKerja").DataTable({
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
        url: url + "app/ajax/emp-pengalaman-kerja.php",
        type: "POST",
        data: {
          _token: csrf_token,
          empId: idFrom,
        },
      },
      columns: [
        { data: "action", orderable: false },
        { data: "perusahaan", orderable: false },
        { data: "jabatan", orderable: false },
        { data: "periode_masuk", orderable: false },
        { data: "periode_keluar", orderable: false },
        { data: "keterangan", orderable: false },
      ],
      // rowCallback: function (row, data) {
      //   console.log(row);
      //   console.log(data);
      // },
    });
    $("#tablePengalamanKerja tbody").on("click", "tr", function () {
      // console.log(table.row(this).data());
      handleShowInModal(table.row(this).data());
    });
  };

  var handleShowInModal = function (param) {
    $("#idData").val(param.data_index);
    $("#perusahaan2").val(param.perusahaan);
    $("#jabatan2").val(param.jabatan);
    $("#periode_masuk2").val(param.periode_masuk);
    $("#periode_keluar2").val(param.periode_keluar);
    $("#keterangan2").val(param.keterangan);
  };

  // fungsi tambah pengalaman kerja
  var handlePengalamanKerja = function () {
    $("#formEmployeeAddPengalaman").submit(function (e) {
      e.preventDefault();
      const form = $(this);
      let formData = new FormData(form[0]);

      if (confirm("Apakah Data Sudah Sesuai?!")) {
        $.ajax({
          type: "POST",
          url: url + "app/ajax/employee-pengalaman-kerja.php",
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

  // fungsi update pengalaman kerja
  var handleUpdatePengalamanKerja = function () {
    $("#formEmployeeUpdatePengalaman").submit(function (e) {
      e.preventDefault();
      const form = $(this);
      let formData = new FormData(form[0]);

      if (confirm("Apakah Data Sudah Sesuai?!")) {
        $.ajax({
          type: "POST",
          url: url + "app/ajax/update-employee-pengalaman-kerja.php",
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

  //fungsi delete data pengalaman kerja
  var handleDelete = function () {
    $(document).on("click", ".btnDelete", function () {
      let id = $(this).data("button");
      Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!",
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            type: "POST",
            url: url + "/app/ajax/delete-pengalaman-kerja.php",
            data: {
              _token: csrf_token,
              ids: id,
            },
            success: function (response) {
              if (response.success === true) {
                Swal.fire("Deleted!", "Your file has been deleted.", "success");
                table.ajax.reload();
              } else {
                Swal.fire({
                  icon: "error",
                  title: "Oops...",
                  text: "Internal Server Error",
                });
              }
            },
          });
        }
      });
    });
  };

  // fungsi ambil data karyawan
  var getDataEmployee = function () {
    var results;
    $.ajax({
      type: "POST",
      url: url + "app/ajax/emp-employee.php",
      async: false,
      data: {
        index: idFrom,
        _token: csrf_token,
      },
      //   processData: false,
      //   contentType: false,
      success: function (response) {
        $("#karyawanName").html(response.nama);
      },
    });
    // console.log(results);
  };

  return {
    init: function () {
      handleDataPengalaman();
      getDataEmployee();
      handlePengalamanKerja();
      handleDelete();
      handleUpdatePengalamanKerja();
    },
  };
})();

$(document).ready(function () {
  Index.init();
});
