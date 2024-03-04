<nav class="navbar navbar-expand navbar-light navbar-bg">
    <a class="sidebar-toggle js-sidebar-toggle">
        <i class="hamburger align-self-center"></i>
    </a>

    <div class="navbar-collapse collapse">
        <ul class="navbar-nav navbar-align">

            <li class="nav-item dropdown">
                <a class="nav-icon dropdown-toggle d-inline-block d-sm-none" href="#" data-bs-toggle="dropdown">
                    <i class="align-middle" data-feather="settings"></i>
                </a>

                <a class="nav-link d-none d-sm-inline-block">
                    <span class="text-dark">Remain Balance: <strong id="balance-limit"></strong></span>
                </a>
                <a class="nav-link dropdown-toggle d-none d-sm-inline-block" href="#" data-bs-toggle="dropdown">
                    <span class="text-dark"><?= $_SESSION['user']['name'] ?></span>
                </a>
                <div class="dropdown-menu dropdown-menu-end">
                    <a class="dropdown-item" href="<?= $url ?>/view/pages/user/profile.php"><i class="align-middle me-1" data-feather="user"></i> Profile</a>
                    <div class="dropdown-divider"></div>
                    <form action="<?= $url ?>/logout.php" method="post">
                        <button type="submit" class="logout border-0 p-2 mx-2">
                            Sign Out
                        </button>
                    </form>

                </div>
            </li>
        </ul>
    </div>
</nav>