<!DOCTYPE html>
<html lang="en">
<?php include_once('../../layout/header.php');
session_start();
include('../../../app/config/is_session.php');
date_default_timezone_set('Asia/Jakarta');

if (isset($_GET['dataId']) && isset($_GET['dataStatus'])) {
    $id = base64_decode($_GET['dataId']);
    $status = base64_decode($_GET['dataStatus']);

    $dataContent = '2';
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
                                <h5 class="h5 fw-bold">Tambah Data Karyawan: Bagian Data Pribadi Karyawan: <span id="karyawanName" class="text-primary"></span></h5>
                            </div>
                            <div class="card-body">
                                <form id="formEmployeePersonal" action="javascript:;" method="post">
                                    <input type="hidden" name="_token" value="<?= $csrf_token ?>">
                                    <input type="hidden" name="emp_id" id="emp_id" value="<?= $id ?>">
                                    <div class="mb-3">
                                        <label for="tempatLahir" class="form-label">Tempat Lahir Karyawan</label>
                                        <input type="text" name="tempat_lahir" class="form-control" id="tempatLahir" placeholder="Tempat Lahir Karyawan">
                                    </div>
                                    <div class="mb-3">
                                        <label for="tanggalLahir" class="form-label">Tanggal Lahir Karyawan</label>
                                        <input type="date" name="tanggal_lahir" class="form-control" id="tanggalLahir" placeholder="Tanggal Lahir Karyawan">
                                    </div>
                                    <div class="mb-3">
                                        <label for="statusPernikahan" class="form-label">Status Pernikahan Karyawan</label>
                                        <select name="status_pernikahan" id="statusPernikahan" class="form-control">
                                            <option selected>- Pilih Status Pernikahan -</option>
                                            <option value="Belum Menikah">Belum Menikah</option>
                                            <option value="Menikah">Menikah</option>
                                            <option value="Cerai Hidup">Cerai Hidup</option>
                                            <option value="Cerai Mati">Cerai Mati</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="agama" class="form-label">Agama</label>
                                        <input type="text" name="agama" id="agama" class="form-control" placeholder="Input Agama">
                                    </div>
                                    <div class="mb-3">
                                        <label for="gender" class="form-label">Jenis Kelamin</label>
                                        <select name="gender" id="gender" class="form-control">
                                            <option value="Laki-Laki">Laki-Laki</option>
                                            <option value="Perempuan">Perempuan</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="nik" class="form-label">Nomer Induk Kependudukan</label>
                                        <input type="text" name="nik" id="nik" class="form-control" placeholder="NIK Karyawan">
                                    </div>
                                    <div class="mb-3">
                                        <label for="golonganDarah" class="form-label">Golongan Darah</label>
                                        <select name="golongan_darah" id="golonganDarah" class="form-control">
                                            <option value="null" selected>- Pilih Golongan Darah -</option>
                                            <option value="O">O</option>
                                            <option value="A">A</option>
                                            <option value="B">B</option>
                                            <option value="AB">AB</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email Pribadi</label>
                                        <input type="email" name="email" class="form-control" id="email" placeholder="Email Pribadi Karyawan">
                                    </div>
                                    <div class="mb-3">
                                        <label for="no_hp" class="form-label">Nomor HP Karyawan</label>
                                        <input type="text" name="no_hp" class="form-control" id="no_hp" placeholder="No HP Karyawan">
                                    </div>
                                    <div class="mb-3">
                                        <label for="no_hp" class="form-label">NPWP</label>
                                        <input type="text" name="npwp" class="form-control" id="npwp" placeholder="NPWP Karyawan">
                                    </div>
                                    <div class="mb-3">
                                        <label for="no_hp" class="form-label">NPWP Pemadanan(16 digit)</label>
                                        <input type="text" name="npwp_pemadanan" class="form-control" id="npwp_pemadanan" placeholder="NPWP Pemadanan(16 digit) Karyawan">
                                    </div>
                                    <div class="mb-3">
                                        <label for="domisili" class="form-label">Domisili Karyawan</label>
                                        <input type="text" name="domisili" class="form-control" id="domisili" placeholder="Domisili Karyawan">
                                    </div>
                                    <div class="mb-3">
                                        <button type="submit" class="btn btn-success">Save & Next</button>
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
    <script src="<?= $url . ('/public/employee/employee-personal.min.js?q=') . time() ?>"></script>
</body>