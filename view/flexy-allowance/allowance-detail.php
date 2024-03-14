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
                    <h1 class="h3 mb-3"><strong>Allowance Request Detail</strong></h1>
                    <div class="row mb-2">
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex justify-content-between">
                                    <span>ID Allowance: <strong id="request-id"></strong></span>
                                    <span>Request Date: <strong id="req-date"></strong></span>
                                    <span>Requestor: <strong id="req-name"></strong></span>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row mb-2">
                                    <div class="col">
                                        <label for="jumlah-biaya-bon">Subject</label>
                                        <input type="text" disabled name="subject" id="subject" class="form-control"></input>
                                    </div>
                                    <div class="col">
                                        <label for="detail-activity">Cost Center</label>
                                        <input type="text" disabled name="cost-center" id="cost-center" class="form-control" readonly></input>
                                    </div>
                                    <div class="col">
                                        <label for="date-activity">Department</label>
                                        <input type="text" disabled name="department" id="department" class="form-control"></input>
                                    </div>
                                    <div class="col">
                                        <label for="date-activity">Period </label>
                                        <input type="text" disabled name="period" id="period" class="form-control"></input>
                                    </div>
                                </div>
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
                                    <input type="hidden" name="action" value="save">
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
                                            <div id="valid-invalid-biaya-klaim2" class="invalid-feedback">

                                            </div>
                                            <input type="number" name="jumlah_biaya_klaim" id="jumlah-biaya-klaim" class="form-control biaya-claim" readonly></input>
                                            <div id="valid-invalid-biaya-klaim" class="invalid-feedback">

                                            </div>
                                        </div>
                                        <div class="col">
                                            <label for="date-activity">Activity Date</label>
                                            <input type="date" name="tanggal_aktivitas" id="date-activity" class="form-control"></input>
                                        </div>
                                    </div>
                                    <div class="row mb-1 mt-4">
                                        <div class="col">
                                            <div class="justify-content-center d-flex">
                                                <button type="submit" class="btn btn-success" id="btn-save-detail">Save</button>
                                                <button type="reset" class="ms-2 btn btn-outline-danger">Discard</button>
                                                <button type="button" class="ms-2 btn btn-outline-secondary">Back</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="card">
                            <div class="row">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex mb-2">
                                            <button type="button" class="btn btn-danger" id="btn-delete">
                                                <i class="bi bi-trash"></i> Delete
                                            </button>
                                        </div>
                                        <table id="table-my-request" class="table table-striped" style="width:100%">
                                            <thead class="bg-primary text-white">
                                                <tr>
                                                    <th scope="col">#</th>
                                                    <th scope="col" style="width: 20px;">No</th>
                                                    <th scope="col" style="width: 140px;">Request No</th>
                                                    <th scope="col">Request Name</th>
                                                    <th scope="col">Company</th>
                                                    <th scope="col">Date</th>
                                                    <th scope="col">Period</th>
                                                    <th scope="col">Total</th>
                                                    <th scope="col" style="width: 15px;">HR</th>
                                                    <th scope="col" style="width: 15px;">Dir</th>
                                                    <th scope="col">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                        <hr>

                                        <div class="row mt-2">
                                            <div class="col-sm-2">
                                                <h4>Approval status:</h4>
                                            </div>
                                            <div class="col-sm-2">
                                                <h4 class="ms-1 me-1"><i class="me-1 bi bi-clock text-primary"></i> Pending</h4>
                                            </div>
                                            <div class="col-sm-2">
                                                <h4 class="ms-1 me-1"><i class="me-1 bi bi-send text-primary" aria-hidden="true"></i> Requested</h4>
                                            </div>
                                            <div class="col-sm-2">
                                                <h4 class="ms-1 me-1"><i class="me-1 bi bi-check-square text-success" aria-hidden="true"></i>Approved</h4>
                                            </div>
                                            <div class="col-sm-2">
                                                <h4 class="ms-1 me-1"><i class="me-1 bi bi-x-circle text-danger" aria-hidden="true"></i>Rejected</h4>
                                            </div>
                                            <div class="col-sm-2">
                                                <h4 class="ms-1 me-1"><i class="me-1 bi bi-arrow-repeat text-warning" aria-hidden="true"></i>Revision</h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
        var noAllowance = "<?php echo $detail ?>"
    </script>
    <script src="<?= $url . ('/public/select2-4.1.0/dist/js/select2.min.js') ?>"></script>
    <script src="<?= $url . ('/public/flexy-allowance-user/request-allowance-detail.min.js?q=') . time() ?>"></script>
</body>

</html>