var Index = (function () {
  const csrf_token = $('meta[name="csrf-token"]').attr("content");
  var itemId = $("#item").val();
  // fungsi ambil edit data item detail
  var handleEdit = function () {
    $.ajax({
      type: "POST",
      async: false,
      url: url + "app/flexy-allowance/allowance-request-detail-route.php",
      data: {
        _token: csrf_token,
        item: itemId,
        action: "edit-item",
      },
      dataType: "json",
      success: function (response) {
        $("#deskripsi").val(response.deskripsi);
        $("#insured-name").val(response.nama_tertanggung);
        $("#jumlah-biaya-bon").val(response.jumlah_biaya_bon);
        $("#jumlah-biaya-klaim").val(response.jumlah_biaya_klaim);
        $("#date-activity").val(response.tanggal_aktivitas);
        $("#activity").append(
          $("<option>", {
            value: response.aktivitas,
            text: response.nama_aktivitas,
            attr: "selected",
          })
        );
        $("#detail-activity").append(
          $("<option>", {
            value: response.aktivitas_detail,
            text: response.nama_detail,
            attr: "selected",
          })
        );
        $("#dependents-category").append(
          $("<option>", {
            value: response.kategori_tertanggung,
            text: response.kategori_tertanggung_nama,
            attr: "selected",
          })
        );
      },
    });
  };
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
  //  ketika tombol x dropdown aktivitas di klik
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
  // fungsi untuk dropdown detail aktivitas
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
  // fungsi untuk mengambil nama keluarga tanggungan
  var getFamilyInsure = function () {
    $("#dependents-category").change(function (e) {
      e.preventDefault();
      const namaTanggungan = $(this).val();

      $.ajax({
        type: "post",
        url: url + "app/flexy-allowance/allowance-request-detail-route.php",
        data: {
          field: namaTanggungan,
          _token: csrf_token,
          action: "get-family-insured",
        },
        dataType: "json",
        success: function (response) {
          $("#insured-name").val(response.nama_tertanggung);
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
    $("#dependents-category").select2({
      // placeholder: "Please Select",
      data: [
        {
          id: "self",
          text: "Your self",
        },
        {
          id: "nama_suami_istri",
          text: "Husband/wife",
        },
        {
          id: "anak1",
          text: "First child",
        },
        {
          id: "anak2",
          text: "Second child",
        },
        {
          id: "anak3",
          text: "The third child",
        },
      ],
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
  var handleUpdateDetailAllowance = function () {
    $("#btn-back").click(function (e) {
      e.preventDefault();
      window.location.href =
        url + "view/flexy-allowance/allowance-detail.php?detail=" + noAllowance;
    });
    handleDateCheck();

    $("#form-allowance-detail-edit").submit(function (e) {
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
              window.location.href =
                url +
                "view/flexy-allowance/allowance-detail.php?detail=" +
                noAllowance;
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
      handleEdit();
      handleSelect2();
      handleActivity();
      handleResetActivityDropdown();
      handleClaimAmount();
      getFamilyInsure();
      handleUpdateDetailAllowance();
    },
  };
})();

$(document).ready(function () {
  Index.init();
});
