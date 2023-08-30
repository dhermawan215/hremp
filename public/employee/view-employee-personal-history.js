var Index = (function () {
  const csrf_token = $('meta[name="csrf-token"]').attr("content");
  const idFrom = $("#emp_id").val();
  const idFrom2 = $("#karyawan").val();

  var handleDataKontrak = function () {
    table = $("#tableHistory").DataTable({
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
        url: url + "app/ajax/emp-personal-mutasi.php",
        type: "POST",
        data: {
          _token: csrf_token,
          karyawan: idFrom,
        },
      },
      columns: [
        { data: "rnum", orderable: false },
        { data: "company", orderable: false },
        { data: "awal", orderable: false },
        { data: "akhir", orderable: false },
        { data: "jabatan", orderable: false },
      ],
      // rowCallback: function (row, data) {
      //   console.log(row);
      //   console.log(data);
      // },
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
        index: idFrom2,
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
      handleDataKontrak();
      getDataEmployee();
    },
  };
})();

$(document).ready(function () {
  Index.init();
});
