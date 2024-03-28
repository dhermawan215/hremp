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

    #overlay {
        position: fixed;
        top: 0;
        z-index: 100;
        width: 100%;
        height: 100%;
        display: none;
        background: rgba(0, 0, 0, 0.6);
    }

    .cv-spinner {
        height: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .spinner {
        width: 40px;
        height: 40px;
        border: 4px #ddd solid;
        border-top: 4px #2e93e6 solid;
        border-radius: 50%;
        animation: sp-anime 0.8s infinite linear;
    }

    @keyframes sp-anime {
        100% {
            transform: rotate(360deg);
        }
    }

    .is-hide {
        display: none;
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
                                        <label for="date-activity">Company</label>
                                        <input type="text" disabled id="company" class="form-control"></input>
                                    </div>
                                    <div class="col">
                                        <label for="detail-activity">Cost Center</label>
                                        <input type="text" disabled id="cost-center" class="form-control"></input>
                                    </div>

                                </div>
                                <div class="row mb-2">
                                    <div class="col">
                                        <label for="date-activity">Department</label>
                                        <input type="text" disabled id="department" class="form-control"></input>
                                    </div>
                                    <div class="col">
                                        <label for="date-activity">Period</label>
                                        <input type="text" disabled id="period" class="form-control"></input>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col">
                                        <label for="jumlah-biaya-bon">HR Checked Status</label>
                                        <input type="text" disabled id="hr-status" class="form-control"></input>
                                    </div>
                                    <div class="col">
                                        <label for="jumlah-biaya-bon">HR Checked at</label>
                                        <input type="text" disabled id="hr-checked-at" class="form-control"></input>
                                    </div>
                                    <div class="col">
                                        <label for="jumlah-biaya-bon">HR Director Approved</label>
                                        <input type="text" disabled id="hr-manager-status" class="form-control"></input>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col">
                                        <label for="jumlah-biaya-bon">HR Note</label>
                                        <input type="text" disabled id="hr-note" class="form-control"></input>
                                    </div>
                                    <div class="col">
                                        <label for="jumlah-biaya-bon">HR Director Note</label>
                                        <input type="text" disabled id="manager-note" class="form-control"></input>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- tampilan tabel detail dan form input total untuk pengajuan allowance -->
                    <div class="row">
                        <div class="card">
                            <div class="card-header">
                                <h5>Table Item Allowance Request: <strong><?= $detail ?></strong></h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="table-allowance-detail" class="table table-striped" style="width:100%">
                                        <thead class="bg-primary text-white">
                                            <tr>
                                                <th scope="col" style="width: 20px;">No</th>
                                                <th scope="col">Activity</th>
                                                <th scope="col">Detail</th>
                                                <th scope="col">Desc</th>
                                                <th scope="col">Dependents</th>
                                                <th scope="col">Insured</th>
                                                <th scope="col">Total Amount</th>
                                                <th scope="col">Claim Amount</th>
                                                <th scope="col">Date Activity</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="card-footer">
                                <hr>
                                <div class="row mb-3">
                                    <div class="col">
                                        <label for="">Total Claim Amount</label>
                                        <input type="number" name="total" class="form-control" id="total-claim-amount" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- !tampilan tabel detail dan form input total untuk pengajuan allowance -->
                    <div id="overlay">
                        <div class="cv-spinner">
                            <span class="spinner"></span>
                        </div>
                    </div>
                    <!-- tampilan upload attachment -->
                    <div class="row">
                        <div class="card">
                            <div class="card-header">
                                <h5>Attachment</h5>
                            </div>
                            <div class="card-body">
                                <table id="tableDocs" class="table table-striped" style="width:100%">
                                    <thead class="bg-primary text-white">
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Document Name</th>
                                            <th scope="col">Uploaded at</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- !tampilan upload attachment -->
                    <div class="row">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-center align-items-center">
                                    <div class="me-1" id="approve-col">

                                    </div>
                                    <div class="me-1" id="revision-col">

                                    </div>
                                    <div class="me-1" id="rejected-col">

                                    </div>
                                    <div class="me-1" id="back-col">
                                        <button type="button" class="btn btn-outline-secondary" id="btn-back">Back</button>
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

    <!-- Modal revision action -->
    <div class="modal fade" id="revision-modal" tabindex="-1" aria-labelledby="revision-modal-label" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Modal Revision Allowance</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="javascript:;" id="form-allowance-revisi" method="post">
                        <input type="hidden" name="_token" value="<?= $csrf_token ?>">
                        <div class="row">
                            <div class="col">
                                <label for="hr-notes">Revision note:</label>
                                <textarea name="hr_notes" id="hr-notes-revision" class="form-control" cols="30" rows="5"></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <label for="hr-check-revision">Check By</label>
                                <input type="text" name="hr_check_by" id="hr-check-revision" class="form-control">
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col">
                                <button type="submit" id="btn-revision-change" class="btn btn-success">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal revision action -->
    <div class="modal fade" id="rejected-modal" tabindex="-1" aria-labelledby="rejected-modal-label" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Modal Rejected Allowance</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="javascript:;" method="post" id="form-rejection-allowance">
                        <input type="hidden" name="_token" value="<?= $csrf_token ?>">
                        <div class="row">
                            <div class="col">
                                <label for="hr-notes">Rejection note:</label>
                                <textarea name="hr_notes" id="hr-notes-rejected" class="form-control" cols="30" rows="5"></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <label for="hr-check-rejection">Check By</label>
                                <input type="text" name="hr_check_by" id="hr-check-rejection" class="form-control">
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col">
                                <button type="submit" id="btn-rejected-change" class="btn btn-success">Submit</button>
                            </div>
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
    <script>
        var noAllowance = "<?php echo $detail ?>"
    </script>
    <script src="<?= $url . ('/public/select2-4.1.0/dist/js/select2.min.js') ?>"></script>
    <script src="<?= $url . ('/public/flexy-hr/allowance-detail.min.js?q=') . time() ?>"></script>
</body>

</html>