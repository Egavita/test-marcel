<?= $this->extend('auth/template') ?>

<?= $this->section('content') ?>
<main>
    <div class="container">
        <div class="row justify-content-center align-items-center" style="height: 100vh;">
            <div class="col-lg-5">
                <div class="card shadow-lg border-0 rounded-lg" style="background-color: #FFD6E6;">
                    <div class="card-body">
                        <form action="/login/auth" method="post">
                            <?= csrf_field() ?>
                            <div class="form-floating mb-3">
                                <input class="form-control <?php if (session('msg')): ?>is-invalid<?php endif ?>"
                                    name="Username" placeholder="Username" type="text"
                                    style="background-color: #FFFfff">
                                <label for="inputEmail" style="color: #FF006F">Username</label>
                                <div class="invalid-feedback">
                                    <?= session('msg') ?>
                                </div>
                            </div>
                            <div class="form-floating mb-4">
                                <input class="form-control <?php if (session('msg')): ?>is-invalid<?php endif ?>"
                                    name="Password" type="Password" placeholder="Password"
                                    style="background-color: #FFfffF">
                                <label for="inputPassword" style="color: #FF006F">Password</label>
                                <div class="invalid-feedback">
                                    <?= session('msg') ?>
                                </div>
                            </div>
                            <!-- Button inside form -->
                            <div class="d-flex justify-content-center mb-4">
                                <button type="submit" class="btn btn-primary rounded-pill"
                                    style="height: 50px; width: 200px;">Login</button>
                            </div>
                        </form>
                        <!-- Link outside form -->
                        <div class="d-flex justify-content-center">
                            <div class="small" style="color : #FF5197">Sudah Punya Akun ? <a href="login/register"
                                    style="color : #FF006F">Registrasi</a></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</main>
<?= $this->endSection() ?>