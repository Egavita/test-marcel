<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>
<main style="margin-top: 20px;">
    <div class="container-fluid px-4 pt-4" style="background-color: #FFF5F9;">
        <h1 class="mb-4">DATA PRODUK</h1>
        <div class="card mb-4">
            <div class="card-body">
                <!-- Isi Detail -->
                <h3 class="card-title fw-bold">
                    <?= $result['Nama_Produk'] ?>
                </h3>
                <p class="card-text">Brand :
                    <?= $result['Brand_Produk'] ?>
                </p>
                <p class="card-text">Stok :
                    <?= $result['Qty'] ?>
                </p>
                <p class="card-text">Harga Produk :
                    <?= $result['Harga_Produk'] ?>
                </p>
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <a class="btn btn-dark" type="button" href="<?= base_url('Produk') ?>">Kembali</a>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
    </div>
    </div>
</main>
<?= $this->endSection() ?>