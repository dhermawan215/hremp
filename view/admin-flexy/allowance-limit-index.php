<!DOCTYPE html>
<html lang="en">
<?php
$route = 'allowance-limit';
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
<style>
    .row-selected {
        background-color: black;
    }
</style>

<body>
    <div class="wrapper">
        <?php include('../layout/sidebar.php'); ?>

        <div class="main">
            <?php include('../layout/navbar.php'); ?>
            <main class="content">
                <div class="container-fluid p-0">
                    <h1 class="h3 mb-3"><strong>Data Master Allowance Limit</strong></h1>
                    <div class="row">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="h5 fw-bold">Data Master Allowance Limit</h5>
                            </div>
                            <div class="card-body">
                                <div class="flex mb-2">
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-add-allowance-limit">
                                        + Tambah Data
                                    </button>
                                    <button type="button" class="btn btn-danger" id="btn-delete">
                                        Hapus Data
                                    </button>
                                </div>
                                <table id="table-allowance-limit" class="table table-striped" style="width:100%">
                                    <thead class="bg-primary text-white">
                                        <tr>
                                            <th scope="col" style="width: 10px;">#</th>
                                            <th scope="col" style="width: 10px;">No</th>
                                            <th scope="col">Nama Limit</th>
                                            <th scope="col">Saldo Limit</th>
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

    <!-- Modal -->
    <div class="modal fade" id="modal-add-allowance-limit" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="staticBackdropLabel">Modal tambah data allowance limit</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="javascript:;" method="post" id="form-add-allowance-limit">
                        <input type="hidden" name="_token" value="<?= $csrf_token ?>">
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama Limit</label>
                            <input type="text" name="nama_limit" class="form-control" id="nama-limit" placeholder="nama limit">
                        </div>
                        <div class="mb-3">
                            <label for="nama" class="form-label">Saldo Limit</label>
                            <input type="number" name="saldo_limit" class="form-control" id="saldo-limit" placeholder="saldo limit">
                        </div>
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary" id="btn-add">Simpan</button>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal edit -->
    <div class="modal fade" id="modal-edit-allowance-limit" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="staticBackdropLabel">Modal edit data allowance limit</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="javascript:;" method="post" id="form-edit-allowance-limit">
                        <input type="hidden" name="_token" value="<?= $csrf_token ?>">
                        <input type="hidden" name="formValue" id="formValue">
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama aktivitas</label>
                            <input type="text" name="nama_limit" class="form-control" id="nama-limit-edit" placeholder="nama limit">
                        </div>
                        <div class="mb-3">
                            <label for="nama" class="form-label">Saldo Limit</label>
                            <input type="number" name="saldo_limit" class="form-control" id="saldo-limit-edit" placeholder="saldo limit">
                        </div>
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary" id="btn-update">Update</button>
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
    <script src="<?= $url . ('/public/flexy-allowance/allowance-limit/view.min.js?q=') . time() ?>"></script>
</body>

</html>