<!DOCTYPE html>
<html lang="en">
<?php
$route = 'export';
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

                    <h1 class="h3 mb-3"><strong> Export Employee Data</strong></h1>

                    <div class="row">
                        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Karyawan Aktif</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Karyawan Resign</button>
                            </li>

                        </ul>
                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                                <div class="card">
                                    <div class="card-header">
                                        <h5>Export Data Karyawan Aktif</h5>
                                    </div>
                                    <div class="card-body">
                                        <form id="formExport" action="<?= $url . '/app/ajax/generate-data.php' ?>" method="post">
                                            <div class="mb-2">
                                                <input type="hidden" name="_token" value="<?= $csrf_token ?>">
                                                <select name="data_karyawan" class="form-control" id="">
                                                    <option selected>-Pilih Data-</option>
                                                    <option value="pribadi">Data Pribadi</option>
                                                    <option value="alamat">Data Alamat</option>
                                                    <option value="pendidikan">Data Pendidikan</option>
                                                    <option value="keluarga">Data Keluarga</option>
                                                    <option value="emergency">Data Kontak Darurat</option>
                                                    <!-- <option value="kontrak">Data Kontrak Kerja</option>
                                                    <option value="experience">Data Pengalaman Kerja</option>
                                                    <option value="history">Data Riwayat Kerja</option> -->
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <button type="submit" id="btnExport" class="btn btn-success">Export</button>
                                            </div>

                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                                <div class="card">
                                    <div class="card-header">
                                        <h5>Export Data Karyawan Resign</h5>
                                    </div>
                                    <div class="card-body">
                                        <form id="formExport" action="<?= $url . '/app/ajax/generate-data.php' ?>" method="post">
                                            <div class="mb-2">
                                                <input type="hidden" name="_token" value="<?= $csrf_token ?>">
                                                <select name="data_karyawan" class="form-control" id="">
                                                    <option selected>-Pilih Data-</option>
                                                    <option value="resign-pribadi">Data Pribadi</option>
                                                    <option value="resign-alamat">Data Alamat</option>
                                                    <option value="resign-pendidikan">Data Pendidikan</option>
                                                    <option value="resign-keluarga">Data Keluarga</option>
                                                    <option value="resign-emergency">Data Kontak Darurat</option>
                                                    <!-- <option value="kontrak">Data Kontrak Kerja</option>
                                                    <option value="experience">Data Pengalaman Kerja</option>
                                                    <option value="history">Data Riwayat Kerja</option> -->
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <button type="submit" id="btnExport" class="btn btn-success">Export</button>
                                            </div>
                                        </form>
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
    <script src="<?= $url . ('/public/employee/employee.min.js?q=') . time() ?>"></script>

</body>

</html>