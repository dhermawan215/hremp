<!DOCTYPE html>
<html lang="en">
<?php include_once('../../layout/header.php');
session_start();
include('../../../app/config/is_session.php');
date_default_timezone_set('Asia/Jakarta');
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
                                <h5 class="h5 fw-bold">Tambah Data Karyawan</h5>
                            </div>
                            <div class="card-body">
                                <form id="formEmployee" action="javascript:;" method="post">
                                    <input type="hidden" name="_token" value="<?= $csrf_token ?>">
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
                                        <label for="tgl_kartap" class="form-label">Tanggal Kartap Kerja Karyawan</label>
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
                                        <button type="submit" id="btnEmployeeSave" class="btn btn-success">Save & Next</button>
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
    <script src="<?= $url . ('/public/employee/employee.min.js?q=') . time() ?>"></script>
</body>

</html>