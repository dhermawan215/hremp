<!DOCTYPE html>
<html lang="en">
<?php
$route = 'profile';
include_once('../../layout/header.php');
session_start();
include('../../../app/config/is_session.php');
date_default_timezone_set('Asia/Jakarta');
?>

<body>
    <div class="wrapper">
        <?php include('../../layout/sidebar.php'); ?>

        <div class="main">
            <?php include('../../layout/navbar.php'); ?>

            <main class="content">
                <div class="container-fluid p-0">

                    <div class="mb-3">
                        <h1 class="h3 d-inline align-middle">Profile</h1>
                    </div>
                    <div class="row">
                        <div class="col-md-4 col-xl-3">
                            <div class="card mb-3">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">Profile Details</h5>
                                </div>
                                <div class="card-body text-center ">
                                    <h5 class="mb-0 fw-bold text-primary"><?= $_SESSION['user']['name'] ?></h5>
                                    <div class="mb-2 text-secondary"><?= $_SESSION['user']['email'] ?></div>
                                </div>
                                <hr class="my-0" />
                            </div>
                        </div>

                        <div class="col-md-8 col-xl-9">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">User Control Panel</h5>
                                    <hr />
                                </div>
                                <div class="card-body">
                                    <h5 class="mb-1 fw-bold">Update Password</h5>
                                    <div class="mx-2 px-2 mt-2">
                                        <form action="javascript:;" method="post" id="formUpdatePassword">
                                            <input type="hidden" name="_token" value="<?= $csrf_token ?>">
                                            <input type="hidden" name="email" value="<?= $_SESSION['user']['email'] ?>">
                                            <div class="mb-3">
                                                <label for="OldPassword" class="form-label">Password Lama</label>
                                                <input type="password" name="old_password" class="form-control" id="OldPassword" placeholder="input password lama">
                                            </div>
                                            <div class="mb-3">
                                                <label for="NewPassword" class="form-label">Password Baru</label>
                                                <input type="password" name="new_password" class="form-control" id="NewPassword" placeholder="input password Baru">
                                            </div>
                                            <div class="mb-3">
                                                <label for="NewPasswordConfirm" class="form-label">Konfirmasi Password Baru</label>
                                                <input type="password" name="new_password_confirm" class="form-control" id="NewPasswordConfirm" placeholder="konfirmasi password baru">
                                            </div>

                                            <button type="submit" class="btn btn-success">Update Password</button>
                                        </form>
                                    </div>

                                    <hr />
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </main>

            <?php include_once('../../layout/footer.php') ?>
        </div>
    </div>

    <?php include_once('../../layout/js.php') ?>
    <script src="<?= $url . ('/public/user/profile.min.js?q=') . time() ?>"></script>


</body>

</html>