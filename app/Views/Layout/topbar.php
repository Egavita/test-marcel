<nav class="sb-topnav navbar navbar-expand navbar-dark"
    style="background-color: #FFFFFF; height: 80px; display: flex; align-items: center; justify-content: start;">
    <!-- Navbar Brand with Increased Padding -->
    <a class="navbar-brand ps-3" href="index.html" style="padding-top: 20px; padding-bottom: 20px;">
        <h3 class="fw-bold" style="color: #FF006F; margin-bottom: 0;">De'Hannias</h3>
    </a>
    <!-- Sidebar Toggle -->
    <button class="btn btn-link btn-sm order-1 order-lg-0 me-3 me-lg-0" id="sidebarToggle" href="#!">
        <i class="fa-solid fa-bars" style="color: #FF5197;"></i></button>
    <!-- Dashboard Heading -->
    <h5 style="color: #333232; margin-bottom: 0;  margin-left: 20px;">Selamat Datang Kembali</h5>

    <!-- Navbar Search -->
    <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
        <div class="input-group">
            <input class="form-control" type="text" placeholder="Search for..." aria-label="Search for..."
                aria-describedby="btnNavbarSearch" />
        </div>
    </form>
    <!-- User Role and Navbar Items -->
    <div class="text-dark">
        <?= session()->role ?>
    </div>
    <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown"
                aria-expanded="false" style="color: #333232; fw-bold;">
                <i class="fa-solid fa-user" style="color: #FF5197;"></i>
                <?= session()->username ?>
            </a>
            <ul class="dropdown-menu dropdown-menu-end shadow-sm" aria-labelledby="navbarDropdown">
                <li><a class="dropdown-item" href="#!">Settings</a></li>
                <li><a class="dropdown-item" href="#!">Activity Log</a></li>
                <li><a class="dropdown-item" href="/logout">Logout</a></li>
            </ul>
        </li>
    </ul>
</nav>