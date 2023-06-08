<!DOCTYPE html>
<html lang="en">
<?php include_once('../../layout/header.php');
session_start();
include('../../../app/config/is_session.php');
date_default_timezone_set('Asia/Jakarta');

if (isset($_GET['dataId']) && isset($_GET['dataStatus'])) {
    $id = base64_decode($_GET['dataId']);
    $status = base64_decode($_GET['dataStatus']);
} else {
    echo "<script>
    document.location.href='$url';
    </script>";
}
?>

<body>
    <div class="wrapper">
        <?php include('../../layout/sidebar.php'); ?>

        <div class="main">
            <?php include('../../layout/navbar.php'); ?>

            <main class="content">
                <div class="container-fluid p-0">

                    <h1 class="h3 mb-3"><strong> Add Employee </strong>Menu </h1>

                    <div class="row">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="h5 fw-bold">Tambah Data Karyawan: Bagian Data Masa Kerja Kontrak/Harian/OutSourcing/Intern, Karyawan: <span id="karyawanName" class="text-primary"></span></h5>
                            </div>
                            <div class="card-body">
                                <p>Status Karyawan: <span class="fw-bold text-danger" id="statusKerja"></span></p>
                                <form id="formEmployeeKontrak" action="javascript:;" method="post">
                                    <input type="hidden" name="_token" value="<?= $csrf_token ?>">
                                    <input type="hidden" name="emp_id" id="emp_id" value="<?= $id ?>">
                                    <div class="mb-3">
                                        <label for="awal_kontrak" class="form-label">Awal Kontak</label>
                                        <input type="date" name="awal_kontrak" id="awal_kontrak" class="form-control">
                                    </div>
                                    <div class="mb-3">
                                        <label for="akhir_kontrak" class="form-label">Akhir kontrak</label>
                                        <input type="date" name="akhir_kontrak" id="akhir_kontrak" class="form-control">
                                    </div>
                                    <div class="mb-3">
                                        <label for="keterangan" class="form-label">Keterangan</label>
                                        <input type="text" name="keterangan" id="keterangan" class="form-control">
                                    </div>
                                    <div class="mb-3">
                                        <button type="submit" class="btn btn-success">Save</button>
                                        <!-- <button class="btn btn-danger" id="btnBack">Back</button> -->
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
            <?php include_once('../../layout/footer.php') ?>
        </div>
    </div>

    <?php include_once('../../layout/js.php') ?>
    <script src="<?= $url . ('/public/select2-4.1.0/dist/js/select2.min.js') ?>"></script>
    <script src="<?= $url . ('/public/employee/employee-kontrak.min.js?q=') . time() ?>"></script>
</body>