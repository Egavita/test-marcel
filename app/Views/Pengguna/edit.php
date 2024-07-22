<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>
<main style="margin-top: 20px;">
    <div class="container-fluid px-4 pt-4" style="background-color: #FFF5F9;">
        <h1 class="mb-4">DATA PENGGUNA</h1>
        <div class="card mb-4">
            <div class="card-body">
                <!-- Form Ubah Pengguna -->
                <form action="<?= base_url('Pengguna/edit/' . $result['ID_Pengguna']) ?>" method="POST">
                    <?= csrf_field() ?>
                    <div class="mb-4 row">
                        <label for="Nama_Pengguna" class="col-sm-1 col-form-label">Nama</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" name="Nama_Pengguna"
                                value="<?= $result['Nama_Pengguna'] ?>">
                        </div>
                        <label for="Username" class="col-sm-1 col-form-label">Username</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" name="Username" value="<?= $result['Username'] ?>">
                        </div>
                        <label for="role" class="col-sm-1 col-form-label">Role</label>
                        <div class="col-sm-3">
                            <select class="form-control" name="role">
                                <option value="Admin" <?= $result['role'] == 'Admin' ? 'selected' : '' ?>>Admin</option>
                                <option value="Owner" <?= $result['role'] == 'Owner' ? 'selected' : '' ?>>Owner</option>
                            </select>
                        </div>
                    </div>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button class="btn btn-primary me-md-2" type="submit">Simpan</button>
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
            </div>
        </div>
    </div>
</main>
<?= $this->endSection() ?>