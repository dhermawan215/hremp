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
date_default_timezone_set('Asia/Jakarta');
?>

<body>
    <div class="wrapper">
        <?php include('../../layout/sidebar.php'); ?>

        <div class="main">
            <?php include('../../layout/navbar.php'); ?>

            <main class="content">
                <div class="container-fluid p-0">

                    <h1 class="h3 mb-3"><strong>Admin - User Management</strong> Dashboard</h1>

                    <div class="row">
                        <div class="card">
                            <div class="flex">
                                <a href="<?= $url . ('/view/pages/admin/register.php') ?>" class="btn btn-success m-3 p-2">+ Tambah Data</a>
                            </div>
                            <div class="card-header">
                                <h5 class="h5 fw-bold">Data User</h5>
                            </div>
                            <div class="card-body">

                                <table id="tableUserMg" class="table table-striped" style="width:100%">
                                    <thead class="bg-primary text-white">
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Email</th>
                                            <th scope="col">Nama</th>
                                            <th scope="col">Role</th>
                                            <th scope="col">Active</th>
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
            <?php include_once('../../layout/footer.php') ?>
        </div>
    </div>

    <?php include_once('../../layout/js.php') ?>
    <script src="<?= $url . ('/public/admin/user-management.min.js?q=') . time() ?>"></script>
</body>

</html>