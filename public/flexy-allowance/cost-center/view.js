var Index = (function () {
  const csrf_token = $('meta[name="csrf-token"]').attr("content");
  var table;
  var aSelected = [];

  var handleData = function () {
    table = $("#table-cost-center").DataTable({
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
        url: url + "app/flexy-allowance/cost-center-route.php",
        type: "POST",
        data: {
          _token: csrf_token,
          action: "get-data",
        },
      },
      columns: [
        { data: "cbox", orderable: false },
        { data: "rnum", orderable: false },
        { data: "company", orderable: false },
        { data: "name", orderable: false },
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
            url: url + "app/flexy-allowance/cost-center-route.php",
            data: {
              _token: csrf_token,
              ids: aSelected,
              action: "delete",
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
