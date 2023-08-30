<!DOCTYPE html>
<html lang="en">
<?php include_once('../../layout/header.php');
session_start();
include('../../../app/config/is_session.php');
date_default_timezone_set('Asia/Jakarta');

if (isset($_GET['karyawan'])) {
    $karyawan = $_GET['karyawan'];
    if (!$karyawan) {
        echo "<script>
        document.location.href='$url';
        </script>";
    }
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

                    <h1 class="h3 mb-3"><strong> Employee </strong>Menu </h1>

                    <div class="row">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="h5 fw-bold">Form Mutasi Karyawan</h5>
                                <p class="text-primary fw-bold">Nama Karyawan: <span id="karyawanName"></span></p>
                            </div>
                            <div class="card-body">
                                <form id="formEmployeeMutasi" action="javascript:;" method="post">
                                    <input type="hidden" name="_token" value="<?= $csrf_token ?>">
                                    <input type="hidden" name="emp_id" id="emp_id" value="<?= $karyawan ?>">
                                    <div class="mb-3">
                                        <label for="Company" class="form-label">Company Karyawan</label>
                                        <select name="comp_id" id="Company" class="form-control">

                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label for="periode_masuk" class="form-label">Periode Masuk</label>
                                        <input type="date" name="periode_masuk" class="form-control" id="periode_masuk">
                                    </div>
                                    <div class="mb-3">
                                        <label for="periode_keluar" class="form-label">Periode Keluar</label>
                                        <input type="date" name="periode_keluar" class="form-control" id="periode_keluar">
                                    </div>
                                    <div class="mb-3">
                                        <label for="jabatan" class="form-label">Jabatan Terakhir</label>
                                        <input type="text" name="jabatan" class="form-control" id="jabatan" placeholder="Jabatan Karyawan">
                                    </div>
                                    <div class="mb-3">
                                        <label for="jabatan" class="form-label">Jabatan Baru</label>
                                        <input type="text" name="jabatan_baru" class="form-control" id="jabatan_baru" placeholder="Jabatan Baru Karyawan">
                                    </div>

                                    <div class="mb-3">
                                        <button type="submit" id="btnEmployeeSave" class="btn btn-success">Save</button>
                                        <button class="btn btn-danger" id="btnBack">Back</button>
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
    <script src="<?= $url . ('/public/employee/employee-mutasi.min.js?q=') . time() ?>"></script>
</body>

</html>