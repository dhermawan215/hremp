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
                                            <a href="<?= $url . ('/view/pages/employee/view-employee-personal-address.php?dataId=') . $_GET['dataId'] ?>" class="btn btn-outline-primary active">Alamat</a>
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
                                <h5 class="h5 fw-bold">View Data Alamat Pribadi Karyawan: <span id="karyawanName" class="text-primary"></span></h5>
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
                                        <button id="btnPersonalAddressNull" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modalAddPersonalAddressEmployee">Tambah Data Alamat Karyawan</button>
                                    </div>
                                </div>
                                <form id="formEmployeePersonal" action="javascript:;" method="post">
                                    <input type="hidden" name="_token" value="<?= $csrf_token ?>">
                                    <input type="hidden" name="emp_id" id="emp_id" value="<?= $id ?>">
                                    <input type="hidden" name="idData" id="idData">
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
                                            <input type="text" name="rt" class="form-control" id="rt" placeholder="RT">

                                            <label for="kelurahan" class="form-label ms-2 me-2">RW</label>
                                            <input type="text" name="rw" class="form-control" id="rw" placeholder="RW">
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
                                        <button type="submit" class="btn btn-success" id="btnUpdate">Update</button>
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
    <!-- modal tambah data alamat jika edit data kosong -->
    <div class="modal fade" id="modalAddPersonalAddressEmployee" tabindex="-1" aria-labelledby="modalAddPersonalAddressEmployee" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Form Add Employee Personal Address Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="employeAddressifNull" action="javascript:;" method="post">
                        <input type="hidden" name="_token" value="<?= $csrf_token ?>">
                        <input type="hidden" name="emp_id" id="" value="<?= $id ?>">
                        <div class="mb-3">
                            <label for="alamatKtp" class="form-label">Alamat Sesuai KTP</label>
                            <textarea name="alamat_ktp" id="" class="form-control" cols="30" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="kelurahan" class="form-label">Desa / Kelurahan</label>
                            <input type="text" name="kelurahan" class="form-control" id="" placeholder="Desa / Kelurahan">
                        </div>
                        <div class="mb-3">
                            <div class="d-flex justify-content-around">
                                <label for="kelurahan" class="form-label me-2">RT</label>
                                <input type="text" name="rt" class="form-control" id="" placeholder="RT">
                                <label for="kelurahan" class="form-label ms-2 me-2">RW</label>
                                <input type="text" name="rw" class="form-control" id="" placeholder="RW">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="kecamatan" class="form-label">Kecamatan</label>
                            <input type="text" name="kecamatan" id="" class="form-control" placeholder="Kecamatan">
                        </div>
                        <div class="mb-3">
                            <label for="kota" class="form-label">Kabupaten / Kota</label>
                            <input type="text" name="kota" id="" class="form-control" placeholder="Kabupaten / Kota">
                        </div>
                        <div class="mb-3">
                            <label for="provinsi" class="form-label">Provinsi</label>
                            <input type="text" name="provinsi" id="" class="form-control" placeholder="Provinsi">
                        </div>
                        <div class="mb-3">
                            <label for="alamatLengkap" class="form-label">Alamat Lengkap</label>
                            <textarea name="alamat_lengkap" class="form-control" id="" cols="30" rows="5"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="noTelp" class="form-label">No Telepon</label>
                            <input type="text" name="no_telp" class="form-control" id="" placeholder="No Telepon">
                        </div>
                        <div class="mb-3">
                            <button type="submit" class="btn btn-success" id="btnAddifNull">Add Data</button>
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
    <!-- end modal tambah data alamat jika edit data kosong -->

    <?php include_once('../../layout/js.php') ?>
    <script src="<?= $url . ('/public/select2-4.1.0/dist/js/select2.min.js') ?>"></script>
    <script src="<?= $url . ('/public/employee/view-employee-personal-address.min.js?q=') . time() ?>"></script>
</body>