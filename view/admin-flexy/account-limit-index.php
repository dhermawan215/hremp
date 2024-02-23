<!DOCTYPE html>
<html lang="en">
<?php
$route = 'account-limit';
$title = 'HR - Flexy App - Admin Account Limit';
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
                    <h1 class="h3 mb-3"><strong>Account Limit</strong></h1>
                    <div class="row">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="h5 fw-bold">Data Account Limit</h5>
                            </div>
                            <div class="card-body">
                                <div class="flex mb-2">
                                    <a href="<?= $url ?>/view/admin-flexy/account-limit-create.php" class="btn btn-primary">
                                        + Tambah Data
                                    </a>
                                </div>
                                <table id="table-account-limit" class="table table-striped" style="width:100%">
                                    <thead class="bg-primary text-white">
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Nama</th>
                                            <th scope="col">Pangkat</th>
                                            <th scope="col">Saldo Limit</th>
                                            <th scope="col">Periode</th>
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
    <script src="<?= $url . ('/public/flexy-allowance/acclimit/view.min.js?q=') . time() ?>"></script>
</body>

</html>