<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion" style="background-color : #FFfffF">
        <div class="sb-sidenav-menu ">
            <div class="nav">
                <div class="sb-sidenav-menu-heading mt-4" style="color: #FF5197;">MAIN</div>
                <a class="nav-link" href="<?= base_url() ?>">
                    <div class="sb-nav-link-icon"><i class="fas fa-chart-simple"></i></div>
                    Home
                </a>
                <div class="sb-sidenav-menu-heading" style="color: #FF5197;">TRANSAKSI</div>

                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts"
                    ria-expanded="false" aria-controls="collapseLayouts">
                    <div class="sb-nav-link-icon"><i class="fas fa-money-bill"></i></div>
                    Masuk
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne"
                    data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="<?= base_url('jual') ?>">Transaksi</a>
                        <a class="nav-link" href="/jual/laporan">Laporan</a>
                    </nav>
                </div>

                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts2"
                    ria-expanded="false" aria-controls="collapseLayouts">
                    <div class="sb-nav-link-icon"><i class="fas fa-shopping-cart"></i></div>
                    Keluar
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseLayouts2" aria-labelledby="headingOne"
                    data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="<?= base_url('beli') ?>">Transaksi</a>
                        <a class="nav-link" href="/beli/laporan">Laporan</a>
                    </nav>
                </div>

                <div class="sb-sidenav-menu-heading" style="color: #FF5197;">Master</div>
                <?php if (session()->role == "Owner" || session()->role == "Owner"): ?>
                    <a class="nav-link" href="/Pengguna">
                        <div class="sb-nav-link-icon"><i class="fas fa-user fa-fw"></i></div>
                        Data Pengguna
                    </a>
                    <a class="nav-link" href="/Pelanggan">
                        <div class="sb-nav-link-icon"><i class="fas fa-user-group fa-fw"></i></div>
                        Data Pelanggan
                    </a>
                    <!-- <a class="nav-link" href="/supplier">
                            <div class="sb-nav-link-icon"><i class="fas fa-users fa-fw"></i></div>
                            Data Supplier
                        </a> -->
                    <a class="nav-link" href="/Layanan">
                        <div class="sb-nav-link-icon"><i class="fas fa-wheelchair-move fa-fw"></i></div>
                        Data Layanan
                    </a>
                    <a class="nav-link" href="/Produk">
                        <div class="sb-nav-link-icon"><i class="fas fa-bottle-droplet fa-fw"></i></div>
                        Data Produk
                    </a>
                <?php endif; ?>
                <?php if (session()->role == "Admin" || session()->role == "Admin"): ?>
                    <a class="nav-link" href="/Layanan">
                        <div class="sb-nav-link-icon"><i class="fas fa-Pengguna fa-fw"></i></div>
                        Data Layanan
                    </a>
                    <a class="nav-link" href="/Produk">
                        <div class="sb-nav-link-icon"><i class="fas fa-Pengguna fa-fw"></i></div>
                        Data Produk
                    </a>
                <?php endif ?>
            </div>
        </div>
    </nav>
</div>