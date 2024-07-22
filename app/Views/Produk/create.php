<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>
<main style="margin-top: 20px;">
    <div class="container-fluid px-4 pt-4" style="background-color: #FFF5F9;">
        <h1 class="mb-4">DATA PRODUK</h1>
        <div class="card mb-4">
            <div class="card-body">
                <!-- form tambah Produk -->
                <form action="/Produk/create" method="POST" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    <div class="mb-3 row">
                        <label for="Nama_Produk" class="col-sm-2 col-form-label">Nama Produk</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control <?= $validation->hasError('Nama_Produk') ? 'is-invalid' : '' ?>" id="Nama_Produk" name="Nama_Produk" value="<?= old('Nama_Produk') ?>">
                            <div id="validationServer03Feedback" class="invalid-feedback">
                                <?= $validation->getError('Nama_Produk') ?>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="Brand_Produk" class="col-sm-2 col-form-label">Brand Produk</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control <?= $validation->hasError('Brand_Produk') ? 'is-invalid' : '' ?>" id="Brand_Produk" name="Brand_Produk" value="<?= old('Brand_Produk') ?>">
                            <div id="validationServer03Feedback" class="invalid-feedback">
                                <?= $validation->getError('Brand_Produk') ?>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="Qty" class="col-sm-2 col-form-label">Stok</label>
                        <div class="col-sm-4">
                            <input type="number" class="form-control <?= $validation->hasError('Qty') ? 'is-invalid' : '' ?>" id="Qty" name="Qty" value="<?= old('Qty') ?>">
                            <div id="validationServer03Feedback" class="invalid-feedback">
                                <?= $validation->getError('Qty') ?>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="Harga_Produk" class="col-sm-2 col-form-label">Harga Produk</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control <?= $validation->hasError('Harga_Produk') ? 'is-invalid' : '' ?>" id="Harga_Produk" name="Harga_Produk" value="<?= old('Harga_Produk') ?>">
                            <div id="validationServer03Feedback" class="invalid-feedback">
                                <?= $validation->getError('Harga_Produk') ?>
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
                <!-- -->
            </div>
        </div>
    </div>
</main>
<?= $this->endSection() ?>