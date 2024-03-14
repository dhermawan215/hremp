<!DOCTYPE html>
<html lang="en">
<?php
$route = 'allowance-create';
$title = 'Flexy App - Allowance Request Detail';
$appName = 'Flexy Allowance App';
include_once('../layout/header.php');
session_start();
include('../../app/config/is_session.php');

date_default_timezone_set('Asia/Jakarta');
if (isset($_GET['detail'])) {
    $detail = $_GET['detail'];
}

?>
<style>
    .select2 {
        width: 100% !important;
    }
</style>

<body>
    <div class="wrapper">
        <?php include('../layout/sidebar.php'); ?>

        <div class="main">
            <?php include('../layout/navbar.php'); ?>
            <main class="content">
                <div class="container-fluid p-0">
                    <h1 class="h3 mb-3"><strong>Allowance Request Detail</strong></h1>
                    <div class="row mb-2">
                        <div class="card">
                            <div class="card-header"></div>
                            <div class="card-body">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="h5 fw-bold">Form Allowance Request Detail</h5>
                            </div>
                            <div class="card-body">
                                <form action="javascript:;" id="form-allowance-detail" method="post">
                                    <input type="hidden" name="_token" value="<?= $csrf_token ?>">
                                    <input type="hidden" name="allowance" id="allowance-number">
                                    <div class="row mb-2">
                                        <div class="col">
                                            <label for="activity">Activity</label>
                                            <select name="activity" id="activity" class="form-control"></select>
                                        </div>
                                        <div class="col">
                                            <label for="detail-activity">Detail Activity</label>
                                            <select name="activity_detail" id="detail-activity" class="form-control"></select>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col">
                                            <label for="deskripsi">Description</label>
                                            <input type="text" name="deskripsi" id="deskripsi" class="form-control"></input>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col">
                                            <label for="jumlah-biaya-bon">Total Amount</label>
                                            <input type="number" name="jumlah_biaya_bon" id="jumlah-biaya-bon" class="form-control"></input>
                                        </div>
                                        <div class="col">
                                            <label for="detail-activity">Claim Amount</label>
                                            <input type="number" name="jumlah_biaya_klaim" id="jumlah-biaya-klaim" class="form-control" readonly></input>
                                        </div>
                                        <div class="col">
                                            <label for="date-activity">Activity Date</label>
                                            <input type="date" name="tanggal_aktivitas" id="date-activity" class="form-control"></input>
                                        </div>
                                    </div>
                                    <div class="row mb-1 mt-4">
                                        <div class="col">
                                            <div class="justify-content-center d-flex">
                                                <button type="submit" class="btn btn-success">Save</button>
                                                <button type="reset" class="ms-2 btn btn-outline-danger">Discard</button>
                                                <button type="button" class="ms-2 btn btn-outline-secondary">Back</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
            <?php include_once('../layout/footer.php') ?>
        </div>
    </div>

    <?php include_once('../layout/js.php') ?>
    <script src="<?= $url . ('/public/select2-4.1.0/dist/js/select2.min.js') ?>"></script>
    <script src="<?= $url . ('/public/flexy-allowance-user/request-allowance-detail.min.js?q=') . time() ?>"></script>
</body>

</html>