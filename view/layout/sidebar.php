<nav id="sidebar" class="sidebar js-sidebar">
    <div class="sidebar-content js-simplebar">
        <a class="sidebar-brand" href="<?= $url ?>">
            <span class="align-middle">HR App</span>
        </a>

        <ul class="sidebar-nav">
            <li class="sidebar-item active">
                <a class="sidebar-link" href="<?= $url ?>">
                    <i class="align-middle" data-feather="sliders"></i> <span class="align-middle">Dashboard</span>
                </a>
            </li>

            <li class="sidebar-header">
                Menu
            </li>

            <li class="sidebar-item">
                <a class="sidebar-link" href="<?= $url ?>/view/pages/company/index.php">
                    <i class="align-middle" data-feather="square"></i> <span class="align-middle">Company Data</span>
                </a>
            </li>

            <li class="sidebar-item">
                <a class="sidebar-link" href="<?= $url ?>/view/pages/department/index.php">
                    <i class="align-middle" data-feather="check-square"></i> <span class="align-middle">Department Data</span>
                </a>
            </li>

            <li class="sidebar-item">
                <a class="sidebar-link" href="<?= $url ?>/view/pages/status/index.php">
                    <i class="align-middle" data-feather="grid"></i> <span class="align-middle">Employee Status</span>
                </a>
            </li>

            <li class="sidebar-item">
                <a class="sidebar-link" href="<?= $url ?>/view/pages/employee/index.php">
                    <i class="align-middle" data-feather="users"></i> <span class="align-middle">Employee</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a class="sidebar-link" href="<?= $url ?>/view/pages/employee/employee-resign.php">
                    <i class="align-middle" data-feather="users"></i> <span class="align-middle">Employee Resign</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a class="sidebar-link" href="<?= $url ?>/view/pages/employee/employee-reminder-contract.php">
                    <i class="align-middle" data-feather="clock"></i> <span class="align-middle">Contract Reminder</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a class="sidebar-link" href="<?= $url ?>/view/pages/employee/export.php">
                    <i class="align-middle" data-feather="file-text"></i> <span class="align-middle">Export Data</span>
                </a>
            </li>
            <?php if ($_SESSION['user']['roles'] == '1') : ?>
                <li class="sidebar-header">
                    Admin
                </li>

                <li class="sidebar-item">
                    <a class="sidebar-link" href="<?= $url ?>/view/pages/admin/user-management.php">
                        <i class="align-middle" data-feather="user"></i> <span class="align-middle">User Management</span>
                    </a>
                </li>
            <?php endif; ?>

            <li class="sidebar-header">
                Accounts
            </li>

            <li class="sidebar-item">
                <a class="sidebar-link" href="<?= $url ?>/view/pages/user/profile.php">
                    <i class="align-middle" data-feather="user"></i> <span class="align-middle">Profile</span>
                </a>
            </li>


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