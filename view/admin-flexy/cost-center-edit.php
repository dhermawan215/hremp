<!DOCTYPE html>
<html lang="en">
<?php
$route = 'cost-center';
$title = 'HR - Flexy App - Admin Edit Cost Center';
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
date_default_timezone_set('Asia/Jakarta');
?>

<body>
    <div class="wrapper">
        <?php include('../layout/sidebar.php'); ?>

        <div class="main">
            <?php include('../layout/navbar.php'); ?>
            <main class="content">
                <div class="container-fluid p-0">
                    <h1 class="h3 mb-3"><strong>Cost Center</strong></h1>
                    <div class="row">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="h5 fw-bold">Edit Cost Center: <span id="cost-center-title"></span></h5>
                            </div>
                            <div class="card-body">
                                <form action="javascript:;" method="post" id="form-edit-cost-center">
                                    <input type="hidden" name="_token" value="<?= $csrf_token ?>">
                                    <input type="hidden" name="formValue" id="formValue" value="<?= $id ?>">
                                    <input type="hidden" name="action" value="update">
                                    <div class="mb-2">
                                        <label for="company">Company</label>
                                        <select name="company" id="company" class="form-control">
                                        </select>
                                    </div>
                                    <div class="mb-2">
                                        <label for="cost-center-name">Cost Center name</label>
                                        <input type="text" name="cost_center_name" id="cost-center-name" class="form-control" placeholder="cost center name">
                                    </div>
                                    <div class="mb-2">
                                        <button type="submit" class="btn btn-primary">Update</button>
                                        <button type="button" id="btnBack" class="btn btn-outline-danger">Back</button>
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
    <script src="<?= $url . ('/public/flexy-allowance/cost-center/edit.min.js?q=') . time() ?>"></script>
</body>

</html>