var Index = (function () {
  const csrf_token = $('meta[name="csrf-token"]').attr("content");
  var tableItem;
  var tableAttachment;
  var aSelectedItem = [];

  //get detail allowance request to show in card (upper area) start
  var getDetailAllowance = function () {
    $.ajax({
      type: "post",
      url: url + "app/flexy-allowance/allowance-request-detail-route.php",
      data: {
        nomer: noAllowance,
        _token: csrf_token,
        action: "get-detail-allowance",
      },
      dataType: "json",
      success: function (response) {
        $("#request-id").html(response.nomer);
        $("#req-date").html(response.transaction_date);
        $("#req-name").html(response.user_name);
        $("#subject").val(response.subject);
        $("#cost-center").val(response.cost_center_name);
        $("#department").val(response.dept_name);
        $("#period").val(response.period);
        $(".allowance-number").val(response.allowance);
        $("#hr-status").val(response.hr_status);
        $("#hr-manager-status").val(response.hr_manager_status);

        if (
          (response.hr_approve === "0" || response.hr_approve === "4") &&
          (response.manager_approve === "0" || response.manager_approve === "4")
        ) {
          $("#btn-save-detail").removeAttr("disabled");
        } else {
          $("#btn-save-detail").attr("disabled", "disabled");
        }

        if (response.hr_approve === "4" && response.manager_approve === "4") {
          const hrNoteElement =
            ' <label for="">HR Note</label><input type="text" disabled class="form-control" value="' +
            response.hr_note +
            '"></input>';
          const managerNoteElement =
            ' <label for="">HR Director Note</label><input type="text" disabled class="form-control" value="' +
            response.hr_manager_note +
            '"></input>';
          $("#hr-note").append(hrNoteElement);
          $("#manager-note").append(managerNoteElement);
        } else if (response.hr_approve === "4") {
          const hrNoteElement =
            ' <label for="">HR Note</label><input type="text" disabled class="form-control" value="' +
            response.hr_note +
            '"></input>';
          $("#hr-note").append(hrNoteElement);
        } else if (response.manager_approve === "4") {
          const managerNoteElement =
            ' <label for="">HR Director Note</label><input type="text" disabled class="form-control" value="' +
            response.hr_manager_note +
            '"></input>';
          $("#manager-note").append(managerNoteElement);
        }
      },
    });
  };

  var handleItemData = function () {
    tableItem = $("#table-allowance-detail").DataTable({
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
        url: url + "app/flexy-allowance/allowance-request-detail-route.php",
        type: "POST",
        data: {
          nomer: noAllowance,
          _token: csrf_token,
          action: "list-item-detail-allowance",
        },
      },
      columns: [
        { data: "cbox", orderable: false },
        { data: "rnum", orderable: false },
        { data: "activity", orderable: false },
        { data: "detail", orderable: false },
        { data: "desc", orderable: false },
        { data: "total_amount", orderable: false },
        { data: "claim_amount", orderable: false },
        { data: "date", orderable: false },
        { data: "action", orderable: false },
      ],
      drawCallback: function (settings) {
        $(".data-item-cbox").on("click", function () {
          handleAddDeleteAselected($(this).val(), $(this).parents()[1]);
        });
        $("#btn-delete-item").attr("disabled", "");
        aSelectedItem.splice(0, aSelectedItem.length);
        handleTotal(settings.json.total_claim_amount);
      },
    });
  };
  var handleTotal = function (total) {
    const value_total = total;
    $("#total-claim-amount").val(value_total);
  };
  var handleAddDeleteAselected = function (value, parentElement) {
    var check_value = $.inArray(value, aSelectedItem);
    if (check_value !== -1) {
      $(parentElement).removeClass("table-info");
      aSelectedItem.splice(check_value, 1);
    } else {
      $(parentElement).addClass("table-info");
      aSelectedItem.push(value);
    }

    handleBtnDisableEnable();
    handleDeletItem();
  };

  var handleBtnDisableEnable = function () {
    if (aSelectedItem.length > 0) {
      $("#btn-delete-item").removeAttr("disabled");
    } else {
      $("#btn-delete-item").attr("disabled", "");
    }
  };

  var handleDeletItem = function () {
    $("#btn-delete-item").click(function (e) {
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
            url: url + "app/flexy-allowance/allowance-request-detail-route.php",
            data: {
              action: "delete-item",
              _token: csrf_token,
              ids: aSelectedItem,
            },
            success: function (response) {
              if (response.success == true) {
                Swal.fire("Deleted!", "Your file has been deleted.", "success");
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
  //get detail allowance request to show in card (upper area) end

  // section form Allowance Request Detail start
  //get dropdown activity
  var handleActivity = function () {
    $("#activity").select2({
      // minimumInputLength: 1,
      allowClear: true,
      placeholder: "Select Activity",
      dataType: "json",
      ajax: {
        method: "POST",

        url: url + "app/flexy-allowance/allowance-request-detail-route.php",

        data: function (params) {
          return {
            _token: csrf_token,
            action: "get-activity",
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
    getDetailActivity();
  };
  // ada bug jika di clear company dropdown, ajax get cost center terkirim
  var handleResetActivityDropdown = function () {
    $("#activity").on("select2:unselecting", function (e) {
      $("#detail-activity").empty();
      $("#deskripsi").val("");
      toastr.success("reset selection success");
      $("#detail-activity").select2({
        placeholder: "Select Detail Activity",
      });
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

  var getDetailActivity = function () {
    $("#activity").change(function (e) {
      e.preventDefault();
      const activityId = $(this).val();
      $.ajax({
        type: "post",
        url: url + "app/flexy-allowance/allowance-request-detail-route.php",
        data: {
          activity: activityId,
          _token: csrf_token,
          action: "get-activity-detail",
        },
        dataType: "json",
        success: function (response) {
          const responseValue = response.item;
          // Check if the new data is different from the current data
          if (!arraysEqual(responseValue, $("#detail-activity").select2())) {
            // Clear existing options
            $("#detail-activity").empty();
            $("#deskripsi").val("");

            // Populate Select2 dropdown with new data
            $("#detail-activity").select2({
              data: responseValue,
            });
          }
          handleFillDescription();
        },
      });
    });
  };

  // Function to check if two arrays are equal
  function arraysEqual(arr1, arr2) {
    if (arr1.length !== arr2.length) return false;
    for (var i = 0; i < arr1.length; i++) {
      if (arr1[i].id !== arr2[i].id || arr1[i].text !== arr2[i].text)
        return false;
    }
    return true;
  }
  //fungsi isi deksripsi
  var handleFillDescription = function () {
    $("#detail-activity").change(function (e) {
      e.preventDefault();
      const selectedText = $("#detail-activity").find(":selected").text();
      $("#deskripsi").val(selectedText);
    });
  };
  //fungsi cek Claim Amount
  var handleClaimAmount = function () {
    var hasilLimit = $.ajax({
      type: "post",
      async: false,
      url: url + "app/flexy-allowance/limit-statistik2.php",
      data: {
        _token: csrf_token,
      },
      dataType: "json",
      success: function (response) {
        var limitData = {
          // Ganti 'your_parameter_value' dengan nilai parameter yang sebenarnya
          limit: response.limit,
          remain: response.remain,
        };
        // Panggil resolve untuk menyelesaikan Promise
        return limitData;
      },
    });
    const userLimit = hasilLimit.responseJSON.limit;
    const userRemainBalance = hasilLimit.responseJSON.remain;

    $("#jumlah-biaya-bon").on("keyup change", function () {
      if ($(this).val() === "") {
        // Set the input as readonly if the value is empty
        $("#jumlah-biaya-klaim").prop("readonly", true);
      } else {
        // Remove readonly if the value is not empty
        $("#jumlah-biaya-klaim").prop("readonly", false);
      }
    });
    // cek biaya klaim terhadap saldo sisa
    $("#jumlah-biaya-klaim").on("keyup", function () {
      const claimAmount = $("#jumlah-biaya-klaim").val();
      const totalAmount = parseInt($("#jumlah-biaya-bon").val());
      const intClaimAmount = parseInt(claimAmount);
      const intUserRemain = parseInt(userRemainBalance);
      const intUserLimit = parseInt(userLimit);

      //jika total klaim lebih besar daripada total bon
      if (intClaimAmount > totalAmount && intClaimAmount > intUserRemain) {
        $("#valid-invalid-biaya-klaim").html(
          "insufficient balance & claim amount cannot exceed total amount!"
        );
        toastr.error(
          "insufficient balance & claim amount cannot exceed total amount!"
        );
        $(".biaya-claim").addClass("is-invalid");
        $("#btn-save-detail").attr("disabled", "disabled");
      }
      //jika total klaim lebih besar dari saldo sisa
      else if (intClaimAmount > intUserRemain) {
        $("#valid-invalid-biaya-klaim").html("insufficient balance!");
        toastr.error("insufficient balance!");
        $(".biaya-claim").addClass("is-invalid");
        $("#btn-save-detail").attr("disabled", "disabled");
      }
      //jika keduanya terpenuhi
      else if (intClaimAmount > totalAmount) {
        $("#valid-invalid-biaya-klaim").html(
          "claim amount cannot exceed total amount!"
        );
        toastr.error("claim amount cannot exceed total amount!");
        $(".biaya-claim").addClass("is-invalid");
        $("#btn-save-detail").attr("disabled", "disabled");
      } else {
        $(".biaya-claim").removeClass("is-invalid");
        $("#btn-save-detail").removeAttr("disabled");
      }
    });
  };

  var handleSelect2 = function () {
    $("#detail-activity").select2({
      placeholder: "Select/Type Detail Activity",
    });
  };
  // validasi tanggal, tidak boleh ambil tanggal future(hari esok dst)
  var handleDateCheck = function () {
    $("#date-activity").change(function (e) {
      e.preventDefault();
      var currentDate = new Date();

      // Mendapatkan tanggal, bulan, dan tahun dari tanggal saat ini
      var day = currentDate.getDate();
      var month = currentDate.getMonth() + 1; // Penambahan 1 karena indeks bulan dimulai dari 0
      var year = currentDate.getFullYear();

      // Format tanggal, bulan, dan tahun ke dalam format "yyyy-mm-dd"
      var formattedDate =
        year +
        "-" +
        (month < 10 ? "0" : "") +
        month +
        "-" +
        (day < 10 ? "0" : "") +
        day;

      var dateValue = $(this).val();
      if (dateValue > formattedDate) {
        $("#valid-invalid-date-activity").html(
          "upcoming dates are not allowed!"
        );
        toastr.error("upcoming dates are not allowed!");
        $("#date-activity").addClass("is-invalid");
        $("#btn-save-detail").attr("disabled", "disabled");
      } else {
        $("#date-activity").removeClass("is-invalid");
        $("#btn-save-detail").removeAttr("disabled");
      }
    });
  };

  //simpan data detail allowance
  var handleSubmitDetailAllowance = function () {
    $("#btn-back").click(function (e) {
      e.preventDefault();
      window.location.href =
        url + "view/flexy-allowance/allowance-user-index.php";
    });
    handleDateCheck();

    $("#form-allowance-detail").submit(function (e) {
      e.preventDefault();
      const form = $(this);
      let formData = new FormData(form[0]);

      if (confirm("Is it correct?")) {
        $.ajax({
          type: "POST",
          url: url + "app/flexy-allowance/allowance-request-detail-route.php",
          data: formData,
          processData: false,
          contentType: false,
          success: function (response) {
            toastr.success(response.data);
            setTimeout(() => {
              location.reload();
            }, 3500);
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
  // section form Allowance Request Detail end

  return {
    init: function () {
      handleSelect2();
      handleActivity();
      handleResetActivityDropdown();
      handleSelect2();
      handleClaimAmount();
      getDetailAllowance();
      handleSubmitDetailAllowance();
      handleItemData();
    },
  };
})();

$(document).ready(function () {
  Index.init();
});
