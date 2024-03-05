var Index = (function () {
  const csrf_token = $('meta[name="csrf-token"]').attr("content");
  var table;
  var aSelected = [];

  var handleData = function () {
    const activity = $("#activity").val();
    table = $("#table-aktivitas-detail").DataTable({
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
        zeroRecords: "Data Not Found",
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
        url: url + "app/flexy-allowance/aktivitas-detail-data.php",
        type: "POST",
        data: {
          _token: csrf_token,
          activity: activity,
        },
      },
      columns: [
        { data: "cbox", orderable: false },
        { data: "rnum", orderable: false },
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
    $("#table-aktivitas-detail tbody").on("click", "tr", function () {
      // console.log(table.row(this).data());
      handleEdit(table.row(this).data());
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

  var handleEdit = function (paramData) {
    $(document).on("click", ".btn-edit", function () {
      //   insert data to field in modal
      var dataEdit = $(this).data("edit");
      $("#formValue").val(dataEdit);
      $("#nama-aktivitas-detail-edit").val(paramData.name);
    });
  };

  var handleSubmit = function () {
    $("#btnBack").click(function (e) {
      e.preventDefault();
      window.location.href = url + "view/admin-flexy/aktivitas-index.php";
    });

    $("#form-add-detail-activity").submit(function (e) {
      e.preventDefault();
      const form = $(this);
      let formData = new FormData(form[0]);

      if (confirm("All done?")) {
        $.ajax({
          type: "POST",
          url: url + "app/flexy-allowance/aktivitas-detail-submit.php",
          data: formData,
          processData: false,
          contentType: false,
          success: function (response) {
            let obj = response.success;

            if (obj === true) {
              toastr.success(response.data);

              setTimeout(() => {
                location.reload();
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
    $("#form-edit-aktivitas-detail").submit(function (e) {
      e.preventDefault();
      const form = $(this);
      let formData = new FormData(form[0]);

      if (confirm("Apakah data sudah sesuai?")) {
        $.ajax({
          type: "POST",
          url: url + "app/flexy-allowance/aktivitas-detail-update.php",
          data: formData,
          processData: false,
          contentType: false,
          success: function (response) {
            let obj = response.success;

            if (obj === true) {
              toastr.success(response.data);

              setTimeout(() => {
                window.location.reload();
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
            url: url + "app/flexy-allowance/aktivitas-detail-delete.php",
            data: {
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
      handleSubmit();
      handleUpdate();
      handleDelete();
    },
  };
})();

$(document).ready(function () {
  Index.init();
});
