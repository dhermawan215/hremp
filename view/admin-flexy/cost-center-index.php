<!DOCTYPE html>
<html lang="en">
<?php
$route = 'cost-center';
$title = 'HR - Flexy App - Admin Cost Center';
include_once('../layout/header.php');
session_start();
include('../../app/config/is_session.php');
if ($_SESSION['user']['roles'] == 3) {
    echo "<script>
    document.location.href='$url';
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
                                <h5 class="h5 fw-bold">Data Cost Center</h5>
                            </div>
                            <div class="card-body">
                                <div class="flex mb-2">
                                    <a href="<?= $url ?>/view/admin-flexy/cost-center-create.php" class="btn btn-primary">+ Add Data</a>
                                    <button type="button" class="btn btn-danger" id="btn-delete">
                                        <i class="bi bi-trash"></i> Delete
                                    </button>
                                </div>
                                <table id="table-cost-center" class="table table-striped" style="width:100%">
                                    <thead class="bg-primary text-white">
                                        <tr>
                                            <th scope="col" style="width: 15px;">#</th>
                                            <th scope="col" style="width: 15px;">No</th>
                                            <th scope="col">Company</th>
                                            <th scope="col">Cost Center Name</th>
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


    <?php include_once('../layout/js.php') ?>
    <script src="<?= $url . ('/public/flexy-allowance/cost-center/view.min.js?q=') . time() ?>"></script>
</body>

</html>