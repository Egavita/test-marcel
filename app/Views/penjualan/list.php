<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<main style="margin-top: 20px;">
    <div class="container-fluid px-4 pt-4" style="background-color: #FFF5F9;">
        <h1 class="mb-4">
            <?= strtoupper($title) ?>
        </h1>
        <div class="card mb-4">
            <div class="card-body">
                <!-- ISI POS -->
                <div class="row">
                    <div class="col-md-auto" style="flex: 1;">
                        <label class="col-form-label">Tanggal</label>
                        <input type="text" class="form-control" value="<?= date('d/m/Y') ?>" disabled
                            style="width: 110px">
                    </div>
                    <div class="col-md-auto" style="flex: 1;">
                        <label class="col-form-label">User</label>
                        <input type="text" class="form-control" value="<?= session()->Username ?>" disabled
                            style="width: 120px">
                    </div>
                    <div class="col-md-auto" style="flex: 1;">
                        <label class="col-form-label">Pelanggan</label>
                        <input type="text" class="form-control" id="Nama_Pelanggan" disabled style="width: 150px">
                        <input type="hidden" id="ID_Pelanggan">
                    </div>
                    <div class="col-md-auto" style="flex: 1;">
                        <label class="col-form-label">Produk</label>
                        <input type="text" class="form-control" id="Nama_Produk" disabled>
                        <input type="hidden" id="ID_Produk">
                    </div>
                    <div class="col-md-3" style="flex: 1;">
                        <div style="display: flex; gap: 10px;">
                            <button class="btn btn-primary" data-bs-target="#modalLayanan" data-bs-toggle="modal"
                                style="width: 150px;">Pilih Layanan</button>
                            <button class="btn btn-danger" data-bs-target="#modalProduk" data-bs-toggle="modal"
                                style="width: 150px;">Pilih Produk</button>
                        </div>
                        <button class="btn btn-dark" data-bs-target="#modalPelanggan" data-bs-toggle="modal"
                            style="width: 282px; margin-top: 10px;">Cari Pelanggan</button>
                    </div>
                </div>

                <table class="table table-striped table-hover mt-4">
                    <thead>
                        <tr>
                            <th>No Transaksi</th>
                            <th>Layanan</th>
                            <th>Jumlah</th>
                            <th>Harga Satuan</th>
                            <th>Total Harga</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="detail_cart"></tbody>
                </table>

                <div class="container">
                    <div class="row">
                        <div class="col-8">
                            <label class="col-form-label">Total Bayar</label>
                            <h1><span id="spanTotal">0</span></h1>
                        </div>
                        <div class="col-4">
                            <div class="mb-3 row">
                                <label class="col-4 col-form-label">Nominal</label>
                                <div class="col-8">
                                    <input type="text" class="form-control" id="nominal" autocomplete="off">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-4 col-form-label">Kembalian</label>
                                <div class="col-8">
                                    <input type="text" class="form-control" id="kembalian" disabled>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-grid gap-3 d-md-flex justify-content-md-end">
                        <button onclick="bayar()" class="btn btn-success me-md-2" type="button">Proses Bayar</button>
                        <button onclick="location.reload()" class="btn btn-primary" type="button">Transaksi
                            Baru</button>
                    </div>
                </div>
                <!-- END ISI POS -->
            </div>
        </div>
    </div>
</main>
<?= $this->include('penjualan/modal-layanan') ?>
<?= $this->include('penjualan/modal-produk') ?>
<?= $this->include('penjualan/modal-pelanggan') ?>
<script>
    function load() {
        $('#detail_cart').load("<?= base_url('jual/load') ?>");
        $('#spanTotal').load("<?= base_url('jual/gettotal') ?>");
    }

    $(document).ready(function () {
        load();
    });

    // Ubah Jumlah Item
    $(document).on('click', '.ubah_cart', function () {
        var row_id = $(this).attr("id");
        var qty = $(this).attr("qty");
        $('#rowid').val(row_id);
        $('#qty').val(qty);
        $('#modalUbah').modal('show');
    });

    // Hapus Item Cart
    $(document).on('click', '.hapus_cart', function () {
        var row_id = $(this).attr("id");
        $.ajax({
            url: "<?= base_url('jual') ?>/" + row_id,
            method: "DELETE",
            success: function (data) {
                load();
            }
        });
    });

    function bayar() {
        var nominal = $('#nominal').val();
        var ID_Pelanggan = $('#ID_Pelanggan').val();
        var ID_Produk = $('#ID_Produk').val();

        var dataToSend = {
            'nominal': nominal,
            'ID_Pelanggan': ID_Pelanggan,
        };

        // Always include ID_Produk in the data, even if it's not selected
        dataToSend['ID_Produk'] = ID_Produk;

        $.ajax({
            url: "<?= base_url('jual/bayar') ?>",
            method: "POST",
            data: dataToSend,
            success: function (response) {
                var result = JSON.parse(response);
                swal({
                    title: result.msg,
                    icon: result.status ? "success" : "error",
                });
                load();
                $('#nominal').val("");
                $('#kembalian').val(result.data.kembalian);
            }
        });
    }

</script>
<?= $this->endSection() ?>