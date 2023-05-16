var Index = (function () {
  const csrf_token = $('meta[name="csrf-token"]').attr("content");

  var handleGetData = function () {
    $.ajax({
      type: "POST",
      url: url + "app/ajax/editdatacompany.php",
      data: {
        _token: csrf_token,
        id: $("#idValue").val(),
      },
      success: function (response) {
        $("#companyName").val(response.company_name);
        $("#editTitle").html(response.company_name);
      },
    });
  };

  var handleUpdateCompany = function () {
    $("#btnBack").click(function (e) {
      e.preventDefault();
      window.location.href = url + "view/pages/company/index.php";
    });

    $("#formEditCompany").submit(function (e) {
      e.preventDefault();

      const form = $(this);
      let formData = new FormData(form[0]);

      $.ajax({
        type: "POST",
        url: url + "app/ajax/updatedatacompany.php",
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
              document.location.href = url + "view/pages/company/index.php";
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
