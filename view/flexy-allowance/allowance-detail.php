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
                                        <input type="text" disabled id="subject" class="form-control"></input>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col">
                                        <label for="detail-activity">Company</label>
                                        <input type="text" disabled id="company" class="form-control" readonly></input>
                                    </div>
                                    <div class="col">
                                        <label for="detail-activity">Cost Center</label>
                                        <input type="text" disabled id="cost-center" class="form-control" readonly></input>
                                    </div>
                                    <div class="col">
                                        <label for="date-activity">Department</label>
                                        <input type="text" disabled id="department" class="form-control"></input>
                                    </div>
                                    <div class="col">
                                        <label for="date-activity">Period </label>
                                        <input type="text" disabled id="period" class="form-control"></input>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col">
                                        <label for="jumlah-biaya-bon">HR Checked Status</label>
                                        <input type="text" disabled id="hr-status" class="form-control"></input>
                                    </div>
                                    <div class="col">
                                        <label for="jumlah-biaya-bon">HR Director Approved</label>
                                        <input type="text" disabled id="hr-manager-status" class="form-control"></input>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col" id="hr-note">

                                    </div>
                                    <div class="col" id="manager-note">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- tampilan form detail allowance detail -->
                    <div class="row mb-2">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="h5 fw-bold">Form Allowance Request Detail</h5>
                            </div>
                            <div class="card-body">
                                <form action="javascript:;" id="form-allowance-detail" method="post">
                                    <input type="hidden" name="action" value="save">
                                    <input type="hidden" name="_token" value="<?= $csrf_token ?>">
                                    <input type="hidden" name="allowance" class="allowance-number" id="allowance-number">
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
                                                <option value="null">-Please Select-</option>
                                                <option value="self">Your self</option>
                                                <option value="nama_suami_istri">Husband/wife</option>
                                                <option value="anak1">First child</option>
                                                <option value="anak2">Second child</option>
                                                <option value="anak3">The third child</option>
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
                                            <div class="justify-content-center d-block">
                                                <p id="remaining-alert" class="text-danger"> </p>
                                                <p id="remaining-transaction"> </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-1 mt-4">
                                        <div class="col">
                                            <div class="justify-content-center d-flex">
                                                <button type="submit" class="btn btn-success" id="btn-save-detail">Save</button>
                                                <button type="reset" class="ms-2 btn btn-outline-danger">Discard</button>
                                                <button type="button" class="ms-2 btn btn-outline-secondary" id="btn-back">Back</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- tampilan form detail allowance detail -->
                    <!-- tampilan tabel detail dan form input total untuk pengajuan allowance -->
                    <div class="row">
                        <div class="card">
                            <div class="card-header">
                                <h5>Table Item Allowance Request: <strong><?= $detail ?></strong></h5>
                            </div>
                            <div class="card-body">
                                <div class="d-flex mb-2">
                                    <button type="button" class="btn btn-danger" id="btn-delete-item">
                                        <i class="bi bi-trash"></i> Delete
                                    </button>
                                </div>
                                <div class="table-responsive">
                                    <table id="table-allowance-detail" class="table table-striped" style="width:100%">
                                        <thead class="bg-primary text-white">
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col" style="width: 20px;">No</th>
                                                <th scope="col">Activity</th>
                                                <th scope="col">Detail</th>
                                                <th scope="col">Desc</th>
                                                <th scope="col">Dependents</th>
                                                <th scope="col">Insured</th>
                                                <th scope="col">Total Amount</th>
                                                <th scope="col">Claim Amount</th>
                                                <th scope="col">Date Activity</th>
                                                <th scope="col">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="card-footer">
                                <hr>
                                <form action="javascript:;" method="post" id="form-request">
                                    <input type="hidden" name="_token" value="<?= $csrf_token ?>">

                                    <div class="row mb-3">
                                        <div class="col">
                                            <label for="">Total Claim Amount</label>
                                            <input type="number" name="total" class="form-control" id="total-claim-amount" readonly>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <button type="submit" class="btn btn-primary" id="btn-request">Send Request</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- !tampilan tabel detail dan form input total untuk pengajuan allowance -->
                    <!-- tampilan upload attachment -->
                    <div class="row">
                        <div class="card">
                            <div class="card-header">
                                <h5>Upload Attachment</h5>
                            </div>
                            <div class="card-body">
                                <form action="javascript:;" method="post" id="upload-attachment" enctype="multipart/form-data">
                                    <input type="hidden" name="_token" value="<?= $csrf_token ?>">
                                    <input type="hidden" name="allowance" id="allowance-numbe-doc">
                                    <input type="hidden" name="action" id="document" value="upload-attachment">
                                    <div class="mb-3">
                                        <label for="formFile" class="form-label">File (jpg/png/pdf, max: 2MB)</label>
                                        <input class="form-control" type="file" id="allowance-file" name="document">
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <button type="submit" class="btn btn-success" id="btn-save-attachment">Upload</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="card-body">
                                <table id="tableDocs" class="table table-striped" style="width:100%">
                                    <thead class="bg-primary text-white">
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Document Name</th>
                                            <th scope="col">Uploaded at</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- !tampilan upload attachment -->
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