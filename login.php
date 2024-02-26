<!DOCTYPE html>
<html lang="en">
<?php include_once('view/layout/header.php');
session_start();
if (isset($_SESSION['user'])) {
    echo "<script>
    document.location.href='http://localhost:3000/index.php';
    </script>";
}
?>


<body>
    <main class="d-flex w-100">
        <div class="container d-flex flex-column">
            <div class="row vh-100">
                <div class="col-sm-10 col-md-8 col-lg-6 mx-auto d-table h-100">
                    <div class="d-table-cell align-middle">
                        <div class="row mb-3">
                            <div class="col text-center">
                                <img src="https://digsys.zekindo.co.id/vendors/images/ZEKINDO%20COMPANIES.png" alt="logo" width="200px">
                            </div>

                        </div>
                        <div class="row mt-2">
                            <div class="card mt-2">
                                <div class="card-header text-center">
                                    <h2 class="h2 fw-bold mb-3">
                                        HR & Flexy App
                                    </h2>
                                </div>
                                <div class="card-body">
                                    <div class="m-sm-4">
                                        <div class="text-center">

                                        </div>
                                        <form action="javascript:;" method="POST" id="formLogin">
                                            <div class="mb-3">
                                                <input type="hidden" name="_token" value="<?= $csrf_token ?>">
                                                <label class="form-label">Email</label>
                                                <input class="form-control form-control-lg" type="email" name="email" placeholder="Enter your email" required />
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Password</label>
                                                <input class="form-control form-control-lg" type="password" name="password" placeholder="Enter your password" required />
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
        </div>
    </main>

    <?php include_once('view/layout/js.php') ?>

    <script src="<?= ($url . '/public/js/login.js?q=') . time() ?>"></script>

</body>

</html>