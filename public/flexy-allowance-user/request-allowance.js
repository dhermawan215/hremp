var Index = (function () {
  const csrf_token = $('meta[name="csrf-token"]').attr("content");

  var handleSubmitAllowance = function () {
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

  var handleAllowanceNumber = function () {
    $.ajax({
      type: "post",
      url: url + "app/flexy-allowance/allowance-request-callback.php",
      data: {
        _token: csrf_token,
      },
      dataType: "json",
      success: function (response) {
        $("#nomer-allowance").val(response.newAllowanceNo);
      },
    });
  };

  return {
    init: function () {
      handleSubmitAllowance();
      handleAllowanceNumber();
    },
  };
})();

$(document).ready(function () {
  Index.init();
});
