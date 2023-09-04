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
                                            <a href="<?= $url . ('/view/pages/employee/view-employee.php?dataId=') . $_GET['dataId'] ?>" class="btn btn-outline-primary active">Karyawan</a>
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
                                <h5 class="h5 fw-bold">View Data Karyawan: <span class="text-primary fw-bold" id="empName"></span></h5>
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
                                <form id="formEmployee" action="javascript:;" method="post">
                                    <input type="hidden" name="_token" value="<?= $csrf_token ?>">
                                    <input type="hidden" name="id_employee" id="idEmployee" value="<?= $id ?>">
                                    <div class="mb-3">
                                        <label for="nip" class="form-label">NIP Karyawan</label>
                                        <input type="text" name="nip" class="form-control" id="nip" placeholder="NIP Karyawan">
                                    </div>
                                    <div class="mb-3">
                                        <label for="Nama" class="form-label">Nama Karyawan</label>
                                        <input type="text" name="nama" class="form-control" id="Nama" placeholder="Nama Karyawan">
                                    </div>
                                    <div class="mb-3">
                                        <label for="StatusEmp" class="form-label">Status Karyawan</label>
                                        <select name="status_emp" id="StatusEmp" class="form-control">

                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="Company" class="form-label">Company Karyawan</label>
                                        <select name="comp_id" id="Company" class="form-control">

                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="lokasi" class="form-label">Lokasi Kerja Karyawan</label>
                                        <input type="text" name="lokasi" class="form-control" id="lokasi" placeholder="Lokasi Kerja Karyawan">
                                    </div>
                                    <div class="mb-3">
                                        <label for="Dept" class="form-label">Departemen Karyawan</label>
                                        <select name="dept_id" id="Dept" class="form-control">

                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="tgl_masuk" class="form-label">Tanggal Masuk Kerja Karyawan</label>
                                        <input type="date" name="tgl_masuk" class="form-control" id="tgl_masuk">
                                    </div>
                                    <div class="mb-3">
                                        <label for="tgl_kartap" class="form-label">Tanggal Kartap </label>
                                        <input type="date" name="tgl_kartap" class="form-control" id="tgl_kartap" disabled>
                                    </div>
                                    <div class="mb-3">
                                        <label for="email_kantor" class="form-label">Email Kerja Karyawan</label>
                                        <input type="email" name="email_kantor" class="form-control" id="email_kantor" placeholder="Email Kerja Karyawan">
                                    </div>
                                    <div class="mb-3">
                                        <label for="pangkat" class="form-label">Pangkat Karyawan</label>
                                        <input type="text" name="pangkat" class="form-control" id="pangkat" placeholder="Pangkat Karyawan">
                                    </div>
                                    <div class="mb-3">
                                        <label for="jabatan" class="form-label">Jabatan Karyawan</label>
                                        <input type="text" name="jabatan" class="form-control" id="jabatan" placeholder="Jabatan Karyawan">
                                    </div>
                                    <div class="mb-3">
                                        <label for="bpjstk" class="form-label">No BPJSTK Karyawan</label>
                                        <input type="text" name="bpjstk" class="form-control" id="bpjstk" placeholder="Nomer BPJS Ketenagakerjaan Karyawan">
                                    </div>
                                    <div class="mb-3">
                                        <label for="bpjskes" class="form-label">No BPJS Kesehatan Karyawan</label>
                                        <input type="text" name="bpjskes" class="form-control" id="bpjskes" placeholder="Nomer BPJS Kesehatan Karyawan">
                                    </div>
                                    <div class="mb-3">
                                        <button type="submit" id="btnUpdated" class="btn btn-success">Update</button>
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
    <script src="<?= $url . ('/public/employee/view-employee.min.js?q=') . time() ?>"></script>
</body>

</html>