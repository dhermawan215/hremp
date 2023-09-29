<div class="row">

    <div class="card">
        <div class="card-body">
            <div class="row justify-content-center">
                <div class="col-md-2">
                    <div class="card">
                        <a href="<?= $url . ('/view/pages/employee/employee-personal.php?dataId=') . $_GET['dataId'] . '&dataStatus=' . $_GET['dataStatus'] ?>" class="btn btn-outline-primary <?= '2' == $dataContent  ?  'active' : ''; ?>">Pribadi</a>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="card">
                        <a href="<?= $url . ('/view/pages/employee/employee-personal-address.php?dataId=') . $_GET['dataId'] . '&dataStatus=' . $_GET['dataStatus'] ?>" class="btn btn-outline-primary <?= '3' == $dataContent  ?  'active' : ''; ?>">Alamat</a>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="card">
                        <a href="<?= $url . ('/view/pages/employee/employee-edu.php?dataId=') . $_GET['dataId'] . '&dataStatus=' . $_GET['dataStatus'] ?>" class="btn btn-outline-primary <?= '4' == $dataContent  ?  'active' : ''; ?>">Pendidikan</a>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="card">
                        <a href="<?= $url . ('/view/pages/employee/employee-family.php?dataId=') . $_GET['dataId'] . '&dataStatus=' . $_GET['dataStatus'] ?>" class="btn btn-outline-primary <?= '5' == $dataContent  ?  'active' : ''; ?>">Keluarga</a>
                    </div>
                </div>

            </div>
            <div class="row justify-content-center">
                <div class="col-md-2">
                    <div class="card">
                        <a href="<?= $url . ('/view/pages/employee/employee-emergency.php?dataId=') . $_GET['dataId'] . '&dataStatus=' . $_GET['dataStatus'] ?>" class="btn btn-outline-primary <?= '6' == $dataContent  ?  'active' : ''; ?>">Kontak Darurat</a>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="card">
                        <a href="<?= $url . ('/view/pages/employee/employee-payroll.php?dataId=') . $_GET['dataId'] . '&dataStatus=' . $_GET['dataStatus'] ?>" class="btn btn-outline-primary <?= '7' == $dataContent  ?  'active' : ''; ?>">Payroll</a>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="card">
                        <a href="<?= $url . ('/view/pages/employee/employee-experience.php?dataId=') . $_GET['dataId'] . '&dataStatus=' . $_GET['dataStatus'] ?>" class="btn btn-outline-primary <?= $dataContent == '9'  ?  'active' : ''; ?>">Pengalaman Kerja</a>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="card">
                        <a href="<?= $url . ('/view/pages/employee/employee-kontrak.php?dataId=') . $_GET['dataId'] . '&dataStatus=' . $_GET['dataStatus'] ?>" class="btn btn-outline-primary <?= '8' == $dataContent  ?  'active' : ''; ?>">Kontrak Kerja</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>