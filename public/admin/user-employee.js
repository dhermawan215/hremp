var Index = (function () {
  const csrf_token = $('meta[name="csrf-token"]').attr("content");
  var handleDataEmp = function () {
    $("#employee").select2({
      // minimumInputLength: 1,
      allowClear: true,
      placeholder: "Pilih Karyawan",
      dataType: "json",
      ajax: {
        method: "POST",

        url: url + "app/ajax/data-employee-dropdown.php",

        data: function (params) {
          return {
            _token: csrf_token,
            search: params.term,
            page: params.page || 1, // search term
          };
        },
        processResults: function (data, params) {
          params.page = params.page || 1;
          // var datas = JSON.parse(data);
          return {
            results: data.items,
            pagination: {
              more: false,
            },
          };
        },
      },
      templateResult: format,
      templateSelection: formatSelection,
    });
  };

  function format(repo) {
    if (repo.loading) {
      return repo.text;
    }

    var $container = $(
      "<div class='select2-result-repository clearfix'>" +
        "<div class='select2-result-repository__title'></div>" +
        "</div>"
    );

    $container.find(".select2-result-repository__title").text(repo.text);
    return $container;
  }

  function formatSelection(repo) {
    return repo.text;
  }

  var handleFormSubmit = function () {
    $("#btnBack").click(function (e) {
      e.preventDefault();
      window.location.href = url + "view/pages/admin/user-management.php";
    });

    $("#form-user-employee").submit(function (e) {
      e.preventDefault();
      const form = $(this);
      let formData = new FormData(form[0]);

      if (confirm("Apakah Data Sudah Sesuai?!")) {
        $.ajax({
          type: "POST",
          url: url + "app/ajax/user-mg-emp.php",
          data: formData,
          processData: false,
          contentType: false,
          success: function (response) {
            let obj = response.success;

            if (obj === true) {
              toastr.success(response.data);

              setTimeout(() => {
                document.location.href =
                  url + "view/pages/admin/user-management.php";
              }, 3500);
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
      handleDataEmp();
      handleFormSubmit();
    },
  };
})();

$(document).ready(function () {
  Index.init();
});
