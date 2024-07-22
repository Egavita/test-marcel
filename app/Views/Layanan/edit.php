<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>
<?php $errors = validation_errors(); ?>
<main style="margin-top: 20px;">
    <div class="container-fluid px-4 pt-4" style="background-color: #FFF5F9;">
        <h1 class="mb-4">DATA LAYANAN</h1>
        <div class="card mb-4">
            <div class="card-body">
                <!-- form tambah buku -->
                <form action="/Layanan/edit/<?= $result['ID_Layanan'] ?>" method="POST" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    <input type="hidden" name="ID_Layanan" value="<?= $result['ID_Layanan'] ?>">
                    <div class="mb-3 row">
                        <label for="Nama_Layanan" class="col-sm-2 col-form-label">Nama Layanan</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control <?= isset($errors['Nama_Layanan']) ? 'is-invalid' : '' ?>" id="Nama_Layanan" name="Nama_Layanan" value="<?= old('Nama_Layanan',  $result['Nama_Layanan']) ?>">
                            <div id="validationServer03Feedback" class="invalid-feedback">
                                <?= validation_show_error('Nama_Layanan') ?>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="ID_Kategori_Layanan" class="col-sm-2 col-form-label">Kategori Layanan</label>
                        <div class="col-sm-4">
                            <select type="text" class="form-control" id="ID_Kategori_Layanan" name="ID_Kategori_Layanan">
                                <?php foreach ($category as $value) : ?>
                                    <option value="<?= $value['ID_Kategori_Layanan'] ?>" <?= $value['ID_Kategori_Layanan'] == $result['ID_Kategori_Layanan'] ? 'selected' : '' ?>>
                                        <?= $value['Nama_Kategori_Layanan'] ?> </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="Harga_Layanan" class="col-sm-2 col-form-label">Harga Layanan</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control <?= isset($errors['Harga_Layanan']) ? 'is-invalid' : '' ?>" id="Harga_Layanan" name="Harga_Layanan" value="<?= old('Harga_Layanan', $result['Harga_Layanan']) ?>">
                        </div>
                    </div>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button class="btn btn-primary me-md-2" type="submit">Perbarui</button>
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