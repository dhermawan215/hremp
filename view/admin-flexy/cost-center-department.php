<!DOCTYPE html>
<html lang="en">
<?php
date_default_timezone_set('Asia/Jakarta');
$route = 'cost-center';
$title = 'HR - Flexy App - Admin Cost Center Department';
include_once('../layout/header.php');
session_start();
include('../../app/config/is_session.php');
if ($_SESSION['user']['roles'] == 3) {
    echo "<script>
    document.location.href='$url';
    </script>";
}
if (isset($_GET['costcenter'])) {
    $id = $_GET['costcenter'];
} else {
    echo "<script>
    document.location.href='$url/view/admin-flexy/cost-center-index.php';
    </script>";
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
                    <h1 class="h3 mb-3"><strong>Cost Center - Department</strong></h1>
                    <div class="row-mb-2">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="h5 fw-bold">Add Cost Center-Department</h5>
                            </div>
                            <div class="card-body">
                                <form action="javascript:;" method="post" id="form-add-cost-center-department">
                                    <input type="hidden" name="_token" value="<?= $csrf_token ?>">
                                    <input type="hidden" name="cost_center" id="cost-center" value="<?= $id ?>">
                                    <div class="row mb-3">
                                        <div class="col">
                                            <div class="form-outline">
                                                <label class="form-label" for="company">Company</label>
                                                <input type="text" id="company-detail" class="form-control" readonly />
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-outline">
                                                <label class="form-label" for="cost-center">Cost Center</label>
                                                <input type="text" id="cost-center-detail" class="form-control" readonly />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="">Department</label>
                                        <select name="department" name="department" id="department" class="form-control"></select>
                                    </div>
                                    <div class="mb-2">
                                        <button type="submit" class="btn btn-primary">Save</button>
                                        <button type="button" id="btnBack" class="btn btn-outline-danger">Back</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="h5 fw-bold">Data Cost Center-Department</h5>
                            </div>
                            <div class="card-body">
                                <div class="flex mb-2">
                                    <button type="button" class="btn btn-danger" id="btn-delete">
                                        <i class="bi bi-trash"></i> Delete
                                    </button>
                                </div>
                                <table id="table-cost-center-department" class="table table-striped" style="width:100%">
                                    <thead class="bg-primary text-white">
                                        <tr>
                                            <th scope="col" style="width: 15px;">#</th>
                                            <th scope="col" style="width: 15px;">No</th>
                                            <th scope="col">Company-Cost center</th>
                                            <th scope="col">Department</th>
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


    <?php include_once('../layout/js.php') ?>
    <script src="<?= $url . ('/public/select2-4.1.0/dist/js/select2.min.js') ?>"></script>
    <script src="<?= $url . ('/public/flexy-allowance/cost-center/cost-center-department-view.min.js?q=') . time() ?>"></script>
</body>

</html>