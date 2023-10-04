var Index = (function () {
  var csrf_token = $('meta[name="csrf-token"]').attr("content");
  var HandleLogin = function () {
    $("#formLogin").submit(function (e) {
      e.preventDefault();

      const form = $(this);
      let formData = new FormData(form[0]);

      $.ajax({
        type: "POST",
        url: url + "app/ajax/login.php",
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
              document.location.href = url + "index.php";
            }, 400);
          } else {
            $.each(response.data, function (key, value) {
              toastr.error(value);
            });
          }
        },
      });
    });
  };

  var HandleRegister = function () {
    $("#registerForm").submit(function (e) {
      e.preventDefault();

      const form = $(this);
      let formData = new FormData(form[0]);

      $.ajax({
        type: "POST",
        url: url + "app/ajax/register.php",
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
          let obj = response.success;

          if (obj === true) {
            console.log(obj);
            $.each(response.data, function (key, value) {
              toastr.success(value);
            });

            setTimeout(() => {
              document.location.href =
                url + "view/pages/admin/user-management.php";
            }, 300);
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
      HandleLogin();
      HandleRegister();
    },
  };
})();

$(document).ready(function () {
  Index.init();
});
