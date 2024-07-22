<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>
<?php $errors = validation_errors(); ?>
<main style="margin-top: 20px;">
    <div class="container-fluid px-4 pt-4" style="background-color: #FFF5F9;">
        <h1 class="mb-4">DATA PRODUK</h1>
        <div class="card mb-4">
            <div class="card-body">
                <!-- form tambah Produk -->
                <form action="Produk/edit/<?= $result['ID_Produk'] ?>" method="POST" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    <input type="hidden" name="ID_Produk" value="<?= $result['ID_Produk'] ?>">
                    <div class="mb-3 row">
                        <label for="Nama_Produk" class="col-sm-2 col-form-label">Nama Produk</label>
                        <div class="col-sm-4">
                            <input type="text"
                                class="form-control <?= isset($errors['Nama_Produk']) ? 'is-invalid' : '' ?>"
                                id="Nama_Produk" name="Nama_Produk"
                                value="<?= old('Nama_Produk', $result['Nama_Produk']) ?>">
                            <div id="validationServer03Feedback" class="invalid-feedback">
                                <?= validation_show_error('Nama_Produk') ?>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="Brand_Produk" class="col-sm-2 col-form-label">Brand Produk</label>
                        <div class="col-sm-4">
                            <input type="text"
                                class="form-control <?= isset($errors['Brand_Produk']) ? 'is-invalid' : '' ?>"
                                id="Brand_Produk" name="Brand_Produk"
                                value="<?= old('Brand_Produk', $result['Brand_Produk']) ?>">
                            <div id="validationServer03Feedback" class="invalid-feedback">
                                <?= validation_show_error('Brand_Produk') ?>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="Qty" class="col-sm-2 col-form-label">Stok</label>
                        <div class="col-sm-4">
                            <input type="number" class="form-control <?= isset($errors['Qty']) ? 'is-invalid' : '' ?>"
                                id="Qty" name="Qty" value="<?= old('Qty', $result['Qty']) ?>">
                            <div id="validationServer03Feedback" class="invalid-feedback">
                                <?= validation_show_error('Qty') ?>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="Harga_Produk" class="col-sm-2 col-form-label">Harga Produk</label>
                        <div class="col-sm-4">
                            <input type="text"
                                class="form-control <?= isset($errors['Harga_Produk']) ? 'is-invalid' : '' ?>"
                                id="Harga_Produk" name="Harga_Produk"
                                value="<?= old('Harga_Produk', $result['Harga_Produk']) ?>">
                            <div id="validationServer03Feedback" class="invalid-feedback">
                                <?= validation_show_error('Harga_Produk') ?>
                            </div>
                        </div>
                    </div>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button class="btn btn-primary me-md-2" type="submit">Perbarui</button>
                        <button class="btn btn-danger" type="button" id="resetAndGoBack">Batal</button>

                        <script>
                            document.getElementById("resetAndGoBack").addEventListener("click", function () {
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