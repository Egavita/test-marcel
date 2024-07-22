<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>
<main style="margin-top: 20px;">
    <div class="container-fluid px-4 pt-4" style="background-color: #FFF5F9;">
        <h1 class="mb-4">DATA LAYANAN</h1>
        <div class="card mb-4">
            <div class="card-body">
                <!-- Isi Detail -->
                <h3 class="card-title fw-bold">
                    <?= $result['Nama_Layanan'] ?>
                </h3>
                <p class="card-text">Harga Layanan:
                    <?= $result['Harga_Layanan'] ?>
                </p>
                <p class="card-text">Kategori:
                    <?= $result['Nama_Kategori_Layanan'] ?>
                </p>
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <a class="btn btn-dark" type="button" href="<?= base_url('Layanan') ?>">Kembali</a>
                </div>
            </div>
        </div>
    </div>
</main>
<?= $this->endSection() ?>