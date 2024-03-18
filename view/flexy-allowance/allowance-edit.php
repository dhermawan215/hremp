<!DOCTYPE html>
<html lang="en">
<?php
$route = 'allowance-create';
$title = 'Flexy App - Allowance Request';
$appName = 'Flexy Allowance App';
include_once('../layout/header.php');
session_start();
include('../../app/config/is_session.php');
date_default_timezone_set('Asia/Jakarta');
if (isset($_GET['edit'])) {
    $edit = $_GET['edit'];
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
                    <h1 class="h3 mb-3"><strong>Edit Allowance Request</strong></h1>
                    <div class="row">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="h5 fw-bold">Form Edit Allowance Rrequest</h5>
                            </div>
                            <div class="card-body">
                                <form action="javascript:;" method="post" id="form-edit-user-wallet">
                                    <input type="hidden" name="_token" value="<?= $csrf_token ?>">
                                    <input type="hidden" name="formValue" id="formValue">
                                    <div class="row mb-4">
                                        <div class="col">
                                            <div class="form-outline">
                                                <label class="form-label" for="nomer-allowance">Allowance Number</label>
                                                <input type="text" name="nomer" id="nomer-allowance" class="form-control" readonly />
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-outline">
                                                <label class="form-label" for="users">Requestor</label>
                                                <input type="text" value="<?= $_SESSION['user']['name'] ?>" id="users" class="form-control" readonly />
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-outline">
                                                <label class="form-label" for="transaction-date">Date</label>
                                                <input type="date" name="transaction_date" id="transaction-date" class="form-control"></input>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-outline">
                                                <label class="form-label" for="periode">Period</label>
                                                <select name="period" id="periode" class="form-control">
                                                    <!-- <option value="">-Select Periode-</option> -->

                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <div class="col">
                                            <div class="form-outline">
                                                <label class="form-label" for="nomer-allowance">Company</label>
                                                <select name="company" id="company" class="form-control"></select>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-outline">
                                                <label class="form-label" for="nomer-allowance">Cost Center</label>
                                                <select name="cost_center" id="cost-center" class="form-control"></select>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-outline">
                                                <label class="form-label" for="nomer-allowance">Department</label>
                                                <select name="department" id="department" class="form-control"></select>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row mb-2">
                                        <div class="form-outline">
                                            <label class="form-label" for="request-allowance">Subject</label>
                                            <input type="text" name="nama" id="request-allowance" class="form-control" placeholder="type your allowance subject" />
                                        </div>
                                    </div>
                                    <div class="row mb-2 mt-3">
                                        <div class="col">
                                            <div class="justify-content-center d-flex">
                                                <button type="submit" class="btn btn-success">Update</button>
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
        var noAllowance = "<?php echo $edit ?>"
    </script>
    <script src="<?= $url . ('/public/select2-4.1.0/dist/js/select2.min.js') ?>"></script>
    <script src="<?= $url . ('/public/flexy-allowance-user/request-allowance-edit.min.js?q=') . time() ?>"></script>
</body>

</html>