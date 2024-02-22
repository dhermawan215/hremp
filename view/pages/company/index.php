<!DOCTYPE html>
<html lang="en">
<?php
$route = 'company';
include_once('../../layout/header.php');
session_start();
include('../../../app/config/is_session.php');
date_default_timezone_set('Asia/Jakarta');
?>

<body>
    <div class="wrapper">
        <?php include('../../layout/sidebar.php'); ?>

        <div class="main">
            <?php include('../../layout/navbar.php'); ?>

            <main class="content">
                <div class="container-fluid p-0">

                    <h1 class="h3 mb-3"><strong>Company</strong> Dashboard</h1>

                    <div class="row">
                        <div class="card">
                            <div class="flex">
                                <button id="btnAddCompany" class="btn btn-success m-3 p-2">+ Tambah Data</button>
                            </div>
                            <div class="card-header">
                                <h5 class="h5 fw-bold">Company Data</h5>
                            </div>
                            <div class="card-body">

                                <table id="tableCompany" class="table table-striped" style="width:100%">
                                    <thead class="bg-primary text-white">
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Nama</th>
                                            <th scope="col">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>
                </div>
            </main>
            <?php include_once('../../layout/footer.php') ?>
        </div>
    </div>

    <?php include_once('../../layout/js.php') ?>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Datatables Responsive
            $("tableCompany").DataTable({
                responsive: true
            });
        });
    </script>
    <script src="<?= $url . ('/public/company/view.min.js?q=') . time() ?>"></script>
</body>

</html>