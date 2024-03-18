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
    $allowance = $_GET['allowance'];
}

?>
<style>
    .select2 {
        width: 100% !important;
    }

    .is-invalid-2 {
        border-color: yellow;
    }
</style>

<body>
    <div class="wrapper">
        <?php include('../layout/sidebar.php'); ?>

        <div class="main">
            <?php include('../layout/navbar.php'); ?>
            <main class="content">
                <div class="container-fluid p-0">
                    <h1 class="h3 mb-3"><strong>Edit Item Detail</strong></h1>

                    <!-- tampilan form detail allowance detail -->
                    <div class="row mb-2">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="h5 fw-bold">Form Edit Item Detail</h5>
                            </div>
                            <div class="card-body">
                                <form action="javascript:;" id="form-allowance-detail-edit" method="post">
                                    <input type="hidden" name="action" value="update">
                                    <input type="hidden" name="_token" value="<?= $csrf_token ?>">
                                    <input type="hidden" name="item" value="<?= $detail ?>" id="item">
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
                                            <label for="dependents-category">Dependents Category</label>
                                            <select name="kategori_tertanggung" id="dependents-category" class="form-control">

                                            </select>
                                        </div>
                                        <div class="col">
                                            <label for="insured-name">Insured Name</label>
                                            <input type="text" name="nama_tertanggung" id="insured-name" class="form-control">
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col">
                                            <label for="jumlah-biaya-bon">Total Amount</label>
                                            <input type="number" name="jumlah_biaya_bon" id="jumlah-biaya-bon" class="form-control"></input>

                                        </div>
                                        <div class="col">
                                            <label for="detail-activity">Claim Amount</label>
                                            <input type="number" name="jumlah_biaya_klaim" id="jumlah-biaya-klaim" class="form-control biaya-claim" readonly></input>
                                            <div id="valid-invalid-biaya-klaim" class="invalid-feedback">

                                            </div>
                                        </div>
                                        <div class="col">
                                            <label for="date-activity">Activity Date</label>
                                            <input type="date" name="tanggal_aktivitas" id="date-activity" class="form-control"></input>
                                            <div id="valid-invalid-date-activity" class="invalid-feedback">

                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-1 mt-4">
                                        <div class="col">
                                            <div class="justify-content-center d-flex">
                                                <button type="submit" class="btn btn-success" id="btn-update-detail">Update</button>
                                                <button type="button" class="ms-2 btn btn-outline-secondary" id="btn-back">Back</button>
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
    <script>
        var noAllowance = "<?php echo $allowance ?>"
    </script>
    <script src="<?= $url . ('/public/select2-4.1.0/dist/js/select2.min.js') ?>"></script>
    <script src="<?= $url . ('/public/flexy-allowance-user/request-allowance-detail-item.min.js?q=') . time() ?>"></script>
</body>

</html>