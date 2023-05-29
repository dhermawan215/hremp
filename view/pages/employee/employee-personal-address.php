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
                                <h5 class="h5 fw-bold">Tambah Data Karyawan: Bagian Data Pribadi Karyawan: <span id="karyawanName" class="text-primary"></span></h5>
                            </div>
                            <div class="card-body">
                                <form id="formEmployeePersonal" action="javascript:;" method="post">
                                    <input type="hidden" name="_token" value="<?= $csrf_token ?>">
                                    <input type="hidden" name="emp_id" id="emp_id" value="<?= $id ?>">
                                    <div class="mb-3">
                                        <label for="alamatKtp" class="form-label">Alamat Sesuai KTP</label>
                                        <textarea name="alamat_ktp" id="alamatKtp" class="form-control" cols="30" rows="3"></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="kelurahan" class="form-label">Desa / Kelurahan</label>
                                        <input type="text" name="kelurahan" class="form-control" id="kelurahan" placeholder="Desa / Kelurahan">
                                    </div>
                                    <div class="mb-3">
                                        <div class="d-flex justify-content-around">
                                            <label for="kelurahan" class="form-label me-2">RT</label>
                                            <input type="text" name="rt" class="form-control" id="kelurahan" placeholder="RT">

                                            <label for="kelurahan" class="form-label ms-2 me-2">RW</label>
                                            <input type="text" name="rw" class="form-control" id="kelurahan" placeholder="RW">
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="kecamatan" class="form-label">Kecamatan</label>
                                        <input type="text" name="kecamatan" id="kecamatan" class="form-control" placeholder="Kecamatan">
                                    </div>
                                    <div class="mb-3">
                                        <label for="kota" class="form-label">Kabupaten / Kota</label>
                                        <input type="text" name="kota" id="kota" class="form-control" placeholder="Kabupaten / Kota">
                                    </div>
                                    <div class="mb-3">
                                        <label for="provinsi" class="form-label">Provinsi</label>
                                        <input type="text" name="provinsi" id="provinsi" class="form-control" placeholder="Provinsi">
                                    </div>


                                    <div class="mb-3">
                                        <label for="alamatLengkap" class="form-label">Alamat Lengkap</label>
                                        <textarea name="alamat_lengkap" class="form-control" id="alamatLengkap" cols="30" rows="5"></textarea>
                                    </div>

                                    <div class="mb-3">
                                        <label for="noTelp" class="form-label">No Telepon</label>
                                        <input type="text" name="no_telp" class="form-control" id="noTelp" placeholder="No Telepon">
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
    <script src="<?= $url . ('/public/employee/employee-personal-address.min.js?q=') . time() ?>"></script>
</body>