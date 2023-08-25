var Index = (function () {
  const csrf_token = $('meta[name="csrf-token"]').attr("content");
  var table;

  var handleKontrak = function () {
    table = $("#tableReminderContract").DataTable({
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
        url: url + "app/ajax/emp-akhir-kontrak.php",
        type: "POST",
        data: {
          _token: csrf_token,
        },
      },
      columns: [
        { data: "rnum", orderable: false },
        { data: "nip", orderable: false },
        { data: "nama", orderable: false },
        { data: "status_name", orderable: false },
        { data: "akhir_kontrak", orderable: false },
      ],
      // rowCallback: function (row, data) {
      //   console.log(row);
      //   console.log(data);
      // },
    });
    $(".tfoot-search").on("change", function (e) {
      var data_index = $(this).attr("data-index");
      table.columns(data_index).search($(this).val()).draw();
      table.ajax.reload(null, false);
    });
  };

  return {
    init: function () {
      handleKontrak();
    },
  };
})();

$(document).ready(function () {
  Index.init();
});
