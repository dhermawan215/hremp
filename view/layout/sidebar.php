<nav id="sidebar" class="sidebar js-sidebar">
    <div class="sidebar-content js-simplebar">
        <a class="sidebar-brand" href="<?= $url ?>">
            <span class="align-middle"><?= isset($appName) ? $appName : 'HR & Flexy Allowance App' ?></span>
        </a>

        <ul class="sidebar-nav">
            <!-- logika jika user admin/hr maka menu dashboard akan menuju hr app -->
            <?php
            if ($_SESSION['user']['roles'] == '1' || $_SESSION['user']['roles'] == '2') {
                $dashboardUrl = $url;
            }
            // <!-- logika tidak maka menu dashboard akan menuju flexy allowance-->
            else {
                $dashboardUrl = $url . '/view/flexy-allowance/flexy.php';
            }
            // cek route menu aktif
            if (($_SESSION['user']['roles'] == '1' || $_SESSION['user']['roles'] == '2') && (isset($route) && $route == 'dashboard')) {
                $active = 'active';
            }
            if ($_SESSION['user']['roles'] == '3' && isset($route) == 'flexy-app-dashboard') {
                $active = 'active';
            }
            ?>
            <li class="sidebar-item <?= $active ?>">

                <a class="sidebar-link" href="<?= $dashboardUrl ?>">
                    <i class="align-middle" data-feather="sliders"></i> <span class="align-middle">Dashboard</span>
                </a>
            </li>
            <!-- menu dashboard flexy akan muncul jika user admin/hr start-->
            <?php if ($_SESSION['user']['roles'] == '1' || $_SESSION['user']['roles'] == '2') : ?>
                <!-- cek menu aktif admin/hr flexy -->
                <?php
                if (isset($route) && $route == 'flexy-app-dashboard') {
                    $activeFlexy = 'active';
                }
                ?>
                <!-- cek menu aktif admin/hr flexy -->
                <li class="sidebar-item <?= $activeFlexy ?>">

                    <a class="sidebar-link" href="<?= $url ?>/view/flexy-allowance/flexy.php">
                        <i class="align-middle" data-feather="sliders"></i> <span class="align-middle">Dashboard Flexy</span>
                    </a>
                </li>
            <?php endif; ?>
            <!-- menu dashboard flexy akan muncul jika user admin/hr end-->

            <!-- menu flexy allowance start(user) -->
            <li class="sidebar-item">
                <a data-bs-target="#pages" data-bs-toggle="collapse" class="sidebar-link collapsed" aria-expanded="false"><i class="align-middle" data-feather="square"></i>Flexy Allowance</a>
                <ul id="pages" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="<?= $url ?>/view/flexy-allowance/allowance-user-index.php">
                            <span class="align-middle">View My Request</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="<?= $url ?>/view/flexy-allowance/allowance-create.php">
                            <span class="align-middle">Add Request</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="#">
                            <span class="align-middle">Transaction History</span>
                        </a>
                    </li>

                </ul>
            </li>
            <!-- menu flexy allowance end(user)-->

            <?php if ($_SESSION['user']['roles'] == '1' || $_SESSION['user']['roles'] == '2') : ?>
                <li class="sidebar-header">
                    Flexy Allowance Menu
                </li>
                <li class="sidebar-item">
                    <a data-bs-target="#pages" data-bs-toggle="collapse" class="sidebar-link collapsed" aria-expanded="false"><i class="align-middle" data-feather="square"></i>HR Allowance Panel</a>
                    <ul id="pages" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="<?= $url ?>/view/hr-panel/allowance-need-check.php">
                                <span class="align-middle">Need Approval</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="<?= $url ?>/view/hr-panel/allowance-approve.php">
                                <span class="align-middle">Approve/Checked</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <?php if ($_SESSION['user']['email'] == 'yana@zekindo.com') : ?>
                    <li class="sidebar-item">
                        <a data-bs-target="#pages" data-bs-toggle="collapse" class="sidebar-link collapsed" aria-expanded="false"><i class="align-middle" data-feather="square"></i>Director Allowance Panel</a>
                        <ul id="pages" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                            <li class="sidebar-item">
                                <a class="sidebar-link" href="#">
                                    <span class="align-middle">Need Approval</span>
                                </a>
                            </li>
                            <li class="sidebar-item">
                                <a class="sidebar-link" href="#">
                                    <span class="align-middle">Approve/Checked</span>
                                </a>
                            </li>
                            <li class="sidebar-item">
                                <a class="sidebar-link" href="#">
                                    <span class="align-middle">Report</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php endif; ?>

                <li class="sidebar-header">
                    Menu
                </li>
                <!-- cek menu aktif company start -->
                <?php
                if (isset($route) && $route == 'company') {
                    $activeCompany = 'active';
                }
                ?>
                <li class="sidebar-item <?= $activeCompany ?>">
                    <a class="sidebar-link" href="<?= $url ?>/view/pages/company/index.php">
                        <i class="align-middle" data-feather="square"></i> <span class="align-middle">Company Data</span>
                    </a>
                </li>
                <!-- cek menu aktif company end -->

                <!-- cek menu aktif department start -->
                <?php
                if (isset($route) && $route == 'department') {
                    $activeDept = 'active';
                }
                ?>
                <li class="sidebar-item <?= $activeDept ?>">
                    <a class="sidebar-link" href="<?= $url ?>/view/pages/department/index.php">
                        <i class="align-middle" data-feather="check-square"></i> <span class="align-middle">Department Data</span>
                    </a>
                </li>
                <!-- cek menu aktif department end -->

                <!-- cek menu aktif status employee start -->
                <?php
                if (isset($route) && $route == 'status') {
                    $activeStatus = 'active';
                }
                ?>
                <li class="sidebar-item <?= $activeStatus ?>">
                    <a class="sidebar-link" href="<?= $url ?>/view/pages/status/index.php">
                        <i class="align-middle" data-feather="grid"></i> <span class="align-middle">Employee Status</span>
                    </a>
                </li>
                <!-- cek menu aktif status employee end -->

                <!-- cek menu aktif  employee start -->
                <?php
                if (isset($route) && $route == 'employee') {
                    $activeEmp = 'active';
                }
                ?>
                <li class="sidebar-item <?= $activeEmp ?>">
                    <a class="sidebar-link" href="<?= $url ?>/view/pages/employee/index.php">
                        <i class="align-middle" data-feather="users"></i> <span class="align-middle">Employee</span>
                    </a>
                </li>
                <!-- cek menu aktif  employee end -->

                <!-- cek menu aktif  employee resign start -->
                <?php
                if (isset($route) && $route == 'employee-resign') {
                    $activeEmpResign = 'active';
                }
                ?>
                <li class="sidebar-item <?= $activeEmpResign ?>">
                    <a class="sidebar-link" href="<?= $url ?>/view/pages/employee/employee-resign.php">
                        <i class="align-middle" data-feather="users"></i> <span class="align-middle">Employee Resign</span>
                    </a>
                </li>
                <!-- cek menu aktif  employee resign start -->

                <!-- cek menu aktif  contract reminder start -->
                <?php
                if (isset($route) && $route == 'contract-reminder') {
                    $activeContract = 'active';
                }
                ?>
                <li class="sidebar-item <?= $activeContract ?>">
                    <a class="sidebar-link" href="<?= $url ?>/view/pages/employee/employee-reminder-contract.php">
                        <i class="align-middle" data-feather="clock"></i> <span class="align-middle">Contract Reminder</span>
                    </a>
                </li>
                <!-- cek menu aktif  contract reminder end -->

                <!-- cek menu aktif  export data start -->
                <?php
                if (isset($route) && $route == 'export') {
                    $activeExport = 'active';
                }
                ?>
                <li class="sidebar-item <?= $activeExport ?>">
                    <a class="sidebar-link" href="<?= $url ?>/view/pages/employee/export.php">
                        <i class="align-middle" data-feather="file-text"></i> <span class="align-middle">Export Data</span>
                    </a>
                </li>
                <!-- cek menu aktif  export data end -->

                <!-- cek menu aktif  doc start -->
                <li class="sidebar-header">
                    Documents
                </li>
                <?php
                if (isset($route) && $route == 'doc') {
                    $activeDoc = 'active';
                }
                ?>
                <li class="sidebar-item <?= $activeDoc ?>">
                    <a class="sidebar-link" href="<?= $url ?>/view/pages/docs/docs.php">
                        <i class="align-middle" data-feather="file-text"></i> <span class="align-middle">Documents</span>
                    </a>
                </li>
                <!-- cek menu aktif  doc end -->
                <li class="sidebar-header">
                    Master Data Flexy Allowance
                </li>
                <!-- cek menu aktif  master aktivitas start -->
                <?php
                if (isset($route) && $route == 'aktivitas') {
                    $activeAktivitas = 'active';
                }
                ?>
                <li class="sidebar-item <?= $activeAktivitas ?>">
                    <a class="sidebar-link" href="<?= $url ?>/view/admin-flexy/aktivitas-index.php">
                        <i class="align-middle" data-feather="file-text"></i> <span class="align-middle">Master Activity</span>
                    </a>
                </li>
                <!-- cek menu aktif  master aktivitas end -->

                <!-- cek menu aktif  master account-limit start -->
                <?php
                if (isset($route) && $route == 'account-limit') {
                    $activeAccountLimit = 'active';
                }
                ?>
                <li class="sidebar-item <?= $activeAccountLimit ?>">
                    <a class="sidebar-link" href="<?= $url ?>/view/admin-flexy/account-limit-index.php">
                        <i class="align-middle" data-feather="file-text"></i> <span class="align-middle">Account Limit</span>
                    </a>
                </li>
                <!-- cek menu aktif  master account-limit end -->

                <!-- cek menu aktif  master allowance-limit start -->
                <?php
                if (isset($route) && $route == 'allowance-limit') {
                    $activeAllowanceLimit = 'active';
                }
                ?>
                <li class="sidebar-item <?= $activeAllowanceLimit ?>">
                    <a class="sidebar-link" href="<?= $url ?>/view/admin-flexy/allowance-limit-index.php">
                        <i class="align-middle" data-feather="file-text"></i> <span class="align-middle">Allowance Limit</span>
                    </a>
                </li>
                <!-- cek menu aktif  master allowance-limit start -->
                <!-- cek menu aktif  master cost center start -->
                <?php
                if (isset($route) && $route == 'cost-center') {
                    $activeCostCenter = 'active';
                }
                ?>
                <li class="sidebar-item <?= $activeCostCenter ?>">
                    <a class="sidebar-link" href="<?= $url ?>/view/admin-flexy/cost-center-index.php">
                        <i class="align-middle" data-feather="dollar-sign"></i> <span class="align-middle">Cost Center</span>
                    </a>
                </li>
                <!-- cek menu aktif  master cost center start -->
            <?php endif; ?>

            <?php if ($_SESSION['user']['roles'] == '1') : ?>
                <li class="sidebar-header">
                    Admin
                </li>
                <!-- cek menu aktif user management start -->
                <?php
                if (isset($route) && $route == 'users-mg') {
                    $activeUsers = 'active';
                }
                ?>
                <li class="sidebar-item <?= $activeUsers ?>">
                    <a class="sidebar-link" href="<?= $url ?>/view/pages/admin/user-management.php">
                        <i class="align-middle" data-feather="user"></i> <span class="align-middle">User Management</span>
                    </a>
                </li>
                <!-- cek menu aktif user management end -->
            <?php endif; ?>

            <li class="sidebar-header">
                Accounts
            </li>
            <!-- cek menu aktif profile start -->
            <?php
            if (isset($route) && $route == 'profile') {
                $activeProfile = 'active';
            }
            ?>
            <li class="sidebar-item <?= $activeProfile ?>">
                <a class="sidebar-link" href="<?= $url ?>/view/pages/user/profile.php">
                    <i class="align-middle" data-feather="user"></i> <span class="align-middle">Profile</span>
                </a>
            </li>
            <!-- cek menu aktif profile end -->


            <li class="sidebar-item">
                <form action="<?= $url ?>/logout.php" method="post">
                    <button type="submit" class="logout sidebar-link border-0">
                        <i class="align-middle" data-feather="log-out"></i> <span class="align-middle">Sign Out</span>
                    </button>
                </form>
            </li>

        </ul>

    </div>
</nav>