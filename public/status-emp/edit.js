var Index = (function () {
  const csrf_token = $('meta[name="csrf-token"]').attr("content");

  var handleGetData = function () {
    $.ajax({
      type: "POST",
      url: url + "app/ajax/status-emp-edit.php",
      data: {
        _token: csrf_token,
        id: $("#idValue").val(),
      },
      success: function (response) {
        $("#StatusName").val(response.status_name);
        $("#editTitle").html(response.status_name);
      },
    });
  };

  var handleUpdateCompany = function () {
    $("#btnBack").click(function (e) {
      e.preventDefault();
      window.location.href = url + "view/pages/status/index.php";
    });

    $("#formEdit").submit(function (e) {
      e.preventDefault();

      const form = $(this);
      let formData = new FormData(form[0]);

      $.ajax({
        type: "POST",
        url: url + "app/ajax/status-emp-update.php",
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
          let obj = response.success;

          if (obj === true) {
            $.each(response.data, function (key, value) {
              toastr.success(value);
            });

            setTimeout(() => {
              document.location.href = url + "view/pages/status/index.php";
            }, 4000);
          } else {
            $.each(response.data, function (key, value) {
              toastr.error(value);
            });
          }
        },
      });
    });
  };

  return {
    init: function () {
      handleUpdateCompany();
      handleGetData();
    },
  };
})();

$(document).ready(function () {
  Index.init();
});
