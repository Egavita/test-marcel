<!-- ISI POS -->
<div class="modal fade" id="modalLayanan" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalToggleLabel">DATA LAYANAN</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Tabel Buku -->
                <table id="datatablesSimple">
                    <thead>
                        <tr>
                            <th width=10%>No</th>
                            <th width=15%>ID Layanan</th>
                            <th width=25%>Nama Layanan</th>
                            <th width=15%>Harga Layanan</th>
                            <th width=20%>Kategori Layanan</th>
                            <th width=20%>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;
                        foreach ($dataLayanan as $value): ?>
                            <tr>
                                <td>
                                    <?= $no++ ?>
                                </td>
                                <td>
                                    <?= $value['ID_Layanan'] ?>
                                </td>
                                <td>
                                    <?= $value['Nama_Layanan'] ?>
                                </td>
                                <td>
                                    <?= $value['Harga_Layanan'] ?>
                                </td>
                                <td>
                                    <?= $value['Nama_Kategori_Layanan'] ?>
                                </td>
                                <td>
                                    <button onclick="add_cart('<?= $value['ID_Layanan'] ?>',
                                    '<?= $value['Nama_Layanan'] ?>','<?= $value['Harga_Layanan'] ?>')"
                                        class="btn btn-success"><i class="fa fa-cart-plus"></i>Tambahkan</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <!-- END Tabel Buku -->
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- edit total layanan -->
<div class="modal fade" id="modalUbah" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalToggleLabel">UBAH JUMLAH PRODUK</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mt-3">
                    <div class="col-sm-7">
                        <input type="hidden" id="rowid">
                        <input type="number" id="qty" class="form-control" placeholder="Masukkan Jumlah Produk" min="1"
                            value="1">
                    </div>
                    <div class="col-sm-5">
                        <button class="btn btn-primary" onclick="update_cart()">Simpan</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> 

<!-- END ISI POS -->
<script>
    function add_cart(id, name, price) {
        $.ajax({
            url: "<?= base_url('jual/layanan') ?>",
            method: "POST",
            data: {
                id: id,
                name: name,
                qty: 1,
                price: price
            },
            success: function (data) {
                load()
            }
        });
    }

    function update_cart() {
        var rowid = $('#rowid').val();
        var qty = $('#qty').val();

        $.ajax({
            url: "<?= base_url('jual/update') ?>",
            method: "POST",
            data: {
                rowid: rowid,
                qty: qty,
            },
            success: function (data) {
                load();
                $('#modalUbah').modal('hide');
            }
        });
    }
</script>