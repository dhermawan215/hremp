var Index = (function () {
  const csrf_token = $('meta[name="csrf-token"]').attr("content");

  //get detail allowance request to show in card (upper area) start
  //get detail allowance request to show in card (upper area) end

  // section form Allowance Request Detail start
  //get dropdown activity
  var handleActivity = function () {
    $("#activity").select2({
      // minimumInputLength: 1,
      allowClear: true,
      placeholder: "Select company/Type company name",
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
      const intClaimAmount = parseInt(claimAmount);
      const intUserRemain = parseInt(userRemainBalance);
      const intUserLimit = parseInt(userLimit);

      if (intClaimAmount > intUserRemain) {
        $("#valid-invalid-biaya-klaim").html("insufficient balance!");
        toastr.error("insufficient balance!");
        $("#jumlah-biaya-klaim").addClass("is-invalid");
        $("#btn-save-detail").attr("disabled", "disabled");
      } else {
        $("#jumlah-biaya-klaim").removeClass("is-invalid");
        $("#btn-save-detail").removeAttr("disabled");
      }
    });
  };

  var handleSelect2 = function () {
    $("#detail-activity").select2({
      placeholder: "Select/Type Detail Activity",
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
    },
  };
})();

$(document).ready(function () {
  Index.init();
});
