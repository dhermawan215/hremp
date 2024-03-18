var Index = (function () {
        const csrf_token = $('meta[name="csrf-token"]').attr("content");
        var table;


        //memunculkan tabel dokumen
        var handleDataAttachment = function () {
                table = $("#tableDocs").DataTable({
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
                        columnsDefs: [{
                                        searchable: false,
                                        target: [0, 1]
                                },
                                {
                                        orderable: false,
                                        target: 0
                                },
                        ],
                        processing: true,
                        serverSide: true,
                        ajax: {
                                url: url + "app/ajax/documents-data.php",
                                type: "POST",
                                data: {
                                        _token: csrf_token,
                                },
                        },
                        columns: [{
                                        data: "rnum",
                                        orderable: false
                                },
                                {
                                        data: "name",
                                        orderable: false
                                },
                                {
                                        data: "upload_time",
                                        orderable: false
                                },
                                {
                                        data: "action",
                                        orderable: false
                                },
                        ],
                });
                if (isMobile) {
                        $("#tableDocs tbody").on("click", "tr", function () {
                                handleShowPdfinMobile(table.row(this).data());
                                // console.log(table.row(this).data());
                        });
                } else {
                        $("#tableDocs tbody").on("click", "tr", function () {
                                // console.log(table.row(this).data());
                                handleShowPdfinDesktop(table.row(this).data());
                        });
                }
        };

        var handleDelete = function () {
                $(document).on("click", ".btndel", function () {
                        const id = $(this).data("id");
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
                                                url: url + "/app/ajax/documents-delete.php",
                                                data: {
                                                        _token: csrf_token,
                                                        ids: id,
                                                },
                                                success: function (response) {
                                                        if (response.success === true) {
                                                                Swal.fire("Deleted!", "Your file has been deleted.", "success");
                                                                table.ajax.reload();
                                                        } else {
                                                                Swal.fire({
                                                                        icon: "error",
                                                                        title: "Oops...",
                                                                        text: "Internal Server Error",
                                                                });
                                                        }
                                                },
                                                error: function (response) {
                                                        // Swal.fire({
                                                        // icon: "error",
                                                        // title: "Oops...",
                                                        // text: "Internal Server Error",
                                                        // });
                                                },
                                        });
                                }
                        });
                });
        };

        //submit dokumen
        var handleSubmitForm = function () {
                $("#upload-attachment").submit(function (e) {
                        e.preventDefault();

                        const form = $(this);
                        let formData = new FormData(form[0]);

                        $.ajax({
                                type: "POST",
                                url: url + "app/flexy-allowance/allowance-request-detail-route.php",
                                data: formData,
                                processData: false,
                                contentType: false,
                                Cache: false,
                                success: function (response) {
                                        let obj = response.success;

                                        if (obj === true) {
                                                $.each(response.data, function (key, value) {
                                                        toastr.success(value);
                                                });
                                                setTimeout(() => {
                                                        location.reload();
                                                }, 2000);
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

                        handleDelete();
                        handleSubmitForm();
                },
        };
})();

$(document).ready(function () {
        Index.init();
});