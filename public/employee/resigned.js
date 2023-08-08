var Index = (function () {
  const csrf_token = $('meta[name="csrf-token"]').attr("content");
  var table;

  var handleData = function () {
    table = $("#tableEmpResigned").DataTable({
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
        url: url + "app/ajax/employee-resigned.php",
        type: "POST",
        data: {
          _token: csrf_token,
        },
      },
      columns: [
        { data: "rnum", orderable: false },
        { data: "nip", orderable: false },
        { data: "name", orderable: false },
        { data: "status", orderable: false },
        { data: "action", orderable: false },
      ],
    });
    $("#tableEmpResigned tbody").on("click", "tr", function () {
      // console.log(table.row(this).data());
      handleShowResigned(table.row(this).data());
    });
  };

  var handleShowResigned = function (param) {
    $(document).on("click", ".btnView", function () {
      const id = param.index;
      $("#karyawanName").html(param.name);

      $.ajax({
        type: "POST",
        url: url + "app/ajax/employee-show-resigned.php",
        data: {
          id: id,
          _token: csrf_token,
        },
        // processData: false,
        // contentType: false,
        success: function (response) {
          if (response.success === true) {
            $("#modalDataResigned").modal("toggle");
            $("#idData").val(param.index);
            $("#tgl_pengajuan").val(response.tanggal_pengajuan);
            $("#tgl_resign").val(response.tanggal_resign);
            $("#alasan_resign").val(response.alasan_resign);
          } else {
            toastr.error("Please try again");
          }
        },
      });
    });
  };

  return {
    init: function () {
      handleData();
    },
  };
})();

$(document).ready(function () {
  Index.init();
});
