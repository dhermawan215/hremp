var Index = (function () {
  const csrf_token = $('meta[name="csrf-token"]').attr("content");
  var table;

  var handleData = function () {
    table = $("#table-account-limit").DataTable({
      responsive: true,
      autoWidth: true,
      pageLength: 15,
      searching: true,
      paging: true,
      lengthMenu: [
        [15, 25, 50],
        [15, 25, 50],
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
        url: url + "app/flexy-allowance/limit-data.php",
        type: "POST",
        data: {
          _token: csrf_token,
        },
      },
      columns: [
        { data: "rnum", orderable: false },
        { data: "name", orderable: false },
        { data: "pangkat", orderable: false },
        { data: "saldo_awal", orderable: false },
        { data: "periode", orderable: false },
        { data: "action", orderable: false },
      ],
    });
    $("#table-account-limit tbody").on("click", "tr", function () {
      handleEdit(table.row(this).data());
    });
  };

  var handleEdit = function (paramData) {
    $(document).on("click", ".btn-edit", function () {
      //   insert data to field in modal
      var dataEdit = $(this).data("edit");

      $("#formValue").val(dataEdit);
      $("#nama-aktivitas").val(paramData.name);
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
