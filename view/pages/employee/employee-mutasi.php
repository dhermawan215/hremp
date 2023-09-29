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
                                <h5 class="h5 fw-bold">Form Perubahan Karyawan(Mutasi, Promosi, Rotasi, Demosi)</h5>
                                <p class="text-primary fw-bold">Nama Karyawan: <span id="karyawanName"></span></p>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="d-flex">
                                        <div class="form-check me-2">
                                            <input class="form-check-input" type="checkbox" value="1" id="mutasiCbx">
                                            <label class="form-check-label" for="mutasiCbx">
                                                Mutasi
                                            </label>
                                        </div>
                                        <div class="form-check me-2">
                                            <input class="form-check-input" type="checkbox" value="2" id="rotasiCbx">
                                            <label class="form-check-label" for="rotasiCbx">
                                                Rotasi
                                            </label>
                                        </div>
                                        <div class="form-check me-2">
                                            <input class="form-check-input" type="checkbox" value="3" id="promosiCbx">
                                            <label class="form-check-label" for="promosiCbx">
                                                Promosi
                                            </label>
                                        </div>
                                        <div class="form-check me-2">
                                            <input class="form-check-input" type="checkbox" value="4" id="demosiCbx">
                                            <label class="form-check-label" for="demosiCbx">
                                                Demosi
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="row mt-2">
                                    <form id="formEmployeeMutasi" action="javascript:;" method="post">
                                        <input type="hidden" name="_token" value="<?= $csrf_token ?>">
                                        <input type="hidden" name="emp_id" id="emp_id" value="<?= $karyawan ?>">
                                        <input type="hidden" name="cbxVal" id="cbxVal">
                                        <div class="mb-3">
                                            <label for="Company" class="form-label">Company Lama</label>
                                            <select name="comp_lama" id="CompanyLama" class="form-control">

                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="Company" class="form-label">Company Baru</label>
                                            <select name="comp_baru" id="CompanyBaru" class="form-control">

                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="departemenLama" class="form-label">Departemen Lama</label>
                                            <select name="dept_lama" id="departemenLama" class="form-control">

                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="departemenBaru" class="form-label">Departemen Baru</label>
                                            <select name="dept_baru" id="departemenBaru" class="form-control">

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
                                            <label for="perubahan_status" class="form-label">Jenis Perubahan Status</label>
                                            <select name="perubahan_status" id="perubahanStatus" class="form-control">
                                                <option selected>-Pilih Data-</option>
                                                <option value="ROTASI">ROTASI</option>
                                                <option value="MUTASI">MUTASI</option>
                                                <option value="PROMOSI">PROMOSI</option>
                                                <option value="DEMOSI">DEMOSI</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="keterangan" class="form-label">Keterangan</label>
                                            <input type="text" name="keterangan" class="form-control" id="keterangan_baru" placeholder="Keterangan">
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