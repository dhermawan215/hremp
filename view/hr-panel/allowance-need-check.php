<!DOCTYPE html>
<html lang="en">
<?php
$route = 'hr-check';
$title = 'Flexy App - HR Chek';
$appName = 'HR & Flexy Allowance App';
include_once('../layout/header.php');
session_start();
include('../../app/config/is_session.php');

date_default_timezone_set('Asia/Jakarta');
?>

<body>
    <div class="wrapper">
        <?php include('../layout/sidebar.php'); ?>

        <div class="main">
            <?php include('../layout/navbar.php'); ?>
            <main class="content">
                <div class="container-fluid p-0">
                    <h1 class="h3 mb-3"><strong>HR - Allowance need checked</strong></h1>
                    <div class="row">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex mb-2">

                                </div>
                                <div class="table-responsive">
                                    <table id="table-hr-need-check" class="table table-striped" style="width:100%">
                                        <thead class="bg-primary text-white">
                                            <tr>
                                                <th scope="col" style="width: 20px;">No</th>
                                                <th scope="col">Request No|Requestor</th>
                                                <th scope="col">Subject</th>
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
                                </div>
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
            </main>
            <?php include_once('../layout/footer.php') ?>
        </div>
    </div>

    <?php include_once('../layout/js.php') ?>
    <script src="<?= $url . ('/public/flexy-hr/need-check.min.js?q=') . time() ?>"></script>
</body>

</html>