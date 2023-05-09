<!DOCTYPE html>
<html lang="en">
<?php include_once('view/layout/header.php');
include_once('app/config/config.php');
?>


<body>
    <main class="d-flex w-100">
        <div class="container d-flex flex-column">
            <div class="row vh-100">
                <div class="col-sm-10 col-md-8 col-lg-6 mx-auto d-table h-100">
                    <div class="d-table-cell align-middle">

                        <div class="text-center mt-4">

                            <h2 class="h2 fw-bold mb-3">
                                Sign in to your account to continue
                            </h2>
                        </div>

                        <div class="card">
                            <div class="card-body">
                                <div class="m-sm-4">
                                    <div class="text-center">

                                    </div>
                                    <form>
                                        <div class="mb-3">
                                            <input type="hidden" name="_token" value="<?= $csrf_token ?>">
                                            <label class="form-label">Email</label>
                                            <input class="form-control form-control-lg" type="email" name="email" placeholder="Enter your email" />
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Password</label>
                                            <input class="form-control form-control-lg" type="password" name="password" placeholder="Enter your password" />
                                            <small>
                                                <a href="index.html">Forgot password?</a>
                                            </small>
                                        </div>
                                        <div class="text-center mt-3">
                                            <!-- <a href="index.html" class="btn btn-lg btn-primary">Sign in</a> -->
                                            <button type="submit" class="btn btn-lg btn-primary">Sign in</button>
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

</body>

</html>