var Index = (function () {
  const csrf_token = $('meta[name="csrf-token"]').attr("content");
  var table;
  // fungsi untuk mendapatkan data hr need check
  var handleData = function () {
    table = $("#table-hr-need-check").DataTable({
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
        info: "Show _START_ - _END_ from _TOTAL_ data",
        infoEmpty: "Show 0 - 0 from 0 data",
        infoFiltered: "",
        zeroRecords: "Data not found",
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
        url: url + "app/flexy-allowance/dir-allowance-route.php",
        type: "POST",
        data: {
          _token: csrf_token,
          action: "list-approve",
        },
      },
      columns: [
        { data: "rnum", orderable: false },
        { data: "nomer", orderable: false },
        { data: "name", orderable: false },
        { data: "company", orderable: false },
        { data: "tr_date", orderable: false },
        { data: "period", orderable: false },
        { data: "total", orderable: false },
        { data: "hr", orderable: false },
        { data: "manager", orderable: false },
        { data: "action", orderable: false },
      ],
      drawCallback: function (settings) {},
    });
    $("#table-hr-need-check tbody").on("click", "tr", function () {});
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
