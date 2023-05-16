var Index = (function () {
  const csrf_token = $('meta[name="csrf-token"]').attr("content");

  var handleAddCompany = function () {
    $("#btnBack").click(function (e) {
      e.preventDefault();
      window.location.href = url + "view/pages/department/index.php";
    });

    $("#formAddDept").submit(function (e) {
      e.preventDefault();

      const form = $(this);
      let formData = new FormData(form[0]);

      $.ajax({
        type: "POST",
        url: url + "app/ajax/savedatadepartment.php",
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
      handleAddCompany();
    },
  };
})();

$(document).ready(function () {
  Index.init();
});
