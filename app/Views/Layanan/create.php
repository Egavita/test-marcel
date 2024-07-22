<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>
<main style="margin-top: 20px;">
    <div class="container-fluid px-4 pt-4" style="background-color: #FFF5F9;">
        <h1 class="mb-4">DATA LAYANAN</h1>
        <div class="card mb-4">
            <div class="card-body">
                <!-- Form Tambah User -->
                <!-- form tambah buku -->
                <form action="/Layanan/create" method="POST" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    <div class="mb-3 row">
                        <label for="title" class="col-sm-2 col-form-label">Nama Layanan</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control <?= $validation->hasError('Nama_Layanan') ? 'is-invalid' : '' ?>" id="Nama_Layanan" name="Nama_Layanan" value="<?= old('Nama_Layanan') ?>">
                            <div id="validationServer03Feedback" class="invalid-feedback">
                                <?= $validation->getError('Nama_Layanan') ?>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="ID_Kategori_Layanan" class="col-sm-2 col-form-label">Kategori</label>
                        <div class="col-sm-4">
                            <select class="form-control" name="ID_Kategori_Layanan">
                                <option value="1">Tester</option>
                                <option value="2">Coba</option>
                                <option value="3">Apa</option>
                                <option value="4">Aja</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="Harga_Layanan" class="col-sm-2 col-form-label">Harga Layanan</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control <?= $validation->hasError('Harga_Layanan') ? 'is-invalid' : '' ?>" id="Harga_Layanan" name="Harga_Layanan" value="<?= old('Harga_Layanan') ?>">
                            <div id="validationServer03Feedback" class="invalid-feedback">
                                <?= $validation->getError('Harga_Layanan') ?>
                            </div>
                        </div>
                    </div>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button class="btn btn-primary me-md-2" type="submit">Simpan</button>
                        <button class="btn btn-danger" type="button" id="resetAndGoBack">Batal</button>

<script>
document.getElementById("resetAndGoBack").addEventListener("click", function() {
  // Reset the form fields
  var form = document.querySelector('form');
  form.reset();

  // Go back to the previous page
  window.history.back();
});
</script>
                    </div>
                </form>
            </div>

        </div>

    </div>
    </div>
</main>
<?= $this->endSection() ?>