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
                                            <a href="<?= $url . ('/view/pages/employee/view-employee-edu.php?dataId=') . $_GET['dataId'] ?>" class="btn btn-outline-primary">Pendidikan</a>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="card">
                                            <a href="<?= $url . ('/view/pages/employee/view-employee-family.php?dataId=') . $_GET['dataId'] ?>" class="btn btn-outline-primary active">Keluarga</a>
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
                                <h5 class="h5 fw-bold">View Data Keluarga Karyawan: <span id="karyawanName" class="text-primary"></span></h5>
                            </div>
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="form-check mb-2 me-2">
                                        <input class="form-check-input" type="checkbox" value="1" id="editControl">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Edit Data
                                        </label>
                                    </div>
                                </div>
                                <form id="formEmployeePersonalFm" action="javascript:;" method="post">
                                    <input type="hidden" name="_token" value="<?= $csrf_token ?>">
                                    <input type="hidden" name="emp_id" id="emp_id" value="<?= $id ?>">
                                    <input type="hidden" name="idData" id="idData">
                                    <div class="mb-3">
                                        <label for="namaSuamiIstri" class="form-label">Nama Suami / Istri</label>
                                        <input type="text" name="nama_suami_istri" id="namaSuamiIstri" class="form-control" placeholder="Nama Suami atau Istri">
                                    </div>
                                    <div class="mb-3">
                                        <label for="anak1" class="form-label">Anak ke-1</label>
                                        <input type="text" name="anak1" id="anak1" class="form-control" placeholder="Nama Anak ke-1">
                                    </div>
                                    <div class="mb-3">
                                        <label for="anak2" class="form-label">Anak ke-2</label>
                                        <input type="text" name="anak2" id="anak2" class="form-control" placeholder="Nama Anak ke-2">
                                    </div>
                                    <div class="mb-3">
                                        <label for="anak3" class="form-label">Anak ke-3</label>
                                        <input type="text" name="anak3" id="anak3" class="form-control" placeholder="Nama Anak ke-3">
                                    </div>
                                    <div class="mb-3">
                                        <label for="anak4" class="form-label">Anak ke-4</label>
                                        <input type="text" name="anak4" id="anak4" class="form-control" placeholder="Nama Anak ke-4">
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

    <?php include_once('../../layout/js.php') ?>
    <script src="<?= $url . ('/public/select2-4.1.0/dist/js/select2.min.js') ?>"></script>
    <script src="<?= $url . ('/public/employee/view-employee-personal-family.min.js?q=') . time() ?>"></script>
</body>