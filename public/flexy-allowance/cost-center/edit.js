var Index = (function () {
  const csrf_token = $('meta[name="csrf-token"]').attr("content");
  const idFrom = $("#formValue").val();
  var handleCompany = function () {
    $("#company").select2({
      // minimumInputLength: 1,
      allowClear: true,
      placeholder: "select company",
      dataType: "json",
      ajax: {
        method: "POST",

        url: url + "app/ajax/data-company-dropdown.php",

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

  var handleEditData = function () {
    $.ajax({
      type: "post",
      url: url + "app/flexy-allowance/cost-center-route.php",
      data: {
        formValue: idFrom,
        _token: csrf_token,
        action: "edit",
      },
      dataType: "json",
      success: function (response) {
        if (response.company !== null) {
          $("#company").append(
            $("<option>", {
              value: response.company,
              text: response.company_name,
              attr: "selected",
            })
          );
          $("#cost-center-name").val(response.cost_center_name);
        }
      },
    });
  };

  var handleFormSubmit = function () {
    $("#btnBack").click(function (e) {
      e.preventDefault();
      window.location.href = url + "view/admin-flexy/cost-center-index.php";
    });

    $("#form-edit-cost-center").submit(function (e) {
      e.preventDefault();
      const form = $(this);
      let formData = new FormData(form[0]);

      if (confirm("All done?!")) {
        $.ajax({
          type: "POST",
          url: url + "app/flexy-allowance/cost-center-route.php",
          data: formData,
          processData: false,
          contentType: false,
          success: function (response) {
            let obj = response.success;

            if (obj === true) {
              toastr.success(response.data);

              setTimeout(() => {
                document.location.href =
                  url + "view/admin-flexy/cost-center-index.php";
              }, 3500);
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
  return {
    init: function () {
      handleCompany();
      handleFormSubmit();
      handleEditData();
    },
  };
})();

$(document).ready(function () {
  Index.init();
});