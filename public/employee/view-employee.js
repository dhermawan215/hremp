var Index = (function () {
  const csrf_token = $('meta[name="csrf-token"]').attr("content");

  var handleDataStatus = function () {
    $("#StatusEmp").select2({
      // minimumInputLength: 1,
      allowClear: true,
      placeholder: "pilih item status",
      dataType: "json",
      ajax: {
        method: "POST",

        url: url + "app/ajax/data-status-dropdown.php",

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
  var handleDataCompany = function () {
    $("#Company").select2({
      // minimumInputLength: 1,
      allowClear: true,
      placeholder: "pilih item company",
      dataType: "json",
      ajax: {
        method: "POST",

        url: url + "app/ajax/data-company-dropdown.php",

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
  var handleDataDepartemen = function () {
    $("#Dept").select2({
      // minimumInputLength: 1,
      allowClear: true,
      placeholder: "pilih item departemen",
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

  const idFrom = $("#idEmployee").val();

  var getDataEmployee = function () {
    var results;
    $.ajax({
      type: "POST",
      url: url + "app/ajax/show-employee.php",
      async: false,
      data: {
        id: idFrom,
        _token: csrf_token,
      },
      //   processData: false,
      //   contentType: false,
      success: function (response) {
        // let obj = response.success;
        //default disabled
        $("#nip").attr("disabled", "disabled");
        $("#Nama").attr("disabled", "disabled");
        $("#empName").attr("disabled", "disabled");
        $("#lokasi").attr("disabled", "disabled");
        $("#tgl_masuk").attr("disabled", "disabled");
        $("#tgl_kartap").attr("disabled", "disabled");
        $("#email_kantor").attr("disabled", "disabled");
        $("#pangkat").attr("disabled", "disabled");
        $("#jabatan").attr("disabled", "disabled");
        $("#bpjstk").attr("disabled", "disabled");
        $("#bpjskes").attr("disabled", "disabled");
        $("#btnUpdated").attr("disabled", "disabled");
        $("#Dept").attr("disabled", "disabled");
        $("#Company").attr("disabled", "disabled");
        $("#StatusEmp").attr("disabled", "disabled");

        results = response;
        //value form
        $("#nip").val(results.nip);
        $("#Nama").val(results.nama);
        $("#empName").html(results.nama);
        $("#lokasi").val(results.lokasi);
        $("#tgl_masuk").val(results.tgl_masuk);
        $("#tgl_kartap").val(results.tgl_kartap);
        $("#email_kantor").val(results.email_kantor);
        $("#pangkat").val(results.pangkat);
        $("#jabatan").val(results.jabatan);
        $("#bpjstk").val(results.bpjstk);
        $("#bpjskes").val(results.bpjskes);
        handleIsEdit(results);
      },
    });
    return results;
  };

  var handleStatusEmp = function () {
    $("#StatusEmp").change(function (e) {
      e.preventDefault();
      const nilai = $(this).val();

      if (nilai == 1) {
        $("#tgl_kartap").removeAttr("disabled");
        $("#tgl_kartap").val("");
      } else {
        $("#tgl_kartap").attr("disabled", "disabled");
      }
    });
  };

  var handleIsEdit = function (results) {
    const status_value = results.status_emp;
    const status_name = results.status_name;
    const comp_value = results.comp_id;
    const comp_name = results.company_name;
    const dept_value = results.dept_id;
    const dept_name = results.dept_name;
    // $("#StatusEmp").val("val2").change();
    $("#StatusEmp").append(
      $("<option>", {
        value: status_value,
        text: status_name,
        attr: "selected",
      })
    );
    $("#Company").append(
      $("<option>", {
        value: comp_value,
        text: comp_name,
        attr: "selected",
      })
    );
    $("#Dept").append(
      $("<option>", { value: dept_value, text: dept_name, attr: "selected" })
    );

    //kondisi cek box true false

    $("#editControl").on("click", function () {
      if ($("#editControl").is(":checked")) {
        $("#nip").removeAttr("disabled");
        $("#nip").attr("readonly", true);
        $("#Nama").removeAttr("disabled");
        $("#empName").removeAttr("disabled");
        $("#lokasi").removeAttr("disabled");
        $("#tgl_masuk").removeAttr("disabled");
        $("#tgl_kartap").removeAttr("disabled");
        $("#email_kantor").removeAttr("disabled");
        $("#pangkat").removeAttr("disabled");
        $("#jabatan").removeAttr("disabled");
        $("#bpjstk").removeAttr("disabled");
        $("#bpjskes").removeAttr("disabled");
        $("#btnUpdated").removeAttr("disabled");
        $("#Dept").removeAttr("disabled");
        $("#Company").removeAttr("disabled");
        $("#StatusEmp").removeAttr("disabled");

        handleDataStatus();
        handleDataCompany();
        handleDataDepartemen();
      } else {
        $("#nip").attr("disabled", "disabled");
        $("#Nama").attr("disabled", "disabled");
        $("#empName").attr("disabled", "disabled");
        $("#lokasi").attr("disabled", "disabled");
        $("#tgl_masuk").attr("disabled", "disabled");
        $("#tgl_kartap").attr("disabled", "disabled");
        $("#email_kantor").attr("disabled", "disabled");
        $("#pangkat").attr("disabled", "disabled");
        $("#jabatan").attr("disabled", "disabled");
        $("#bpjstk").attr("disabled", "disabled");
        $("#bpjskes").attr("disabled", "disabled");
        $("#btnUpdated").attr("disabled", "disabled");
        $("#Dept").attr("disabled", "disabled");
        $("#Company").attr("disabled", "disabled");
        $("#StatusEmp").attr("disabled", "disabled");
      }
    });

    // $("#StatusEmp").on("click", function (ev) {
    // });
  };

  var handleFormSubmit = function () {
    $("#btnBack").click(function (e) {
      e.preventDefault();
      window.location.href = url + "view/pages/employee/index.php";
    });

    handleStatusEmp();

    $("#formEmployee").submit(function (e) {
      e.preventDefault();
      const form = $(this);
      let formData = new FormData(form[0]);

      if (confirm("Apakah Data Sudah Sesuai?!")) {
        $.ajax({
          type: "POST",
          url: url + "app/ajax/update-employee-emp.php",
          data: formData,
          processData: false,
          contentType: false,
          success: function (response) {
            let obj = response.success;

            if (obj === true) {
              toastr.success(response.data);
              setTimeout(() => {
                location.reload();
              }, 4500);
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
      getDataEmployee();
      handleFormSubmit();
    },
  };
})();

$(document).ready(function () {
  Index.init();
});
