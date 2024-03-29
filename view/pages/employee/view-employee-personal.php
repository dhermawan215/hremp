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
                                            <a href="<?= $url . ('/view/pages/employee/view-employee-personal.php?dataId=') . $_GET['dataId'] ?>" class="btn btn-outline-primary active">Pribadi</a>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="card">
                                            <a href="<?= $url . ('/view/pages/employee/view-employee-personal-address.php?dataId=') . $_GET['dataId'] ?>" class="btn btn-outline-primary">Alamat</a>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="card">
                                            <a href="<?= $url . ('/view/pages/employee/view-employee-edu.php?dataId=') . $_GET['dataId'] ?>" class="btn btn-outline-primary">Pendidikan</a>
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
                                <h5 class="h5 fw-bold">View Data Pribadi Karyawan: <span id="karyawanName" class="text-primary"></span></h5>
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
                                        <button id="btnPersonalNull" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modalAddPersonalEmployee">Add Personal Data</button>
                                    </div>
                                </div>
                                <form id="formEmployeePersonal" action="javascript:;" method="post">
                                    <input type="hidden" name="_token" value="<?= $csrf_token ?>">
                                    <input type="hidden" name="emp_id" id="emp_id" value="<?= $id ?>">
                                    <input type="hidden" name="idData" id="idData">
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
                                        <select name="status_pernikahan" id="statusPernikahan" class="form-control statusPernikahan">

                                            <!-- <option value="Belum Menikah">Belum Menikah</option>
                                            <option value="Menikah">Menikah</option>
                                            <option value="Cerai Hidup">Cerai Hidup</option>
                                            <option value="Cerai Mati">Cerai Mati</option> -->
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="agama" class="form-label">Agama</label>
                                        <input type="text" name="agama" id="agama" class="form-control" placeholder="Input Agama">
                                    </div>
                                    <div class="mb-3">
                                        <label for="gender" class="form-label">Jenis Kelamin</label>
                                        <select name="gender" id="gender" class="form-control gender">
                                            <!-- <option value="Laki-Laki">Laki-Laki</option>
                                            <option value="Perempuan">Perempuan</option> -->
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="nik" class="form-label">Nomer Induk Kependudukan</label>
                                        <input type="text" name="nik" id="nik" class="form-control" placeholder="NIK Karyawan">
                                    </div>
                                    <div class="mb-3">
                                        <label for="golonganDarah" class="form-label">Golongan Darah</label>
                                        <select name="golongan_darah" id="golonganDarah" class="form-control golonganDarah">

                                            <!-- <option value="O">O</option>
                                            <option value="A">A</option>
                                            <option value="B">B</option>
                                            <option value="AB">AB</option> -->
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
                                        <button type="submit" id="btnUpdated" class="btn btn-success">Update</button>
                                        <a href="<?= $url . ('/view/pages/employee/') ?>" class="btn btn-danger" id="btnBack">Back</a>
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

    <!-- modal add personal data employee if null -->
    <div class="modal fade" id="modalAddPersonalEmployee" tabindex="-1" aria-labelledby="modalAddPersonalEmployee" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Form Add Employee Personal Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formPersonalifNull" action="javascript:;" method="post">
                        <input type="hidden" name="_token" value="<?= $csrf_token ?>">
                        <input type="hidden" name="emp_id" id="" value="<?= $id ?>">
                        <div class="mb-3">
                            <label for="tempatLahir" class="form-label">Tempat Lahir Karyawan</label>
                            <input type="text" name="tempat_lahir" class="form-control" id="" placeholder="Tempat Lahir Karyawan">
                        </div>
                        <div class="mb-3">
                            <label for="tanggalLahir" class="form-label">Tanggal Lahir Karyawan</label>
                            <input type="date" name="tanggal_lahir" class="form-control" id="" placeholder="Tanggal Lahir Karyawan">
                        </div>
                        <div class="mb-3">
                            <label for="statusPernikahan" class="form-label">Status Pernikahan Karyawan</label>
                            <select name="status_pernikahan" id="" class="form-control statusPernikahan">
                                <option value="Belum Menikah">Belum Menikah</option>
                                <option value="Menikah">Menikah</option>
                                <option value="Cerai Hidup">Cerai Hidup</option>
                                <option value="Cerai Mati">Cerai Mati</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="agama" class="form-label">Agama</label>
                            <input type="text" name="agama" id="" class="form-control" placeholder="Input Agama">
                        </div>
                        <div class="mb-3">
                            <label for="gender" class="form-label">Jenis Kelamin</label>
                            <select name="gender" id="" class="form-control gender">
                                <option value="Laki-Laki">Laki-Laki</option>
                                <option value="Perempuan">Perempuan</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="nik" class="form-label">Nomer Induk Kependudukan</label>
                            <input type="text" name="nik" id="" class="form-control" placeholder="NIK Karyawan">
                        </div>
                        <div class="mb-3">
                            <label for="golonganDarah" class="form-label">Golongan Darah</label>
                            <select name="golongan_darah" id="" class="form-control golonganDarah">
                                <option value="O">O</option>
                                <option value="A">A</option>
                                <option value="B">B</option>
                                <option value="AB">AB</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Pribadi</label>
                            <input type="email" name="email" class="form-control" id="" placeholder="Email Pribadi Karyawan">
                        </div>
                        <div class="mb-3">
                            <label for="no_hp" class="form-label">Nomor HP Karyawan</label>
                            <input type="text" name="no_hp" class="form-control" id="" placeholder="No HP Karyawan">
                        </div>
                        <div class="mb-3">
                            <label for="no_hp" class="form-label">NPWP</label>
                            <input type="text" name="npwp" class="form-control" id="" placeholder="NPWP Karyawan">
                        </div>
                        <div class="mb-3">
                            <label for="no_hp" class="form-label">NPWP Pemadanan(16 digit)</label>
                            <input type="text" name="npwp_pemadanan" class="form-control" id="" placeholder="NPWP Pemadanan(16 digit) Karyawan">
                        </div>
                        <div class="mb-3">
                            <label for="domisili" class="form-label">Domisili Karyawan</label>
                            <input type="text" name="domisili" class="form-control" id="" placeholder="Domisili Karyawan">
                        </div>
                        <div class="mb-3">
                            <button type="submit" id="btnSaveifNull" class="btn btn-success">Add Data</button>
                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <?php include_once('../../layout/js.php') ?>
    <script src="<?= $url . ('/public/select2-4.1.0/dist/js/select2.min.js') ?>"></script>
    <script src="<?= $url . ('/public/employee/view-employee-personal.min.js?q=') . time() ?>"></script>
</body>