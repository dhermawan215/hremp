<!DOCTYPE html>
<html lang="en">
<?php
$route = 'status';
include_once('../../layout/header.php');
session_start();
include('../../../app/config/is_session.php');
date_default_timezone_set('Asia/Jakarta'); ?>

<body>
    <div class="wrapper">
        <?php include('../../layout/sidebar.php'); ?>

        <div class="main">
            <?php include('../../layout/navbar.php'); ?>

            <main class="content">
                <div class="container-fluid p-0">

                    <h1 class="h3 mb-3"><strong>Add Data</strong> Menu</h1>

                    <div class="row">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="h5 fw-bold">Tambah Status Karyawan</h5>
                            </div>
                            <div class="card-body">
                                <form action="javascript:;" method="post" id="formAdd">
                                    <input type="hidden" name="_token" value="<?= $csrf_token ?>">
                                    <div class="mb-3">
                                        <label for="StatusName" class="form-label">Status Karyawan</label>
                                        <input type="text" name="status_name" class="form-control" id="StatusName" placeholder="input status karyawan">
                                    </div>

                                    <button type="submit" class="btn btn-success">Save Data</button>
                                    <button id="btnBack" class="btn btn-danger">Back</button>
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

    <script src="<?= $url . ('/public/status-emp/add.min.js?q=') . time() ?>"></script>
</body>

</html>