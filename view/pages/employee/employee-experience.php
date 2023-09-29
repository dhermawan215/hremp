<!DOCTYPE html>
<html lang="en">
<?php include_once('../../layout/header.php');
session_start();
include('../../../app/config/is_session.php');
date_default_timezone_set('Asia/Jakarta');



if (isset($_GET['dataId']) && isset($_GET['dataStatus'])) {
    $id = base64_decode($_GET['dataId']);
    $status = base64_decode($_GET['dataStatus']);

    $dataContent = '9';
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
                    <?php include('list.php') ?>
                    <div class="row">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="h5 fw-bold">Tambah Data Karyawan: Bagian Data Pengalaman Kerja, Karyawan: <span id="karyawanName" class="text-primary"></span></h5>
                                <p>Form ini bisa di isi lebih dari 1x, setelah selesai silahkan klik next</p>
                            </div>
                            <div class="card-body">
                                <form id="formEmployeeAddPengalaman" action="javascript:;" method="post">
                                    <input type="hidden" name="_token" value="<?= $csrf_token ?>">
                                    <input type="hidden" name="emp_id" id="emp_id" value="<?= $id ?>">
                                    <div class="mb-3">
                                        <label for="perusahaan" class="form-label">Perusahaan</label>
                                        <input type="text" name="perusahaan" id="perusahaan" class="form-control">
                                    </div>
                                    <div class="mb-3">
                                        <label for="jabatan" class="form-label">Jabatan</label>
                                        <input type="text" name="jabatan" id="jabatan" class="form-control">
                                    </div>
                                    <div class="mb-3">
                                        <label for="periode_masuk" class="form-label">Tanggal Masuk</label>
                                        <input type="date" name="periode_masuk" id="periode_masuk" class="form-control">
                                    </div>
                                    <div class="mb-3">
                                        <label for="periode_keluar" class="form-label">Tanggal Keluar</label>
                                        <input type="date" name="periode_keluar" id="periode_keluar" class="form-control">
                                    </div>
                                    <div class="mb-3">
                                        <label for="keterangan" class="form-label">Keterangan</label>
                                        <input type="text" name="keterangan" id="keterangan" class="form-control">
                                    </div>
                                    <div class="mb-3">
                                        <button type="submit" class="btn btn-success" id="btnSave">Save</button>
                                        <button class="btn btn-primary" id="btnNext">Next</button>
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
    <script src="<?= $url . ('/public/employee/employee-experience.min.js?q=') . time() ?>"></script>
</body>