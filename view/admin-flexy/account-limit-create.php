<!DOCTYPE html>
<html lang="en">
<?php include_once('../layout/header.php');
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
                                <h5 class="h5 fw-bold">Add Account Limit</h5>
                            </div>
                            <div class="card-body">
                                <form action="javascript:;" method="post" id="form-add-user-wallet">
                                    <input type="hidden" name="_token" value="<?= $csrf_token ?>">
                                    <div class="mb-2">
                                        <label for="nama-karyawan"">Nama Karyawan</label>
                                        <select name=" users" id="nama-karyawan" class="form-control">

                                            </select>
                                    </div>
                                    <div class="mb-2">
                                        <label for="">Saldo Awal</label>
                                        <input type="number" name="saldo_awal" id="saldo-awal" class="form-control" placeholder="saldo awal/limit">
                                    </div>
                                    <div class="mb-2">
                                        <label for="">Periode Saldo</label>
                                        <select name="periode_saldo" id="periode-saldo" class="form-control">
                                            <option value="">-Pilih Tahun-</option>
                                            <?php for ($i = date('Y'); $i <= date('Y'); $i++) : ?>
                                                <option value="<?= $i ?>"><?= $i ?></option>
                                            <?php endfor; ?>
                                        </select>
                                    </div>
                                    <div class="mb-2">
                                        <button type="submit" class="btn btn-primary">Save</button>
                                        <button type="button" id="btnBack" class="btn btn-outline-danger">Kembali</button>
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
    <script src="<?= $url . ('/public/flexy-allowance/acclimit/add.min.js?q=') . time() ?>"></script>
</body>

</html>