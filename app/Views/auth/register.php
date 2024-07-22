<?= $this->extend('auth/template') ?>

<?= $this->section('content') ?>
<main>
    <div class="container">
        <div class="row justify-content-center align-items-center" style="height: 100vh;">
            <div class="col-lg-5">
                <div class="card shadow-lg border-0 rounded-lg" style="background-color : #FFD6E6;">
                    <div class="card-body">
                        <?php if (isset($validation)) : ?>
                            <div class="alert alert-danger"><?= $validation->listErrors() ?></div>
                        <?php endif; ?>
                        <form action="/login/save" method="post">
                            <?= csrf_field() ?>
                            <div class="form-floating mb-3">
                                <input class="form-control <?php if(session('errors.username')) : ?>is-invalid<?php endif ?>"
                                    name="Username" placeholder="Username" value="<?= old('Username')?>" style="background-color : #FFfffF"/>
                                <label for="inputEmail" style="color: #FF006F">Username</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input class="form-control <?php if(session('errors.Nama_Pengguna')) : ?>is-invalid<?php endif ?>"
                                    name="Nama_Pengguna" placeholder="Nama_Pengguna" value="<?= old('Nama_Pengguna')?>" style="background-color : #FFfffF"/>
                                <label for="inputEmail" style="color: #FF006F">Nama Pengguna</label>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="form-floating mb-3 mb-md-0">
                                        <input type="Password" name="Password" class="form-control
                                        <?php if(session('errors.password')) : ?>is-invalid<?php endif ?>"
                                            placeholder="Password" autocomplete="off" style="background-color : #FFfffF"/>
                                        <label for="inputPassword" style="color: #FF006F">Password</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating mb-3 mb-md-3">
                                        <input type="Password" name="pass_confirm" class="form-control
                                        <?php if(session('errors.pass_confirm')) : ?>is-invalid<?php endif ?>"
                                            placeholder="Repeat Password" autocomplete="off" style="background-color : #FFfffF"/>
                                        <label for="inputPasswordConfirm" style="color: #FF006F">Ketik Ulang Password</label>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-center">
                                <button type="submit" class="btn btn-primary rounded-pill" style="height: 50px; width: 200px;">Registrasi</button>
                            </div>
                        </form>
                    </div>
                    <div class="d-flex justify-content-center mb-4">
                        <div class="small" style="color : #FF5197">Sudah Punya Akun ? <a href="/login" style="color : #FF006F">Login</a></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<?= $this->endSection() ?>
