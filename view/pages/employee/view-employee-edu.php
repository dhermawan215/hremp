<!DOCTYPE html>
<html lang="en">
<?php include_once('../../layout/header.php');
session_start();
include('../../../app/config/is_session.php');
date_default_timezone_set('Asia/Jakarta');

if (isset($_GET['dataId'])) {
    $id = base64_decode($_GET['dataId']);
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

                    <h1 class="h3 mb-3"><strong> View Employee </strong>Menu </h1>
                    <div class="row">

                        <div class="card">
                            <div class="card-header">
                                Menu Detail Karyawan
                            </div>
                            <div class="card-body">
                                <div class="row justify-content-center">
                                    <div class="col-md-2">
                                        <div class="card">
                                            <a href="<?= $url . ('/view/pages/employee/view-employee.php?dataId=') . $_GET['dataId'] ?>" class="btn btn-outline-primary">Karyawan</a>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="card">
                                            <a href="<?= $url . ('/view/pages/employee/view-employee-personal.php?dataId=') . $_GET['dataId'] ?>" class="btn btn-outline-primary">Pribadi</a>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="card">
                                            <a href="<?= $url . ('/view/pages/employee/view-employee-personal-address.php?dataId=') . $_GET['dataId'] ?>" class="btn btn-outline-primary">Alamat</a>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="card">
                                            <a href="<?= $url . ('/view/pages/employee/view-employee-edu.php?dataId=') . $_GET['dataId'] ?>" class="btn btn-outline-primary active">Pendidikan</a>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="card">
                                            <a href="<?= $url . ('/view/pages/employee/view-employee-family.php?dataId=') . $_GET['dataId'] ?>" class="btn btn-outline-primary">Keluarga</a>
                                        </div>
                                    </div>

                                </div>
                                <div class="row justify-content-center">
                                    <div class="col-md-2">
                                        <div class="card">
                                            <a href="<?= $url . ('/view/pages/employee/view-employee-emergency.php?dataId=') . $_GET['dataId'] ?>" class="btn btn-outline-primary">Kontak Darurat</a>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="card">
                                            <a href="<?= $url . ('/view/pages/employee/view-employee-payroll.php?dataId=') . $_GET['dataId'] ?>" class="btn btn-outline-primary">Payroll</a>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="card">
                                            <a href="<?= $url . ('/view/pages/employee/view-employee-kontrak.php?dataId=') . $_GET['dataId'] ?>" class="btn btn-outline-primary">Kontrak Kerja</a>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="card">
                                            <a href="<?= $url . ('/view/pages/employee/view-employee-experience.php?dataId=') . $_GET['dataId'] ?>" class="btn btn-outline-primary">Pengalaman Kerja</a>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="card">
                                            <a href="<?= $url . ('/view/pages/employee/view-employee-history.php?dataId=') . $_GET['dataId'] ?>" class="btn btn-outline-primary">History</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="h5 fw-bold">View Data Pendidikan Karyawan: <span id="karyawanName" class="text-primary"></span></h5>

                            </div>
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="form-check mb-2 me-2">
                                        <input class="form-check-input" type="checkbox" value="1" id="editControl">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Edit Data
                                        </label>
                                    </div>
                                    <div class="ms-2">
                                        <button id="btnEduNull" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modalEduifNull">Tambah Data Pendidikan Karyawan</button>
                                    </div>
                                </div>
                                <form id="formEmployeePersonalEdu" action="javascript:;" method="post">
                                    <input type="hidden" name="_token" value="<?= $csrf_token ?>">
                                    <input type="hidden" name="emp_id" id="emp_id" value="<?= $id ?>">
                                    <input type="hidden" name="idData" id="idData">

                                    <div class="mb-3">
                                        <label for="pendidikanTerakhir" class="form-label">Pendidikan Terakhir</label>
                                        <select name="pendidikan_terakhir" id="pendidikanTerakhir" class="form-control">

                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="jurusan" class="form-label">Jurusan</label>
                                        <input type="text" name="jurusan" id="jurusan" class="form-control" placeholder="Jurusan: eg. teknik kimia">
                                    </div>
                                    <div class="mb-3">
                                        <label for="asal_sekolah" class="form-label">Asal Sekolah</label>
                                        <input type="text" name="asal_sekolah" id="asal_sekolah" class="form-control" placeholder="Asal Sekolah: eg. Institut Teknologi Bandung">
                                    </div>
                                    <div class="mb-3">
                                        <button type="submit" class="btn btn-success" id="btnUpdated">Update</button>
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
    <!-- modal tambah data pendidikan jika null -->
    <div class="modal fade" id="modalEduifNull" tabindex="-1" aria-labelledby="modalEduifNull" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Formulir Tambah Data Pendidikan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formAddEdu" action="javascript:;" method="post">
                        <input type="hidden" name="_token" value="<?= $csrf_token ?>">
                        <input type="hidden" name="emp_id" id="" value="<?= $id ?>">

                        <div class="mb-3">
                            <label for="pendidikanTerakhir" class="form-label">Pendidikan Terakhir</label>
                            <select name="pendidikan_terakhir" id="" class="form-control">
                                <option value="null" selected>-Pilih Data-</option>
                                <option value="SD">SD</option>
                                <option value="SMP">SMP</option>
                                <option value="SMA/SMK">SMA/SMK</option>
                                <option value="D3">D3</option>
                                <option value="D4">D4</option>
                                <option value="S1">S1</option>
                                <option value="S2">S2</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="jurusan" class="form-label">Jurusan</label>
                            <input type="text" name="jurusan" id="" class="form-control" placeholder="Jurusan: eg. teknik kimia">
                        </div>
                        <div class="mb-3">
                            <label for="asal_sekolah" class="form-label">Asal Sekolah</label>
                            <input type="text" name="asal_sekolah" id="" class="form-control" placeholder="Asal Sekolah: eg. Institut Teknologi Bandung">
                        </div>
                        <div class="mb-3">
                            <button type="submit" class="btn btn-success" id="btnAddifNull">Simpan</button>
                            <!-- <button class="btn btn-danger" id="btnBack">Back</button> -->
                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- end modal tambah data pendidikan jika null -->

    <?php include_once('../../layout/js.php') ?>
    <script src="<?= $url . ('/public/select2-4.1.0/dist/js/select2.min.js') ?>"></script>
    <script src="<?= $url . ('/public/employee/view-employee-personal-edu.min.js?q=') . time() ?>"></script>
</body>