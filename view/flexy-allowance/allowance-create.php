<!DOCTYPE html>
<html lang="en">
<?php
$route = 'allowance-create';
$title = 'Flexy App - Allowance Request';
include_once('../layout/header.php');
session_start();
include('../../app/config/is_session.php');

date_default_timezone_set('Asia/Jakarta');
?>

<body>
    <div class="wrapper">
        <?php include('../layout/sidebar.php'); ?>

        <div class="main">
            <?php include('../layout/navbar.php'); ?>
            <main class="content">
                <div class="container-fluid p-0">
                    <h1 class="h3 mb-3"><strong>Create Your Allowance Request</strong></h1>
                    <div class="row">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="h5 fw-bold">Form Allowance Rrequest</h5>
                            </div>
                            <div class="card-body">
                                <form action="javascript:;" method="post" id="form-add-user-wallet">
                                    <input type="hidden" name="_token" value="<?= $csrf_token ?>">
                                    <input type="hidden" name="users" value="<?= $_SESSION['user']['idusers'] ?>">
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
    <script src="<?= $url . ('/public/flexy-allowance-user/request-allowance.min.js?q=') . time() ?>"></script>
</body>

</html>