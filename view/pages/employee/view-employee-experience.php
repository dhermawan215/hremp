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
                                            <a href="<?= $url . ('/view/pages/employee/view-employee-experience.php?dataId=') . $_GET['dataId'] ?>" class="btn btn-outline-primary active">Pengalaman Kerja</a>
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
                                <h5 class="h5 fw-bold">View Data Pengalaman Kerja Karyawan: <span id="karyawanName" class="text-primary"></span></h5>
                            </div>
                            <div class="card-body">
                                <div class="row mt-2">
                                    <input type="hidden" name="emp_id" id="emp_id" value="<?= $id ?>">
                                    <div class="table-responsive mt-2">
                                        <table class="table" id="tablePengalamanKerja">
                                            <button class="btn btn-sm btn-success mb-3" id="btnAddKontrak" data-bs-toggle="modal" data-bs-target="#modalAddPengalamanKerja">+ Add Data Pengalaman Kerja</button>
                                            <thead>
                                                <tr>
                                                    <th scope="col">#</th>
                                                    <th scope="col">Perusahaan</th>
                                                    <th scope="col">Jabatan</th>
                                                    <th scope="col">Tgl Masuk</th>
                                                    <th scope="col">Tgl Keluar</th>
                                                    <th scope="col">Ket</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <!-- modal add pengalaman kerja -->
                                <div class="modal fade" id="modalAddPengalamanKerja" tabindex="-1" aria-labelledby="modalAddPengalamanKerja" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Form Tambah Pengalaman Kerja</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form id="formEmployeeAddPengalaman" action="javascript:;" method="post">
                                                    <input type="hidden" name="_token" value="<?= $csrf_token ?>">
                                                    <input type="hidden" name="emp_id" value="<?= $id ?>">
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

                                <!-- modal edit pengalaman kerja -->
                                <div class="modal fade" id="modalEditPengalamanKerja" tabindex="-1" aria-labelledby="modalEditPengalamanKerja" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Form Update Pengalaman Kerja</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form id="formEmployeeUpdatePengalaman" action="javascript:;" method="post">
                                                    <input type="hidden" name="_token" value="<?= $csrf_token ?>">
                                                    <input type="hidden" name="emp_id" value="<?= $id ?>">
                                                    <input type="hidden" name="idData" id="idData">
                                                    <div class="mb-3">
                                                        <label for="perusahaan" class="form-label">Perusahaan</label>
                                                        <input type="text" name="perusahaan" id="perusahaan2" class="form-control">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="jabatan" class="form-label">Jabatan</label>
                                                        <input type="text" name="jabatan" id="jabatan2" class="form-control">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="periode_masuk" class="form-label">Tanggal Masuk</label>
                                                        <input type="date" name="periode_masuk" id="periode_masuk2" class="form-control">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="periode_keluar" class="form-label">Tanggal Keluar</label>
                                                        <input type="date" name="periode_keluar" id="periode_keluar2" class="form-control">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="keterangan" class="form-label">Keterangan</label>
                                                        <input type="text" name="keterangan" id="keterangan2" class="form-control">
                                                    </div>
                                                    <div class="mb-3">
                                                        <button type="submit" class="btn btn-success" id="btnUpdate">Update</button>
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
    <script src="<?= $url . ('/public/employee/view-employee-pengalaman-kerja.min.js?q=') . time() ?>"></script>
</body>