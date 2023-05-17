<!DOCTYPE html>
<html lang="en">
<?php include_once('../../layout/header.php');
session_start();
include('../../../app/config/is_session.php');
date_default_timezone_set('Asia/Jakarta');

if (isset($_GET['data'])) {
    $id = base64_decode($_GET['data']);
} else {
    echo "<script>
    document.location.href='$url';
    </script>";
}
?>

<body>
    <div class="wrapper">
        <?php include('../../layout/sidebar.php'); ?>

        <div class="main">
            <?php include('../../layout/navbar.php'); ?>

            <main class="content">
                <div class="container-fluid p-0">

                    <h1 class="h3 mb-3"><strong>Edit</strong> Menu</h1>

                    <div class="row">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="h5 fw-bold">Edit Data: <span id="editTitle"></span></h5>
                            </div>
                            <div class="card-body">
                                <form action="javascript:;" method="post" id="formEditDept">
                                    <input type="hidden" id="idValue" name="id" value="<?= $id ?>">
                                    <input type="hidden" name="_token" value="<?= $csrf_token ?>">
                                    <div class="mb-3">
                                        <label for="DeptName" class="form-label">Nama Departemen</label>
                                        <input type="text" name="dept_name" class="form-control" id="DeptName">
                                    </div>

                                    <button type="submit" class="btn btn-primary">Update Data</button>
                                    <button id="btnBack" class="btn btn-danger">Back</button>
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

    <script src="<?= $url . ('/public/department/edit.min.js?q=') . time() ?>"></script>
</body>

</html>