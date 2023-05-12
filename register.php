<!DOCTYPE html>
<html lang="en">
<?php include_once('view/layout/header.php'); ?>


<body>
    <main class="d-flex w-100">
        <div class="container d-flex flex-column">
            <div class="row vh-100">
                <div class="col-sm-10 col-md-8 col-lg-6 mx-auto d-table h-100">
                    <div class="d-table-cell align-middle">

                        <div class="text-center mt-4">

                            <h2 class="h2 fw-bold mb-3">
                                Register Account
                            </h2>
                        </div>

                        <div class="card">
                            <div class="card-body">
                                <div class="m-sm-4">
                                    <div class="text-center">

                                    </div>
                                    <form action="javascript:;" id="registerForm" method="POST">
                                        <div class="mb-3">
                                            <?php $csrf_token = md5(uniqid(mt_rand(), true)); ?>
                                            <input type="hidden" name="_token" value="<?= $csrf_token ?>">
                                            <label class="form-label">Name</label>
                                            <input class="form-control form-control-lg" type="text" name="name" placeholder="Enter your name" required />
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Email</label>
                                            <input class="form-control form-control-lg" type="email" name="email" placeholder="Enter your email" required />
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Password</label>
                                            <input class="form-control form-control-lg" type="password" name="password" placeholder="Enter your password" required />
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Password Confirmation</label>
                                            <input class="form-control form-control-lg" type="password" name="password_confirmation" placeholder="Reenter your password" required />
                                        </div>
                                        <div class="text-center mt-3">
                                            <button type="submit" class="btn btn-lg btn-primary" name="btnregister">Register</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php include_once('view/layout/js.php') ?>
    <script src="<?= ('/public/js/login.js?q=') . time() ?>"></script>

</body>

</html>