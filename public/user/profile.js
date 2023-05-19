var Index = (function () {
  const csrf_token = $('meta[name="csrf-token"]').attr("content");

  var handleUpdatePassword = function () {
    $("#formUpdatePassword").submit(function (e) {
      e.preventDefault();

      const form = $(this);
      let formData = new FormData(form[0]);

      $.ajax({
        type: "POST",
        url: url + "app/ajax/profile.php",
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
              location.reload(true);
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
      handleUpdatePassword();
    },
  };
})();

$(document).ready(function () {
  Index.init();
});
