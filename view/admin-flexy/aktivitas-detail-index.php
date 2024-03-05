<!DOCTYPE html>
<html lang="en">
<?php
$route = 'aktivitas';
$title = 'HR - Flexy App - Admin Activity Detail';
include_once('../layout/header.php');
session_start();
include('../../app/config/is_session.php');
if ($_SESSION['user']['roles'] == 3) {
    echo "<script>
    document.location.href='$url';
    </script>";
}

if (isset($_GET['activity'])) {
    $activity = $_GET['activity'];
    $name = $_GET['name'];
}
date_default_timezone_set('Asia/Jakarta');
?>

<body>
    <div class="wrapper">
        <?php include('../layout/sidebar.php'); ?>

        <div class="main">
            <?php include('../layout/navbar.php'); ?>
            <main class="content">
                <div class="container-fluid p-0">
                    <h1 class="h3 mb-3"><strong>Detail Activity</strong><strong id="title-detail"><?= ': ' . $name ?></strong></h1>
                    <div class="row mb-2">
                        <div class="card">
                            <div class="card-header">
                                Form Add Detail Activity
                            </div>
                            <div class="card-body">
                                <form action="javascript:;" id="form-add-detail-activity">
                                    <input type="hidden" name="_token" value="<?= $csrf_token ?>">
                                    <input type="hidden" id="activity" name="activity" value="<?= $activity ?>">
                                    <div class="mb-2">
                                        <label for="nama-karyawan">Detail Name</label>
                                        <input type="text" id="nama-detail" name="nama_detail" class="form-control" placeholder="detail activity name">
                                    </div>
                                    <div class="mb-2">
                                        <button type="submit" class="btn btn-primary">Save Detail</button>
                                        <button type="button" id="btnBack" class="btn btn-outline-danger">Back</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="h5 fw-bold">Detail activity in categories : <?= $name ?></h5>
                            </div>
                            <div class="card-body">
                                <button type="button" class="btn btn-danger mb-3" id="btn-delete"><i class="bi bi-trash"></i> Delete</button>
                                <table id="table-aktivitas-detail" class="table table-striped" style="width:100%">
                                    <thead class="bg-primary text-white">
                                        <tr>
                                            <th scope="col" style="width: 15px;">#</th>
                                            <th scope="col" style="width: 15px;">No</th>
                                            <th scope="col">Detail Activity Name</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
            <?php include_once('../layout/footer.php') ?>
        </div>
    </div>

    <!-- Modal edit -->
    <div class="modal fade" id="modal-edit-aktivitas-detail" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="staticBackdropLabel">Modal edit detail activity</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="javascript:;" method="post" id="form-edit-aktivitas-detail">
                        <input type="hidden" name="_token" value="<?= $csrf_token ?>">
                        <input type="hidden" name="formValue" id="formValue">
                        <div class="mb-3">
                            <label for="nama" class="form-label">Detail Activity Name</label>
                            <input type="text" name="nama_detail" class="form-control" id="nama-aktivitas-detail-edit" placeholder="detail activity name">
                        </div>
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary" id="btn-update">Update</button>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <?php include_once('../layout/js.php') ?>
    <script src="<?= $url . ('/public/flexy-allowance/aktivitas/detail-activity.min.js?q=') . time() ?>"></script>
</body>

</html>