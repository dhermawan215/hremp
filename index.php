<!DOCTYPE html>
<html lang="en">
<?php include_once('view/layout/header.php');
session_start();
include('app/config/is_session.php');
date_default_timezone_set('Asia/Jakarta');
?>
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">

<body>
    <div class="wrapper">
        <?php include('view/layout/sidebar.php'); ?>

        <div class="main">
            <?php include('view/layout/navbar.php'); ?>

            <main class="content">
                <div class="container-fluid p-0">

                    <h1 class="h3 mb-3"><strong>Dashboard</strong> App</h1>

                    <div class="row">
                        <div class="col-xl-6 col-xxl-5 d-flex">
                            <div class="w-100">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col mt-0">
                                                        <h5 class="card-title">Karyawan Aktif</h5>
                                                    </div>
                                                </div>
                                                <h1 class="mt-1 mb-3" id="totalKaryawan"></h1>
                                            </div>
                                        </div>
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col mt-0">
                                                        <h5 class="card-title">Karyawan Resign</h5>
                                                    </div>
                                                </div>
                                                <h1 class="mt-1 mb-3" id="totalKaryawanResign"></h1>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col mt-0">
                                                        <h5 class="card-title">Time</h5>
                                                    </div>

                                                    <div class="col-auto">
                                                        <div class="stat text-primary">
                                                            <i class="align-middle" data-feather="clock"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                                <h1 id="datetimepicker-time" class="mt-1 mb-3"></h1>
                                                <span class="text-muted fw-bold">Date: <?= date('d-m-Y') ?></span>
                                                <div class="mb-0">
                                                    <span class="text-danger"> <i class="mdi mdi-arrow-bottom-right"></i> GMT +7 </span>
                                                    <span class="text-muted fw-bold">Jakarta</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-6">
                            <div class="card">
                                <div class="card-header">

                                    <h5 class="card-title mb-0">Calendar</h5>
                                </div>
                                <div class="card-body d-flex">
                                    <div class="align-self-center w-100">
                                        <div class="chart">
                                            <div id="datetimepicker-dashboard"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-2">

                        <div class="col-12 col-lg-4">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Data Karyawan Aktif Berdasarkan Company</h3>
                                </div>
                                <div class="card-body">
                                    <div class="chart chart-sm">
                                        <div id="donut-company" class="morris-donut-inverse"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-4">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Data Karyawan Aktif Berdasarkan Jenis Kelamin</h3>
                                </div>
                                <div class="card-body">
                                    <div class="chart chart-sm">
                                        <div id="donut-gender" class="morris-donut-inverse"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-4">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Data Karyawan Aktif Berdasarkan status</h3>
                                </div>
                                <div class="card-body">
                                    <div class="chart chart-sm">
                                        <div id="donut-status" class="morris-donut-inverse"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
            <?php include_once('view/layout/footer.php') ?>
        </div>
    </div>

    <?php include_once('view/layout/js.php') ?>
    <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var date = new Date(Date.now() - 0 * 24 * 60 * 60 * 1000);
            var defaultDate = date.getUTCFullYear() + "-" + (date.getUTCMonth() + 1) + "-" + date.getUTCDate();
            document.getElementById("datetimepicker-dashboard").flatpickr({
                inline: true,
                prevArrow: "<span title=\"Previous month\">&laquo;</span>",
                nextArrow: "<span title=\"Next month\">&raquo;</span>",
                defaultDate: defaultDate
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            setInterval('updateClock()', 1000);
        });

        function updateClock() {
            var currentTime = new Date();
            var currentHours = currentTime.getHours();
            var currentMinutes = currentTime.getMinutes();
            var currentSeconds = currentTime.getSeconds();

            // Pad the minutes and seconds with leading zeros, if required
            currentMinutes = (currentMinutes < 10 ? "0" : "") + currentMinutes;
            currentSeconds = (currentSeconds < 10 ? "0" : "") + currentSeconds;

            // Choose either "AM" or "PM" as appropriate
            // var timeOfDay = (currentHours < 12) ? "AM" : "PM";

            // Convert the hours component to 12-hour format if needed
            // currentHours = (currentHours > 12) ? currentHours - 12 : currentHours;

            // // Convert an hours component of "0" to "12"
            // currentHours = (currentHours == 0) ? 12 : currentHours;

            // Compose the string for display
            var currentTimeString = currentHours + ":" + currentMinutes + ":" + currentSeconds;


            $("#datetimepicker-time").html(currentTimeString);
        }
    </script>
    <!-- <script>
        $(document).ready(function() {
            $('.logout').click(function(e) {
                const form = $(this).closest("form");
                const name = $(this).data("name");
                e.preventDefault();
                Swal.fire({
                    title: 'Are you sure you want to exit?',
                    text: "last chance to back out",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Good bye'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                })

            });
        });
    </script> -->

    <script>
        const csrf_token = $('meta[name="csrf-token"]').attr("content");
        $(document).ready(function() {
            dataCompany();
            dataGender();
            dataStatus();

            function dataCompany() {
                var count;
                $.ajax({
                    type: "POST",
                    // async: false,
                    url: url + 'app/ajax/karyawan-statistik.php',
                    data: {
                        _token: csrf_token,
                    },
                    success: function(response) {
                        $("#totalKaryawan").html(response.total_active);
                        $("#totalKaryawanResign").html(response.total_resign);
                        Morris.Donut({
                            element: 'donut-company',
                            resize: true,
                            colors: [
                                '#E0F7FA',
                                '#B2EBF2',
                                '#80DEEA',
                                '#4DD0E1',
                                '#26C6DA',
                                '#00BCD4',
                                '#00ACC1',
                                '#0097A7',
                                '#00838F',
                                '#006064'
                            ],
                            //labelColor:"#cccccc", // text color
                            //backgroundColor: '#333333', // border color
                            data: response['data'],
                        });

                    }
                });

            }

            function dataGender() {
                $.ajax({
                    type: "POST",
                    // async: false,
                    url: url + 'app/ajax/karyawan-statistik-gender.php',
                    data: {
                        _token: csrf_token,
                    },
                    success: function(response) {
                        Morris.Donut({
                            element: 'donut-gender',
                            resize: true,
                            colors: [
                                '#E0F7FA',
                                '#B2EBF2',
                                '#80DEEA',
                                '#4DD0E1',
                                '#26C6DA',
                                '#00BCD4',
                                '#00ACC1',
                                '#0097A7',
                                '#00838F',
                                '#006064'
                            ],
                            //labelColor:"#cccccc", // text color
                            //backgroundColor: '#333333', // border color
                            data: response,
                        });

                    }
                });

            }

            function dataStatus() {
                $.ajax({
                    type: "POST",
                    // async: false,
                    url: url + 'app/ajax/karyawan-statistik-status.php',
                    data: {
                        _token: csrf_token,
                    },
                    success: function(response) {
                        Morris.Donut({
                            element: 'donut-status',
                            resize: true,
                            colors: [
                                '#E0F7FA',
                                '#B2EBF2',
                                '#80DEEA',
                                '#4DD0E1',
                                '#26C6DA',
                                '#00BCD4',
                                '#00ACC1',
                                '#0097A7',
                                '#00838F',
                                '#006064'
                            ],
                            //labelColor:"#cccccc", // text color
                            //backgroundColor: '#333333', // border color
                            data: response,
                        });

                    }
                });

            }

        });
    </script>

</body>

</html>