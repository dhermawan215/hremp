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

                    <h1 class="h3 mb-3"><strong>Employee</strong> Dashboard</h1>

                    <div class="row">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="h5 fw-bold">Data Karyawan Keluar(Resigned)</h5>
                            </div>
                            <div class="card-body">

                                <table id="tableEmpResigned" class="table table-striped" style="width:100%">
                                    <thead class="bg-primary text-white">
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">NIP</th>
                                            <th scope="col">Nama</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>

                    <!-- Modal -->
                    <div class="modal fade" id="modalDataResigned" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Data Resign Karyawan</h5>
                                </div>
                                <div class="modal-body">
                                    <form id="formEmployeeResign" action="javascript:;" method="post">
                                        <input type="hidden" name="_token" value="<?= $csrf_token ?>">
                                        <input type="hidden" name="idData" id="idData">
                                        <h5 class="text-primary">Nama Karyawan: <span id="karyawanName"></span></h5>
                                        <div class="mb-3">
                                            <label for="tgl_pengajuan" class="form-label">Tanggal Pengajuan</label>
                                            <input type="date" name="tgl_pengajuan" id="tgl_pengajuan" class="form-control" disabled>
                                        </div>
                                        <div class="mb-3">
                                            <label for="tgl_resign" class="form-label">Tanggal Resign</label>
                                            <input type="date" name="tgl_resign" id="tgl_resign" class="form-control" disabled>
                                        </div>

                                        <div class="mb-3">
                                            <!-- <button type="submit" class="btn btn-success" id="btnUpdate">Save</button> -->
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
            </main>
            <?php include_once('../../layout/footer.php') ?>
        </div>
    </div>

    <?php include_once('../../layout/js.php') ?>
    <script src="<?= $url . ('/public/employee/resigned.min.js?q=') . time() ?>"></script>
</body>

</html>