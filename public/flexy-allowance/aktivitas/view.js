var Index = (function () {
  const csrf_token = $('meta[name="csrf-token"]').attr("content");
  var table;

  var handleData = function () {
    table = $("#table-aktivitas").DataTable({
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
        url: url + "app/flexy-allowance/aktivitas-data.php",
        type: "POST",
        data: {
          _token: csrf_token,
        },
      },
      columns: [
        { data: "rnum", orderable: false },
        { data: "name", orderable: false },
        { data: "created_by", orderable: false },
        { data: "action", orderable: false },
      ],
    });
    $("#table-aktivitas tbody").on("click", "tr", function () {
      // console.log(table.row(this).data());
      handleEdit(table.row(this).data());
    });
  };

  var handleEdit = function (paramData) {
    $(document).on("click", ".btn-edit", function () {
      //   insert data to field in modal
      var dataEdit = $(this).data("edit");
      console.log(dataEdit);
      $("#formValue").val(dataEdit);
      $("#nama-aktivitas").val(paramData.name);
    });
  };

  var handleSubmit = function () {
    $("#form-add-aktivitas").submit(function (e) {
      e.preventDefault();
      const form = $(this);
      let formData = new FormData(form[0]);

      if (confirm("Apakah data sudah sesuai?")) {
        $.ajax({
          type: "POST",
          url: url + "app/flexy-allowance/aktivitas-submit.php",
          data: formData,
          processData: false,
          contentType: false,
          success: function (response) {
            let obj = response.success;

            if (obj === true) {
              toastr.success(response.data);

              setTimeout(() => {
                $("#modal-add-aktivitas").modal("toggle");
                $("#nama").val("");
                table.ajax.reload();
              }, 4000);
            }
          },
          error: function (response) {
            $.each(response.responseJSON.data, function (key, value) {
              toastr.error(value);
            });
          },
        });
      }
    });
  };
  var handleUpdate = function () {
    $("#form-edit-aktivitas").submit(function (e) {
      e.preventDefault();
      const form = $(this);
      let formData = new FormData(form[0]);

      if (confirm("Apakah data sudah sesuai?")) {
        $.ajax({
          type: "POST",
          url: url + "app/flexy-allowance/aktivitas-update.php",
          data: formData,
          processData: false,
          contentType: false,
          success: function (response) {
            let obj = response.success;

            if (obj === true) {
              toastr.success(response.data);

              setTimeout(() => {
                $("#modal-edit-aktivitas").modal("toggle");
                $("#nama").val("");
                table.ajax.reload();
              }, 4000);
            }
          },
          error: function (response) {
            $.each(response.responseJSON.data, function (key, value) {
              toastr.error(value);
            });
          },
        });
      }
    });
  };

  var handleDelete = function () {
    $(document).on("click", ".btn-delete", function () {
      let id = $(this).data("delete");
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
            url: url + "app/flexy-allowance/aktivitas-delete.php",
            data: {
              _token: csrf_token,
              ids: id,
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
      handleSubmit();
      handleUpdate();
      handleDelete();
    },
  };
})();

$(document).ready(function () {
  Index.init();
});
