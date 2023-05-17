var Index = (function () {
  const csrf_token = $('meta[name="csrf-token"]').attr("content");

  var handleGetData = function () {
    $.ajax({
      type: "POST",
      url: url + "app/ajax/editdepartment.php",
      data: {
        _token: csrf_token,
        id: $("#idValue").val(),
      },
      success: function (response) {
        $("#DeptName").val(response.dept_name);
        $("#editTitle").html(response.dept_name);
      },
    });
  };

  var handleUpdateCompany = function () {
    $("#btnBack").click(function (e) {
      e.preventDefault();
      window.location.href = url + "view/pages/department/index.php";
    });

    $("#formEditDept").submit(function (e) {
      e.preventDefault();

      const form = $(this);
      let formData = new FormData(form[0]);

      $.ajax({
        type: "POST",
        url: url + "app/ajax/updatedepartment.php",
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
              document.location.href = url + "view/pages/department/index.php";
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
