var Index = (function () {
  const csrf_token = $('meta[name="csrf-token"]').attr("content");
  var table;

  var handleData = function () {
    table = $("#tableUserMg").DataTable({
      responsive: true,
      autoWidth: true,
      pageLength: 10,
      searching: true,
      paging: true,
      lengthMenu: [
        [10, 25, 50],
        [10, 25, 50],
      ],
      language: {
        info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
        infoEmpty: "Menampilkan 0 - 0 dari 0 data",
        infoFiltered: "",
        zeroRecords: "Data tidak di temukan",
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
        url: url + "app/ajax/user-mg.php",
        type: "POST",
        data: {
          _token: csrf_token,
        },
      },
      columns: [
        { data: "rnum", orderable: false },
        { data: "name", orderable: false },
        { data: "email", orderable: false },
        { data: "roles", orderable: false },
        { data: "active", orderable: false },
        { data: "action", orderable: false },
      ],
    });
  };

  var handleActiveUser = function () {
    $(document).on("change", ".activeuser", function () {
      if ($(this).is(":checked")) {
        const cbxVal = $(this).data("toggle");
        const activeVal = true;

        $.ajax({
          type: "POST",
          url: `${url}app/ajax/user-mgs.php`,
          data: {
            _token: csrf_token,
            cbxValue: cbxVal,
            acValue: activeVal,
          },

          success: function (response) {
            let obj = response.success;

            if (obj === true) {
              toastr.success(response.data);

              // table.ajax.reload();
            } else {
              $.each(response.data, function (key, value) {
                toastr.error(value);
              });
            }
          },
        });
      } else {
        const cbxVal = $(this).data("toggle");
        const activeVal = false;

        // console.log(cbxVal);
        // console.log(activeVal);

        $.ajax({
          type: "POST",
          url: `${url}app/ajax/user-mgs.php`,
          data: {
            _token: csrf_token,
            cbxValue: cbxVal,
            acValue: activeVal,
          },

          success: function (response) {
            let obj = response.success;

            if (obj === true) {
              toastr.success(response.data);

              // table.ajax.reload();
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
      handleData();
      handleActiveUser();
    },
  };
})();

$(document).ready(function () {
  Index.init();
});
