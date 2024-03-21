var Index = (function () {
  const csrf_token = $('meta[name="csrf-token"]').attr("content");
  var tableItem;
  var tableAttachment;
  var aSelectedItem = [];

  //get detail allowance request to show in card (upper area) start
  var getDetailAllowance = function () {
    $.ajax({
      type: "post",
      url: url + "app/flexy-allowance/allowance-request-detail-route.php",
      data: {
        nomer: noAllowance,
        _token: csrf_token,
        action: "get-detail-allowance",
      },
      dataType: "json",
      success: function (response) {
        $("#request-id").html(response.nomer);
        $("#req-date").html(response.transaction_date);
        $("#req-name").html(response.user_name);
        $("#subject").val(response.subject);
        $("#company").val(response.company_name);
        $("#cost-center").val(response.cost_center_name);
        $("#department").val(response.dept_name);
        $("#period").val(response.period);
        $(".allowance-number").val(response.allowance);
        $("#allowance-numbe-doc").val(response.allowance);
        $("#hr-status").val(response.hr_status);
        $("#hr-manager-status").val(response.hr_manager_status);
      },
    });
  };

  var handleItemData = function () {
    tableItem = $("#table-allowance-detail").DataTable({
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
        {
          searchable: false,
          target: [0, 1],
        },
        {
          orderable: false,
          target: 0,
        },
      ],
      processing: true,
      serverSide: true,
      ajax: {
        url: url + "app/flexy-allowance/hr-allowance-route.php",
        type: "POST",
        data: {
          nomer: noAllowance,
          _token: csrf_token,
          action: "list-item-detail-allowance",
        },
      },
      columns: [
        {
          data: "rnum",
          orderable: false,
        },
        {
          data: "activity",
          orderable: false,
        },
        {
          data: "detail",
          orderable: false,
        },
        {
          data: "desc",
          orderable: false,
        },
        {
          data: "dependents",
          orderable: false,
        },
        {
          data: "insured",
          orderable: false,
        },
        {
          data: "total_amount",
          orderable: false,
        },
        {
          data: "claim_amount",
          orderable: false,
        },
        {
          data: "date",
          orderable: false,
        },
      ],
      drawCallback: function (settings) {
        handleTotal(settings.json.total_claim_amount);
      },
    });
  };
  // fungsi untuk menampilkan total di input total
  var handleTotal = function (total) {
    const value_total = total;
    $("#total-claim-amount").val(value_total);
  };

  //tampilin dokumen yang diupload
  var handleItemAttachment = function (id_allowance) {
    tableAttachment = $("#tableDocs").DataTable({
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
        {
          searchable: false,
          target: [0, 1],
        },
        {
          orderable: false,
          target: 0,
        },
      ],
      processing: true,
      serverSide: true,
      ajax: {
        url: url + "app/flexy-allowance/hr-allowance-route.php",
        type: "POST",
        data: {
          nomer: noAllowance,
          _token: csrf_token,
          action: "list-item-attachment",
        },
      },
      columns: [
        {
          data: "rnum",
          orderable: false,
        },
        {
          data: "name",
          orderable: false,
        },
        {
          data: "upload_time",
          orderable: false,
        },
      ],
      drawCallback: function (settings) {},
    });
  };

  return {
    init: function () {
      getDetailAllowance();
      handleItemData();
      handleItemAttachment();
    },
  };
})();

$(document).ready(function () {
  Index.init();
});
