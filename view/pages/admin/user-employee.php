<!DOCTYPE html>
<html lang="en">
<?php include_once('../../layout/header.php');
session_start();
include('../../../app/config/is_session.php');
if ($_SESSION['user']['roles'] != 1) {
    echo "<script>
    document.location.href='$url';
    </script>";
}

$userValue = $_GET['user'];
$userNameValue = $_GET['name'];
date_default_timezone_set('Asia/Jakarta');
?>

<body>
    <div class="wrapper">
        <?php include('../../layout/sidebar.php'); ?>

        <div class="main">
            <?php include('../../layout/navbar.php'); ?>

            <main class="content">
                <div class="container-fluid p-0">

                    <h1 class="h3 mb-3"><strong>Admin - User Employee</strong></h1>

                    <div class="row">
                        <div class="card">
                            <div class="card-body">
                                <form action="javascript:;" method="post" id="form-user-employee">
                                    <input type="hidden" name="_token" value="<?= $csrf_token ?>">
                                    <input type="hidden" name="user" value="<?= $userValue ?>">
                                    <div class="">
                                        <label for="">Nama User</label>
                                        <input type="text" class="form-control" name="" id="" readonly value="<?= $userNameValue ?>">
                                    </div>
                                    <div class="mt-2">
                                        <label for="">Nama Karyawan</label>
                                        <select name="employee" id="employee" class="form-control">

                                        </select>
                                    </div>
                                    <div class="mt-2">
                                        <button type="submit" class="btn btn-primary">Save</button>
                                        <button type="button" class="btn btn-outline-secondary" id="btnBack">Discard</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </main>
            <?php include_once('../../layout/footer.php') ?>
        </div>
    </div>

    <?php include_once('../../layout/js.php') ?>
    <script src="<?= $url . ('/public/select2-4.1.0/dist/js/select2.min.js') ?>"></script>
    <script src="<?= $url . ('/public/admin/user-employee.min.js?q=') . time() ?>"></script>
</body>

</html>