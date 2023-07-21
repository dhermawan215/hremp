var Index = (function () {
  const csrf_token = $('meta[name="csrf-token"]').attr("content");
  var table;

  var handleData = function () {
    table = $("#tableEmp").DataTable({
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
        url: url + "app/ajax/employee.php",
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
    $("#tableEmp tbody").on("click", "tr", function () {
      // console.log(table.row(this).data());
      handleShowInModal(table.row(this).data());
    });
  };

  var handleShowInModal = function (param) {
    $("#idData").val(param.index);
    $("#karyawanName").html(param.name);
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
            url: url + "",
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
      window.location.href = url + "view/pages/employee/employee.php";
    });
  };

  var handleIsResigned = function () {
    $("#formEmployeeResign").submit(function (e) {
      e.preventDefault();

      const form = $(this);
      let formData = new FormData(form[0]);

      if (confirm("Apakah Data Sudah Sesuai?!")) {
        $.ajax({
          type: "POST",
          url: url + "app/ajax/emp-resign.php",
          data: formData,
          processData: false,
          contentType: false,
          success: function (response) {
            let obj = response.success;

            if (obj === true) {
              toastr.success(response.data);

              setTimeout(() => {
                location.reload();
              }, 4500);
            } else {
              $.each(response.data, function (key, value) {
                toastr.error(value);
              });
            }
          },
        });
      }
    });
  };

  return {
    init: function () {
      handleData();
      handleDelete();
      handleAdd();
      handleIsResigned();
    },
  };
})();

$(document).ready(function () {
  Index.init();
});
