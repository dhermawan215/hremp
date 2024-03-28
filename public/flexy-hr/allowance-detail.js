var Index = (function () {
  const csrf_token = $('meta[name="csrf-token"]').attr("content");
  var tableItem;
  var tableAttachment;
  var aSelectedItem = [];

  //get detail allowance request to show in card (upper area) start
  var getDetailAllowance = function () {
    $("#btn-back").click(function (e) {
      e.preventDefault();
      window.location.href = `${url}view/hr-panel/allowance-need-check.php`;
    });

    $.ajax({
      type: "post",
      url: url + "app/flexy-allowance/hr-allowance-route.php",
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
        $("#allowance-numbe-doc").val(response.allowance);
        $("#hr-status").val(response.hr_status);
        $("#hr-note").val(response.hr_note);
        $("#hr-checked-at").val(response.hr_check_at);
        $("#manager-note").val(response.hr_manager_note);
        $("#hr-manager-status").val(response.hr_manager_status);
        $("#approve-col").html(response.btn_approve);
        $("#revision-col").html(response.btn_revision);
        $("#rejected-col").html(response.btn_rejected);
      },
    });

    handleSendRequestApprove();
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
          action: "list-attachment-allowance",
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

  // send request approve
  var handleSendRequestApprove = function () {
    $(document).on("click", "#btn-approve-allowance", function () {
      $.ajax({
        type: "POST",
        url: url + "app/flexy-allowance/hr-allowance-route.php",
        data: {
          nomerAllowance: noAllowance,
          _token: csrf_token,
          action: "approve",
        },
        beforeSend: function () {
          $("#overlay").fadeIn(300);
        },
        success: function (response) {
          toastr.success(response.data);
          setTimeout(() => {
            window.location.href = url + "view/hr-panel/allowance-approve.php";
          }, 3500);
        },
        complete: function () {
          $("#overlay").fadeOut(300);
        },
        error: function (response) {
          toastr.success(response.data);
          setTimeout(() => {
            location.reload();
          }, 3500);
        },
      });
    });
  };
  // send request revision
  var handleSendRequestRevision = function () {
    $("#form-allowance-revisi").submit(function (e) {
      e.preventDefault();
      const form = $(this);
      let formData = new FormData(form[0]);
      formData.append("nomerAllowance", noAllowance);
      formData.append("action", "revision");

      $.ajax({
        type: "POST",
        url: url + "app/flexy-allowance/hr-allowance-route.php",
        data: formData,
        processData: false,
        contentType: false,
        beforeSend: function () {
          $("#overlay").fadeIn(800);
        },
        success: function (response) {
          toastr.success(response.data);
          setTimeout(() => {
            location.reload();
          }, 3500);
        },
        complete: function () {
          $("#overlay").fadeOut(800);
        },
        error: function (response) {
          toastr.success(response.data);
          setTimeout(() => {
            location.reload();
          }, 3500);
        },
      });
    });
  };
  // send request rejected
  var handleSendRequestRejection = function () {
    $("#form-rejection-allowance").submit(function (e) {
      e.preventDefault();
      const form = $(this);
      let formData = new FormData(form[0]);
      formData.append("nomerAllowance", noAllowance);
      formData.append("action", "rejection");

      $.ajax({
        type: "POST",
        url: url + "app/flexy-allowance/hr-allowance-route.php",
        data: formData,
        processData: false,
        contentType: false,
        beforeSend: function () {
          $("#overlay").fadeIn(800);
        },
        success: function (response) {
          toastr.success(response.data);
          setTimeout(() => {
            location.reload();
          }, 3500);
        },
        complete: function () {
          $("#overlay").fadeOut(800);
        },
        error: function (response) {
          toastr.success(response.data);
          setTimeout(() => {
            location.reload();
          }, 3500);
        },
      });
    });
  };

  return {
    init: function () {
      getDetailAllowance();
      handleItemData();
      handleItemAttachment();
      handleSendRequestRevision();
      handleSendRequestRejection();
    },
  };
})();

$(document).ready(function () {
  Index.init();
});
