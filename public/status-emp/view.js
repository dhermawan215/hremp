var Index = (function () {
  const csrf_token = $('meta[name="csrf-token"]').attr("content");
  var table;

  var handleData = function () {
    table = $("#tableStatusEmp").DataTable({
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
        url: url + "app/ajax/status-emp.php",
        type: "POST",
        data: {
          _token: csrf_token,
        },
      },
      columns: [
        { data: "rnum", orderable: false },
        { data: "name", orderable: false },
        { data: "action", orderable: false },
      ],
    });
  };

  var handleDelete = function () {
    $(document).on("click", ".btndel", function () {
      let id = $(this).data("id");
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
            url: url + "/app/ajax/status-emp-delete.php",
            data: {
              _token: csrf_token,
              ids: id,
            },
            success: function (response) {
              if (response.success == true) {
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
            error: function (response) {
              // Swal.fire({
              //   icon: "error",
              //   title: "Oops...",
              //   text: "Internal Server Error",
              // });
            },
          });
        }
      });
    });
  };

  var handleAdd = function () {
    $("#btnAdd").click(function (e) {
      e.preventDefault();
      window.location.href = url + "view/pages/status/create.php";
    });
  };

  return {
    init: function () {
      handleData();
      handleDelete();
      handleAdd();
    },
  };
})();

$(document).ready(function () {
  Index.init();
});
