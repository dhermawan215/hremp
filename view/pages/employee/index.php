<!DOCTYPE html>
<html lang="en">
<?php
$route = 'employee';
include_once('../../layout/header.php');
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
                            <div class="flex">
                                <button id="btnAdd" class="btn btn-success m-3 p-2">+ Tambah Data</button>
                            </div>
                            <div class="card-header">
                                <h5 class="h5 fw-bold">Data Karyawan</h5>
                            </div>
                            <div class="card-body">

                                <table id="tableEmp" class="table table-striped" style="width:100%">
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
                    <div class="modal fade" id="modalIsResigned" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Form Resign Karyawan</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form id="formEmployeeResign" action="javascript:;" method="post">
                                        <input type="hidden" name="_token" value="<?= $csrf_token ?>">
                                        <input type="hidden" name="idData" id="idData">
                                        <h5 class="text-primary">Nama Karyawan: <span id="karyawanName"></span></h5>
                                        <div class="mb-3">
                                            <label for="tgl_pengajuan" class="form-label">Tanggal Pengajuan</label>
                                            <input type="date" name="tgl_pengajuan" id="tgl_pengajuan" class="form-control">
                                        </div>
                                        <div class="mb-3">
                                            <label for="tgl_resign" class="form-label">Tanggal Resign</label>
                                            <input type="date" name="tgl_resign" id="tgl_resign" class="form-control">
                                        </div>
                                        <div class="mb-3">
                                            <label for="alasan_resign" class="form-label">Alasan Resign</label>
                                            <input type="text" name="alasan_resign" id="alasan_resign" placeholder="alasan resign karyawan" class="form-control">
                                        </div>
                                        <div class="mb-3">
                                            <label for="keterangan" class="form-label">Resign?</label>
                                            <select name="is_resigned" class="form-control" id="">
                                                <option value="1" selected>Ya</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <button type="submit" class="btn btn-success" id="btnUpdate">Save</button>
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
    <script src="<?= $url . ('/public/employee/view.min.js?q=') . time() ?>"></script>
</body>

</html>