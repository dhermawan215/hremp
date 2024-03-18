var Index = (function () {
  const csrf_token = $('meta[name="csrf-token"]').attr("content");
  var table;
  var aSelected = [];

  var handleData = function () {
    table = $("#table-my-request").DataTable({
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
        url: url + "app/flexy-allowance/allowance-my-request.php",
        type: "POST",
        data: {
          _token: csrf_token,
        },
      },
      columns: [
        { data: "cbox", orderable: false },
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
      drawCallback: function (settings) {
        $(".data-menu-cbox").on("click", function () {
          handleAddDeleteAselected($(this).val(), $(this).parents()[1]);
        });
        $("#btn-delete").attr("disabled", "");
        aSelected.splice(0, aSelected.length);
      },
    });
    $("#table-my-request tbody").on("click", "tr", function () {
      // console.log(table.row(this).data());
      handleInfo(table.row(this).data());
    });
  };

  var handleInfo = function (param) {
    $(document).on("click", ".hr-status-info", function () {
      // console.log(param);
      $("#modal-title").html("Hr Note");
      if (param.hr_note === null) {
        var hrNote = "Data not found";
      } else {
        var hrNote = param.hr_note;
      }
      $("#note-message").html("HR Note: " + hrNote);
    });
    $(document).on("click", ".manager-status-info", function () {
      // console.log(param);
      $("#modal-title").html("HR Director Note");
      if (param.manager_note === null) {
        var managerNote = "Data not found";
      } else {
        var managerNote = param.manager_note;
      }
      $("#note-message").html("HR Director Note: " + managerNote);
    });
  };

  var handleAddDeleteAselected = function (value, parentElement) {
    var check_value = $.inArray(value, aSelected);
    if (check_value !== -1) {
      $(parentElement).removeClass("table-info");
      aSelected.splice(check_value, 1);
    } else {
      $(parentElement).addClass("table-info");
      aSelected.push(value);
    }

    handleBtnDisableEnable();
  };

  var handleBtnDisableEnable = function () {
    if (aSelected.length > 0) {
      $("#btn-delete").removeAttr("disabled");
    } else {
      $("#btn-delete").attr("disabled", "");
    }
  };

  var handleDelete = function () {
    $("#btn-delete").click(function (e) {
      e.preventDefault();
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
            url: url + "app/flexy-allowance/allowance-request-route.php",
            data: {
              action: "delete",
              _token: csrf_token,
              ids: aSelected,
            },
            success: function (response) {
              if (response.success == true) {
                Swal.fire("Deleted!", "Your file has been deleted.", "success");
                table.ajax.reload();
              }
            },
            error: function (response) {
              Swal.fire({
                icon: "error",
                title: "Oops...",
                text: "Internal Server Error",
              });
            },
          });
        }
      });
    });
  };

  return {
    init: function () {
      handleData();
      handleDelete();
    },
  };
})();

$(document).ready(function () {
  Index.init();
});
