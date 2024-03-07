var Index = (function () {
  const csrf_token = $('meta[name="csrf-token"]').attr("content");
  const costCenterid = $("#cost-center").val();
  var table;
  var aSelected = [];
  // cost center department start
  var handleData = function () {
    table = $("#table-cost-center-department").DataTable({
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
        zeroRecords: "Data not found",
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
        url: url + "app/flexy-allowance/cost-center-department-route.php",
        type: "POST",
        data: {
          _token: csrf_token,
          action: "get-data",
          costcenter: costCenterid,
        },
      },
      columns: [
        { data: "cbox", orderable: false },
        { data: "rnum", orderable: false },
        { data: "comcost", orderable: false },
        { data: "department", orderable: false },
        // { data: "action", orderable: false },
      ],
      drawCallback: function (settings) {
        $(".data-menu-cbox").on("click", function () {
          handleAddDeleteAselected($(this).val(), $(this).parents()[1]);
        });
        $("#btn-delete").attr("disabled", "");
        aSelected.splice(0, aSelected.length);
      },
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
            url: url + "app/flexy-allowance/cost-center-department-route.php",
            data: {
              _token: csrf_token,
              ids: aSelected,
              action: "delete",
            },
            success: function (response) {
              if (response.success == true) {
                Swal.fire("Deleted!", "Your data has been deleted.", "success");
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
  var handleSave = function () {
    $("#btnBack").click(function (e) {
      e.preventDefault();
      window.location.href = url + "view/admin-flexy/cost-center-index.php";
    });

    $("#form-add-cost-center-department").submit(function (e) {
      e.preventDefault();
      const form = $(this);
      let formData = new FormData(form[0]);
      formData.append("action", "save");

      if (confirm("All done?!")) {
        $.ajax({
          type: "POST",
          url: url + "app/flexy-allowance/cost-center-department-route.php",
          data: formData,
          processData: false,
          contentType: false,
          success: function (response) {
            let obj = response.success;

            if (obj === true) {
              toastr.success(response.data);

              setTimeout(() => {
                location.reload();
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

  // cost center department end

  // detail cost center
  var handleDetailCostCenter = function () {
    $.ajax({
      type: "post",
      url: url + "app/flexy-allowance/cost-center-route.php",
      data: {
        costcenter: costCenterid,
        action: "detail",
        _token: csrf_token,
      },
      dataType: "json",
      success: function (response) {
        $("#company-detail").val(response.company_name);
        $("#cost-center-detail").val(response.cost_center_name);
      },
    });
  };
  // data department
  var handleDataDepartemen = function () {
    $("#department").select2({
      // minimumInputLength: 1,
      allowClear: true,
      placeholder: "select department/type department name",
      dataType: "json",
      ajax: {
        method: "POST",

        url: url + "app/ajax/data-departemen-dropdown.php",

        data: function (params) {
          return {
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
  // function select 2
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
  // end select 2

  return {
    init: function () {
      handleData();
      handleDelete();
      handleDetailCostCenter();
      handleDataDepartemen();
      handleSave();
    },
  };
})();

$(document).ready(function () {
  Index.init();
});
