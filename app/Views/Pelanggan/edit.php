<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?> 
<main style="margin-top: 20px;">
    <div class="container-fluid px-4 pt-4" style="background-color: #FFF5F9;">
        <h1 class="mb-4">DATA PELANGGAN</h1>
        <div class="card mb-4">
            <div class="card-body">
                <!-- Form Ubah Cust -->
                <form action="<?= base_url('Pelanggan/edit/' . $result['ID_Pelanggan']) ?>" method="POST">
                    <?= csrf_field() ?>
                    <div cLass="mb-3 row">
                        <label for="Nama_Pelanggan" class="col-sm-2 col-for m-label">Nama Lengkap</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" name="Nama_Pelanggan" value="<?= $result['Nama_Pelanggan'] ?>">
                        </div>
                        <label for="No_HP" class="col-sm-2 col-for m-label">Nomor HP</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" name="No_HP" value="<?= $result['No_HP'] ?>">
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
</main>
<?= $this->endSection() ?>